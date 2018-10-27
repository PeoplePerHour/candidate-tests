import configureMockStore from 'redux-mock-store';
import thunk from 'redux-thunk';
import api from '../middleware/api';

import { API_ROOT, CHARACTERS_URI } from '../constants/endpoints';

import * as actions from './';
import * as types from '../constants/actionTypes';

import nock from 'nock';
import expect from 'expect'; // You can use any testing library

const middlewares = [thunk, api];
const mockStore = configureMockStore(middlewares);

describe('async actions', () => {
  afterEach(() => {
    nock.cleanAll();
  });

  it('creates FETCH_CHARACTERS_SUCCESS when fetching characters has been done', () => {
    nock(API_ROOT)
      .get(CHARACTERS_URI + '?page=1')
      .reply(200, { results: [{ id: 1, name: 'Pickle Rick' }] });

    const expectedActions = [
      { type: types.FETCH_CHARACTERS_REQUEST },
      {
        type: types.FETCH_CHARACTERS_SUCCESS,
        response: {
          entities: {
            characters: {
              1: {
                id: 1,
                name: 'Pickle Rick'
              }
            }
          },
          result: {
            results: [1]
          }
        }
      }
    ];

    const store = mockStore({ characters: [] });

    return store.dispatch(actions.fetchCharacters()).then(() => {
      // return of async actions
      expect(store.getActions()).toEqual(expectedActions);
    });
  });

  it('creates FETCH_CHARACTERS_FAILURE when fetching characters has failed', () => {
    nock(API_ROOT)
      .get(CHARACTERS_URI + '?page=1')
      .reply(404, { error: 'There is nothing here' });

    const expectedActions = [
      { type: types.FETCH_CHARACTERS_REQUEST },
      {
        type: types.FETCH_CHARACTERS_FAILURE,
        error: true,
        message: 'There is nothing here'
      }
    ];

    const store = mockStore({ characters: [] });

    return store.dispatch(actions.fetchCharacters()).then(() => {
      // return of async actions
      expect(store.getActions()).toEqual(expectedActions);
    });
  });
});
