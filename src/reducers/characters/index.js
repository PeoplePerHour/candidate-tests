import {
  FETCH_CHARACTERS_REQUEST,
  FETCH_CHARACTERS_SUCCESS,
  FETCH_CHARACTERS_FAILURE
} from '../../constants/actionTypes';

import { combineReducers } from 'redux';

export const STATE_KEY = 'characters';

const isFetching = (state = false, action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return true;
    case FETCH_CHARACTERS_SUCCESS:
    case FETCH_CHARACTERS_FAILURE:
      return false;
    default:
      return state;
  }
};

const allIds = (state = [], action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return state;
    case FETCH_CHARACTERS_SUCCESS:
      return [...action.response.result.results];
    case FETCH_CHARACTERS_FAILURE:
    default:
      return state;
  }
};

const paginationInfo = (state = {}, action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return state;
    case FETCH_CHARACTERS_SUCCESS:
      return {
        ...action.response.result.info
      };
    case FETCH_CHARACTERS_FAILURE:
    default:
      return state;
  }
};

const byId = (state = {}, action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return state;
    case FETCH_CHARACTERS_SUCCESS:
      return {
        ...action.response.entities.characters
      };
    case FETCH_CHARACTERS_FAILURE:
    default:
      return state;
  }
};

const characters = combineReducers({
  byId,
  allIds,
  paginationInfo,
  isFetching
});

export default characters;
