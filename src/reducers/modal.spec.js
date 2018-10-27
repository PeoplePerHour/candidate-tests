import reducer, * as modal from './modal';
import * as types from '../constants/actionTypes';

describe('modal reducer', () => {
  const initialState = {
    modalType: null,
    modalClass: '',
    modalTitle: '',
    modalProps: {}
  };

  it('should return the initial state', () => {
    expect(reducer(undefined, {})).toEqual(initialState);
  });

  it('should set correct state key', () => {
    expect(modal.STATE_KEY).toBe('modal');
  });

  it('should handle show modal', () => {
    const action = {
      type: types.SHOW_MODAL,
      modalType: 'CHARACTER',
      modalTitle: 'Character detail modal',
      modalClass: 'CharacterDetailModal',
      modalProps: { id: 1 }
    };

    const stateBefore = initialState;

    const stateAfter = {
      modalType: 'CHARACTER',
      modalTitle: 'Character detail modal',
      modalClass: 'CharacterDetailModal',
      modalProps: { id: 1 }
    };

    expect(reducer(stateBefore, action)).toEqual(stateAfter);
  });

  it('should handle hide modal', () => {
    const action = {
      type: types.HIDE_MODAL
    };

    const stateBefore = {
      modalType: 'CHARACTER',
      modalTitle: 'Character detail modal',
      modalClass: 'CharacterDetailModal',
      modalProps: { id: 1 }
    };

    const stateAfter = initialState;

    expect(reducer(stateBefore, action)).toEqual(stateAfter);
  });
});
