import React from 'react';
import classes from "../sass/App.module.scss";
import Row from "react-bootstrap/Row";

import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import CardDeck from "react-bootstrap/CardGroup";

const characters = props => {


    return (
    <CardDeck>
    <Row className={(classes.NoMargin, classes.RowCenterItems)}>
      {props.characters.map((character, key) => (
        <Col className={classes.ColNoSpacing} key={key}>
          <Card className={classes.Card} id={character.id}>
            <Card.Img variant="top" src={character.image} />
            <Card.Body className={classes.Centered}>
              <Card.Title className={classes.CardTitle}>
                {character.name}
              </Card.Title>
              <div
                className={classes.Btn__orange}
                onClick={() => props.setSelectedCharacter(character)}
              >
                Who's that
              </div>
            </Card.Body>
          </Card>
        </Col>
      ))}
    </Row>
  </CardDeck>

)

}

export default characters;