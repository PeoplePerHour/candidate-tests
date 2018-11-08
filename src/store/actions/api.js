import _ from 'lodash';

import {
  ENDPOINTS,
  actionCreatorRequest,
  createApiActionTypes
} from './../../lib/network';

export { API_REQUEST } from './../../lib/network';
export const API_CHARACTERS_FETCH = createApiActionTypes('API', 'CHARACTERS_FETCH');

export const normalizeCharacters = response => response;

export const fetchCharacters = (search) => (dispatch, getState) => {
  return actionCreatorRequest(API_CHARACTERS_FETCH, ENDPOINTS.get.characters, {}, search, {}, normalizeCharacters)
    .then(response => _.get(response, 'results', {}));
};

export default {
  fetchCharacters
};
