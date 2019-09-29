import React from "react";
import ButtonToolbar from "react-bootstrap/ButtonToolbar";
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import classes from "../sass/App.module.scss";

const pagination = props => {

  return (
    <div>
      <Row className={(classes.NoMargin, classes.RowCenterItems)}>
        <ButtonToolbar>
          {props.currentPage > 1 ? (
            <Button
              className={classes.Btn__blue}
              variant="primary"
              onClick={props.prevPage}
            >
              Previous
            </Button>
          ) : (
            ""
          )}
          {props.currentPage === props.pages ? (
            ""
          ) : (
            
            <Button
              className={classes.Btn__blue}
              variant="primary"
              onClick={props.nextPage}
            >
              Next
            </Button>
          )}
        </ButtonToolbar>
      </Row>
    </div>
  );
};
export default pagination;
