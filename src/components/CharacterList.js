import React from "react";
import Character from "./Character";



export default function CharacterList({characters}) {
  
  return (
    <div className="container-fluid">
      <div className="row" id="card">
        {characters &&
          characters.map((character) => {
            return <Character key={character.id} character={character} />;
          })}
      </div>

    </div>
  );
}
