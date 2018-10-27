import configureMockStore from 'redux-mock-store';
import thunk from 'redux-thunk';

import * as actions from './';
import * as types from '../constants/actionTypes';

const mockStore = configureMockStore([thunk]);

describe('actions', () => {
  it('creates SHOW_MODAL on open character modal', () => {
    const expectedActions = [
      {
        type: types.SHOW_MODAL,
        modalType: 'CHARACTER',
        modalClass: 'CharacterDetailModal',
        modalProps: { id: 1 }
      }
    ];

    const store = mockStore();

    store.dispatch(actions.openCharacterModal({ id: 1 }));

    expect(store.getActions()).toEqual(expectedActions);
  });
  it('creates HIDE_MODAL on close', () => {
    const expectedActions = [
      {
        type: types.HIDE_MODAL
      }
    ];

    const store = mockStore();

    store.dispatch(actions.closeModal());

    expect(store.getActions()).toEqual(expectedActions);
  });
});
