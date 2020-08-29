import React from "react";

function Character({ character }) {
  return (
    <div className="col-md-4 col-sm-12">
      <div className="card-container">
        <div className="picture">
          <img
            src={character.image}
            alt={character.name}
            className="img-responsive"
            style={{ width: "100%" }}
          />
        </div>
        <div className="card-title mt-2">
          <h3>{character.name}</h3>
        </div>
        <div className="card-description">
          <div className="row">
            <div className="col-md-12">
              <strong>Status: </strong>
              {character.status}
            </div>
            <div className="col-md-12">
              <strong>Gender: </strong>
              {character.gender}
            </div>
          </div>
          <div className="row">
            <div className="col-md-12">
              <strong>Species: </strong>
              {character.species}
            </div>
          </div>
          <div className="row">
            <div className="col-md-12">
              <strong>Origin: </strong>
              {character.origin.name}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
export default Character;
