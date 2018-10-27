import {
  FETCH_CHARACTERS_REQUEST,
  FETCH_CHARACTERS_SUCCESS,
  FETCH_CHARACTERS_FAILURE
} from '../constants/actionTypes';

import { Schemas } from '../constants/schemas';
import { CHARACTERS_URI } from '../constants/endpoints';
import { CALL_API } from '../constants/actionTypes';

const getCharacters = (params = { page: 1 }) => ({
  [CALL_API]: {
    method: 'GET',
    endpoint: CHARACTERS_URI,
    params,
    schema: Schemas.CHARACTER_ARRAY,
    types: [
      FETCH_CHARACTERS_REQUEST,
      FETCH_CHARACTERS_SUCCESS,
      FETCH_CHARACTERS_FAILURE
    ]
  }
});

export const fetchCharacters = params => dispatch =>
  dispatch(getCharacters(params));
