import fetch from 'cross-fetch';

import { normalize } from 'normalizr';
import { camelizeKeys } from 'humps';
import { API_ROOT } from '../constants/endpoints';
import { CALL_API } from '../constants/actionTypes';
import qs from 'qs';

// Fetches an API response and normalizes the result JSON according to schema.
// This makes every API response have the same shape, regardless of how nested it was.
const callApi = (endpoint, schema, params) => {
  let fullUrl =
    endpoint.indexOf(API_ROOT) === -1 ? API_ROOT + endpoint : endpoint;
  if (params) {
    fullUrl = fullUrl + '?' + qs.stringify(params);
  }

  return fetch(fullUrl).then(response =>
    response.json().then(json => {
      if (!response.ok) {
        return Promise.reject(json);
      }

      const camelizedJson = camelizeKeys(json);

      return {
        ...normalize(camelizedJson, schema)
      };
    })
  );
};

// A Redux middleware that interprets actions with CALL_API info specified.
// Performs the call and promises when such actions are dispatched.
export default store => next => action => {
  const callAPI = action[CALL_API];
  if (typeof callAPI === 'undefined') {
    return next(action);
  }

  let { endpoint } = callAPI;
  const { schema, types, params } = callAPI;

  if (typeof endpoint === 'function') {
    endpoint = endpoint(store.getState());
  }

  if (typeof endpoint !== 'string') {
    throw new Error('Specify a string endpoint URL.');
  }
  if (!schema) {
    throw new Error('Specify one of the exported Schemas.');
  }
  if (!Array.isArray(types) || types.length !== 3) {
    throw new Error('Expected an array of three action types.');
  }
  if (!types.every(type => typeof type === 'string')) {
    throw new Error('Expected action types to be strings.');
  }

  const actionWith = data => {
    const finalAction = { ...action, ...data };
    delete finalAction[CALL_API];
    return finalAction;
  };

  const [requestType, successType, failureType] = types;
  next(actionWith({ type: requestType }));

  return callApi(endpoint, schema, params).then(
    response =>
      next(
        actionWith({
          response,
          type: successType
        })
      ),
    error =>
      next(
        actionWith({
          type: failureType,
          error: true,
          message: error.error || 'Something bad happened'
        })
      )
  );
};
