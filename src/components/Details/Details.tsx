import * as React from "react";
import * as models from "../../models";

interface Iprops {
  character: models.ICharacter;
}

const Details = (props: Iprops) => {
  const { character } = props;
  return (
    <div>
      <div className="d-flex fd-col fa-center card details">
        <div>
          <h1>{character.name}</h1>
        </div>
        <img src={character.image} alt="" />

        <h3>Status: {character.status}</h3>
        <h3>Species: {character.species}</h3>
        <h3>gender: {character.gender}</h3>
        <h3>type: {character.type}</h3>
        <h3>Url: {character.url}</h3>
        <h3>Episodes</h3>
        {character.episode ? (
          <ul>
            {" "}
            {character.episode.map((e, i) => {
              return <li key={i}>{e}</li>;
            })}
          </ul>
        ) : null}
      </div>
    </div>
  );
};

export default Details;
