import React from "react";
import NavDropdown from "react-bootstrap/NavDropdown";

const filterGender = props => {
  return (
    <NavDropdown variant="dark" id="dropdown-basic-button" title="Filter Gender">
      <NavDropdown.Item data-value="male" onClick={props.clicked}>
        Male
      </NavDropdown.Item>
      <NavDropdown.Item data-value="female" onClick={props.clicked}>
        Female
      </NavDropdown.Item>
      <NavDropdown.Item data-value="unknown" onClick={props.clicked}>
        Something else
      </NavDropdown.Item>
    </NavDropdown>
  );
};
export default filterGender;
