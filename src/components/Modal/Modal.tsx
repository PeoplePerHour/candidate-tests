import * as React from "react";

interface Iprops{
  children: React.ReactNode
  closeModal():void
  displayModal(b:boolean):void
}

const Modal= (props:Iprops) => {
  const { children,displayModal } = props;
  function closeModal(e:React.MouseEvent) {
    e.stopPropagation();
    props.closeModal();
  }

  const divStyle = {
    display: props.displayModal ? "flex" : "none"
  };

  return (
    <div className="modal" onClick={closeModal} style={divStyle}>
      <div className="modal-content" onClick={e => e.stopPropagation()}>
        <span className="close" onClick={closeModal}>
          &times;
        </span>
        <div>
        <div className="modal-flex">{displayModal ?children:null}</div></div>
      </div>
      <div className='modal-background' ></div>
    </div>
  );
};

export default Modal;
