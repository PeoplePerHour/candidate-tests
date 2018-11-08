import _ from 'lodash';
import fetch from 'isomorphic-fetch';

import { store } from '../store/configureStore';
import { getReadableStreamResponse } from './helpers';

export const PROTOCOL = 'https:';
export const HOST = 'rickandmortyapi.com/api';

export const CORS_BYPASS = 'https://cors-anywhere.herokuapp.com/';

export const ENDPOINTS = {
  get: {
    // List characters
    characters: {
      pathname: '/character',
      params: []
    }
  }
};

export const createApiActionTypes = (prefix, suffix) => {
  const PREFIX = prefix.toUpperCase();
  const SUFFIX = suffix.toUpperCase();

  return {
    REQUEST: `${PREFIX}/${SUFFIX}_REQUEST`,
    SUCCESS: `${PREFIX}/${SUFFIX}_SUCCESS`,
    FAILURE: `${PREFIX}/${SUFFIX}_FAILURE`,
  };
};

export const API_REQUEST = createApiActionTypes('API', 'REQUEST');

export const buildRequestInput = (endpoint, params = {}, search) => {
  const pathname = endpoint.params.reduce((pathname, key) => {
    return pathname.replace(`:${key}`, params[ key ])
  }, endpoint.pathname);

  return `${CORS_BYPASS}${PROTOCOL}//${HOST}${pathname}${search}`;
};

export const request = (input, init = {}) => {
  store.dispatch({ type: API_REQUEST.REQUEST, input, init });

  init.mode = 'cors';
  init.headers = init.headers ? init.headers : new Headers();

  const request = new Request(input, init);

  return fetch(request)
    .then(checkStatus)
    .then(attemptParseJson)
    .then((response) => {
      store.dispatch({ type: API_REQUEST.SUCCESS, response });

      return response;
    })
    .catch((error) => {
      store.dispatch({ type: API_REQUEST.FAILURE, error });
    });
};

export const actionCreatorRequest = (apiActionType, endpoint, params = {}, search = '', init = {}, responseTransformer = r => r) => {
  const input = buildRequestInput(endpoint, params, search);
  store.dispatch({ type: apiActionType.REQUEST, input, params, search, init });

  return request(input, init)
    .then(response_ => {
      const response = responseTransformer(response_);

      store.dispatch({ type: apiActionType.SUCCESS, response, params });

      return response;
    })
    .catch((error) => {
      store.dispatch({ type: apiActionType.FAILURE, error });
      throw error;
    });
};

export const checkStatus = response => {
  if (response.status >= 200 && response.status < 300) {
    return response
  }

  const isJson = _.includes(response.headers.get('content-type'), 'application/json');

  return Promise.resolve(getReadableStreamResponse(response.body))
    .then(body => {
      let errorMessage = body;

      if (isJson) {
        const body_ = JSON.parse(body);
        errorMessage = body_.message || body_.error;
      }

      const error = new Error(`${errorMessage}`);

      error.response = response;

      throw error;
    });
};

export const attemptParseJson = response => {
  return _.isFunction(response.json) && !_.includes([201, 202, 204], response.status) ? response.json() : response;
};
