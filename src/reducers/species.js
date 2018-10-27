import transform from 'lodash.transform';

import {
  FETCH_CHARACTERS_REQUEST,
  FETCH_CHARACTERS_SUCCESS,
  FETCH_CHARACTERS_FAILURE
} from '../constants/actionTypes';

export const STATE_KEY = 'species';

const species = (state = [], action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return state;
    case FETCH_CHARACTERS_SUCCESS:
      const newSpecies = transform(
        action.response.entities.characters,
        (curr, n) => {
          const idx1 = state.indexOf(n.species);
          const idx2 = curr.indexOf(n.species);
          if (idx1 > -1 || idx2 > -1) {
            return curr;
          }
          curr.push(n.species);
          return curr;
        },
        []
      );
      return [...state, ...newSpecies];
    case FETCH_CHARACTERS_FAILURE:
    default:
      return state;
  }
};

export const getSpecies = state => state[STATE_KEY];

export default species;
