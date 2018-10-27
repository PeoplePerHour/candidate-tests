import React, { Component } from 'react';
import { connect } from 'react-redux';
import { compose } from 'redux';
import { closeModal } from '../actions';

import ReactModal from 'react-modal';
import { CharacterDetail } from './Character';

import './Modal.scss';

const MODALS = {
  CHARACTER: CharacterDetail
};

class ModalRoot extends Component {
  constructor(props) {
    super(props);
    ReactModal.setAppElement('#root');
  }

  render() {
    const {
      modalType,
      modalProps,
      modalClass,
      modalTitle,
      ...rest
    } = this.props;

    if (!modalType) return null;

    const Modal = MODALS[modalType];

    return (
      <ReactModal
        isOpen={!!modalType}
        onRequestClose={this.props.closeModal}
        className={modalClass}
        contentLabel={modalTitle}
        overlayClassName="Modal__Overlay"
      >
        <Modal {...modalProps} {...rest} onClose={this.closeModal} />
      </ReactModal>
    );
  }
}

export default compose(
  connect(
    state => state.modal,
    { closeModal }
  )
)(ModalRoot);
