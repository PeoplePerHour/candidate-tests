import React from "react";
import { Link } from "react-router-dom";
function Navbar() {
  return (
    <nav className="navbar navbar-light bg-dark mb-5">
      <div className="container">
        <Link to="/">
          <div className="navbar-header">
            <ul className="navbar-nav text-light d-inline-block">
              <li className="nav-item d-inline-block mr-4">
                <img
                  className="nav-logo"
                  src="/images/rick-and-morty-icon.jpg"
                  alt="logo"
                />
              </li>
            </ul>
            <div className="header-title"> Rick & Morty Characters</div>
          </div>
        </Link>
      </div>
    </nav>
  );
}

export default Navbar;
