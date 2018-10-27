import reducer, * as characters from './';
import * as types from '../../constants/actionTypes';

describe('characters reducer', () => {
  const initialState = {
    allIds: [],
    isFetching: false,
    byId: {},
    paginationInfo: {}
  };

  it('should return the initial state', () => {
    expect(reducer(undefined, {})).toEqual(initialState);
  });

  it('should set correct state key', () => {
    expect(characters.STATE_KEY).toBe('characters');
  });

  it('should handle FETCH_CHARACTERS_REQUEST', () => {
    expect(
      reducer(
        {},
        {
          type: types.FETCH_CHARACTERS_REQUEST
        }
      )
    ).toEqual({
      ...initialState,
      isFetching: true
    });
  });

  it('should handle FETCH_CHARACTERS_SUCCESS', () => {
    const previousState = {
      isFetching: true
    };

    const action = {
      type: types.FETCH_CHARACTERS_SUCCESS,
      response: {
        entities: {
          characters: {
            1: {
              id: 1,
              name: 'Pickle Rick'
            },
            2: {
              id: 2,
              name: 'Allegra Geller'
            }
          }
        },
        result: {
          results: [1, 2],
          info: {
            pages: 2,
            next: '',
            previous: ''
          }
        }
      }
    };

    const expectedState = {
      isFetching: false,
      allIds: [1, 2],
      paginationInfo: {
        pages: 2,
        next: '',
        previous: ''
      },
      byId: {
        1: {
          id: 1,
          name: 'Pickle Rick'
        },
        2: {
          id: 2,
          name: 'Allegra Geller'
        }
      }
    };

    expect(reducer(previousState, action)).toEqual({
      ...expectedState
    });
  });

  it('should handle FETCH_CHARACTERS_FAILURE', () => {
    expect(
      reducer(
        {},
        {
          type: types.FETCH_CHARACTERS_FAILURE
        }
      )
    ).toEqual({
      ...initialState,
      isFetching: false
    });
  });
});
