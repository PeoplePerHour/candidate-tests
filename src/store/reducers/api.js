import _ from 'lodash';

import {
  API_REQUEST,
  API_CHARACTERS_FETCH
} from '../actions/api';

import { gender, species, status } from '../../data';

import { getPaginationFromInfo } from '../../lib/helpers';

export const defaultState = {
  data: {
    gender,
    species,
    status,
    characters: [],
  },
  communication: {
    fetching: false,
    error: null
  },
  pagination: {
    count: null,
    pages: null,
    next: 0,
    current: 0,
    prev: 0
  }
};

export default (state = Object.assign({}, defaultState), action) => {
  switch (action.type) {
    case API_REQUEST.REQUEST:
      state.communication = _.assign({}, state.communication, {fetching: true, error: null});
      return _.assign({}, state);

    case API_CHARACTERS_FETCH.SUCCESS:
      const info = _.get(action, 'response.info');
      state.pagination = _.assign({}, state.pagination, info, getPaginationFromInfo(info));

      const results = _.get(action, 'response.results');
      state.data.characters = results;

      // Updates the meta data lists with possibly fresh values
      _.forEach(['gender', 'species', 'status'], prop => {
        const existing = _.get(state, `data.${prop}`);
        const fetched = _.map(results, `${prop}`);
        const values = _.chain([...existing, ...fetched]).uniq().sortBy().value();
        _.set(state, `data.${prop}`, values);
      });

      state.communication = _.assign({}, state.communication, {fetching: false});

      return _.assign({}, state);

    case API_REQUEST.FAILURE:
      state.communication = _.assign({}, state.communication, {fetching: false, error: action.error.message});
      return _.assign({}, state);

    default:
      return _.assign({}, state);
  }
};
