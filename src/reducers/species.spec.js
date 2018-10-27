import reducer, * as species from './species';
import * as types from '../constants/actionTypes';

describe('species reducer', () => {
  const initialState = [];

  it('should return the initial state', () => {
    expect(reducer(undefined, {})).toEqual(initialState);
  });

  it('should set correct state key', () => {
    expect(species.STATE_KEY).toBe('species');
  });

  it('should handle FETCH_CHARACTERS_SUCCESS', () => {
    const previousState = ['Humanoid', 'Parasite'];

    const action = {
      type: types.FETCH_CHARACTERS_SUCCESS,
      response: {
        entities: {
          characters: {
            1: {
              id: 1,
              species: 'Human'
            },
            2: {
              id: 2,
              species: 'Human'
            },
            3: {
              id: 3,
              species: 'Parasite'
            }
          }
        },
        result: {
          results: [1, 2, 3]
        }
      }
    };

    const expectedState = ['Humanoid', 'Parasite', 'Human'];

    expect(reducer(previousState, action)).toEqual(expectedState);
  });
});
