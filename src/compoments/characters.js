import React, { useEffect, useState } from "react";

import { useSelector, useDispatch } from "react-redux";
import { Container, Card, Row, Col, Form, Button } from "react-bootstrap";
import { fetchCharacters } from "../actions/characterActions";
import { createParameter } from "../actions/characterActions";
import { useHistory } from "react-router-dom";

const Characters = () => {
  const history = useHistory();
  const dispatch = useDispatch();
  const initialState = {
    name: "",
    species: "",
    type: "",
    gender: "",
    status: ""
  };
  const [{ name, species, type, gender, status }, setState] = useState(initialState);
  const search = window.location.search;
  const params = new URLSearchParams(search);

  const onChange = e => {
    const { name, value } = e.target;
    setState(prevState => ({ ...prevState, [name]: value }));
  };

  const clearState = e => {
    e.preventDefault();
    setState({ ...initialState });
  };

  const characterState = useSelector(state => state.characterState);

  const handleSubmit = e => {
    const filter = {
      name: name,
      species: species,
      type: type,
      gender: gender,
      status: status
    };
    e.preventDefault();
    const parameter = createParameter(filter);
    history.push("/?a=1" + parameter);
    dispatch(fetchCharacters(1, filter));
  };

  const handleNext = () => {
    dispatch(fetchCharacters(1, null, characterState.next));
  };

  const handlePrev = () => {
    dispatch(fetchCharacters(1, null, characterState.prev));
  };

  const getEpisodes = (character) => {
    return (
    character.episode.map((url => (
      <span className="episode">{url.split("/").pop()}</span>
    ))
    )
    )
  }

  useEffect(() => {
    const history_json = {
      name: params.get("name") || "",
      species: params.get("species") || "",
      type: params.get("type") || "",
      gender: params.get("gender") || "",
      status: params.get("status") || ""
    };
    dispatch(fetchCharacters(1, history_json));
  }, []);

  return characterState.loading ? (
    <div className="loader"></div>
  ) : characterState.error ? (
    <h2>{characterState.error}</h2>
  ) : (
    <>
      <Container>
        <h1 className="text-center">
          Rick &amp; Morty <span>Api</span>
        </h1>
        <ul className="nav justify-content-center">
          <Button variant="primary" disabled={characterState.prev !== null ? false : true} onClick={handlePrev}>
            prev
          </Button>
          <Button disabled={characterState.next !== null ? false : true} onClick={handleNext}>
            next
          </Button>
        </ul>
        <Form>
          <Form.Row>
            <Form.Group as={Col} controlId="formGridName">
              <Form.Label>Name</Form.Label>
              <Form.Control type="text" placeholder="Enter Name" name="name" value={name} onChange={onChange} />
            </Form.Group>

            <Form.Group as={Col} controlId="formGridSpecies">
              <Form.Label>Species</Form.Label>
              <Form.Control type="text" placeholder="Species" name="species" value={species} onChange={onChange} />
            </Form.Group>

            <Form.Group as={Col} controlId="formGridType">
              <Form.Label>Type</Form.Label>
              <Form.Control type="text" placeholder="type" name="type" value={type} onChange={onChange} />
            </Form.Group>
          </Form.Row>
          <Form.Row>
            <Form.Group as={Col} controlId="formGridGender">
              <Form.Label>State</Form.Label>
              <Form.Control as="select" value={gender} name="gender" onChange={onChange}>
                <option></option>
                <option>male</option>
                <option>female</option>
                <option>genderless</option>
                <option>unknown</option>
              </Form.Control>
            </Form.Group>

            <Form.Group as={Col} controlId="formGridStatus">
              <Form.Label>State</Form.Label>
              <Form.Control as="select" value={status} name="status" onChange={onChange}>
                <option></option>
                <option>alive</option>
                <option>dead</option>
                <option>unknown</option>
              </Form.Control>
            </Form.Group>
          </Form.Row>
          <Button variant="primary" type="submit" onClick={e => handleSubmit(e)}>
            Search
          </Button>
          <Button variant="primary" type="submit" onClick={e => clearState(e)}>
            Clear
          </Button>
        </Form>
        <br></br>
        <Row>
          {characterState.characters.map(character => (
            <Col key={character.id}>
              <Card style={{ width: "18rem" }}>
                <Card.Header>
                  <span className="char_span">{character.id}</span> {character.name}
                </Card.Header>
                <Card.Img variant="top" src={character.image} alt={character.name + "-image"} width="200" height="200" />
                <Card.Body>
                  <p>
                    <b>status:</b> {character.status}
                  </p>
                  <p>
                    <b>type:</b> {character.type}
                  </p>
                  <p>
                    <b>gender:</b> {character.gender}
                  </p>
                  <p>
                    <b>species:</b> {character.species}
                  </p>
                  <p>
                    <b>location:</b> {character.location.name}
                  </p>
                  <p>
                    <b>origin:</b> {character.origin.name}
                  </p>
                </Card.Body>
                <Card.Footer>{getEpisodes(character)}</Card.Footer>
              </Card>
              <br></br>
            </Col>
          ))}
        </Row>
      </Container>
    </>
  );
};

export default Characters;
