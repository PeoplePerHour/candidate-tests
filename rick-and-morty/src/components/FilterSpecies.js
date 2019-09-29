import React from "react";
import NavDropdown from "react-bootstrap/NavDropdown";

const filterSpecies = props => {
  return (
    <NavDropdown id="NavDropdown-basic-button" title="Filter Species">
      <NavDropdown.Item data-value="human" onClick={props.clicked}>
        Human
      </NavDropdown.Item>
      <NavDropdown.Item data-value="alien" onClick={props.clicked}>
        Alien
      </NavDropdown.Item>
      <NavDropdown.Item data-value="animal" onClick={props.clicked}>
        Animal
      </NavDropdown.Item>
      <NavDropdown.Item data-value="unknown" onClick={props.clicked}>
        Something else
      </NavDropdown.Item>
    </NavDropdown>
  );
};
export default filterSpecies;
