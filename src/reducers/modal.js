import { SHOW_MODAL, HIDE_MODAL } from '../constants/actionTypes';

const initialState = {
  modalType: null,
  modalClass: '',
  modalTitle: '',
  modalProps: {}
};

export const STATE_KEY = 'modal';

const modal = (state = initialState, action) => {
  switch (action.type) {
    case SHOW_MODAL:
      return {
        modalType: action.modalType,
        modalProps: action.modalProps,
        modalClass: action.modalClass,
        modalTitle: action.modalTitle
      };
    case HIDE_MODAL:
      return initialState;
    default:
      return state;
  }
};

export default modal;
