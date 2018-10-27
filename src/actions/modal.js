import { HIDE_MODAL, SHOW_MODAL } from '../constants/actionTypes';

const showCharacter = modalProps => ({
  type: SHOW_MODAL,
  modalType: 'CHARACTER',
  modalClass: 'CharacterDetailModal',
  modalProps
});

const close = () => ({
  type: HIDE_MODAL
});

export const openCharacterModal = props => dispatch =>
  dispatch(showCharacter(props));

export const closeModal = () => dispatch => dispatch(close());
