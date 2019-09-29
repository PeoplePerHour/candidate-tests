import React from "react";
import Badge from "react-bootstrap/Badge";

const errorMessage = props => {
  return (
    <div>
      <Badge variant="danger">{props.error}</Badge>
      <br></br>
      <a href={props.homeUrl}>Go Home!</a>
    </div>
  );
};

export default errorMessage;
