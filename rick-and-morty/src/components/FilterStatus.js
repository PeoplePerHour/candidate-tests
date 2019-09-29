import React from "react";
import NavDropdown from "react-bootstrap/NavDropdown";

const filterGender = props => {
  return (
    <NavDropdown id="NavDropdown-basic-button" title="Filter Status">
      <NavDropdown.Item data-value="alive" onClick={props.clicked}>
        Alive
      </NavDropdown.Item>
      <NavDropdown.Item data-value="dead" onClick={props.clicked}>
        Dead
      </NavDropdown.Item>
      <NavDropdown.Item data-value="unknown" onClick={props.clicked}>
        Unknown
      </NavDropdown.Item>
    </NavDropdown>
  );
};
export default filterGender;
