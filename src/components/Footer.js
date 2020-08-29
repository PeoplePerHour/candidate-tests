import React from "react";

function Footer() {
  return (
    <div className="row">
      <div className="col-md-12 footer">
        <div className="footer p-5 mt-5 text-center bg-dark text-light">
          Developed By:{" "}
          <span className="text-warning font-weight-normal">
            Ioanna Vrettou
          </span>
          , using <i className="fab fa-react" /> React Js &amp; Redux Js
          integrated with Rick and Morty public API
          <p className="text-center copyright">
            &copy; Copyright 2020 - People Per Hour. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  );
}

export default Footer;
