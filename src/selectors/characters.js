import { createSelector } from 'reselect';
import { STATE_KEY } from '../reducers/characters';

const byId = state => state[STATE_KEY].byId;
const allIds = state => state[STATE_KEY].allIds;
const paginationInfo = state => state[STATE_KEY].paginationInfo;
const isFetching = state => state[STATE_KEY].isFetching;

export const getCharacters = createSelector([byId, allIds], (characters, ids) =>
  ids.map(id => characters[id])
);

export const getCharacterById = createSelector(
  [byId, (state, id) => id],
  (characters, id) => characters[id]
);

export const getCharacterPaginationInfo = createSelector(
  [paginationInfo],
  info => info
);

export const getCharactersIsFetching = createSelector(
  [isFetching],
  fetching => fetching
);
