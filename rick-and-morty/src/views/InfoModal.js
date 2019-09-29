import React from "react";
import classes from "../sass/App.module.scss";
import Modal from "react-bootstrap/Modal";
import Button from "react-bootstrap/Button";
import Image from "react-bootstrap/Image";
import Badge from "react-bootstrap/Badge";
import ListGroup from "react-bootstrap/ListGroup";

const infoModal = props => {
  return (
    <div className={classes.Modal}>
      <Modal
        {...props}
        size="md"
        aria-labelledby="contained-modal-title-vcenter"
        centered
      >
        <div className={classes.ModalDark}>
          <Modal.Header
            style={{ justifyContent: "center", borderBottom: "none" }}
          >
            <Modal.Title id="contained-modal-title-vcenter">
              <Badge className={classes.BadgeContent} variant="warning">
                <h2> {props.character.name} </h2>
              </Badge>
            </Modal.Title>
          </Modal.Header>

          <Modal.Body className={classes.ModalBody}>
            <div className={classes.ModalContent}>
              <Image src={props.character.image} rounded fluid />
            </div>
            <div className={classes.ModalContent}>
              <ListGroup className={classes.ModalDark} variant="flush">
                <ListGroup.Item className={classes.ModalListItem}>
                  Gender: {props.character.gender}
                </ListGroup.Item>
                <ListGroup.Item className={classes.ModalListItem}>
                  Status: {props.character.status}
                </ListGroup.Item>
                <ListGroup.Item className={classes.ModalListItem}>
                  Species: {props.character.species}
                </ListGroup.Item>
                <ListGroup.Item className={classes.ModalListItem}>
                  Origin: {props.character.origin}
                </ListGroup.Item>
                <ListGroup.Item className={classes.ModalListItem}>
                  Location: {props.character.location}
                </ListGroup.Item>
              </ListGroup>
            </div>
          </Modal.Body>
          <Modal.Footer
          
            style={{
              justifyContent: "center",
              borderTop: "none",
              float: " right"
            }}
          >
            <div className={classes.Btn__orange} onClick={props.onHide}>Close</div>
          </Modal.Footer>
        </div>
      </Modal>
    </div>
  );
};

export default infoModal;
