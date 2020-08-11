import React, { Component } from 'react';
import './characterCard.scss';
import { formatDate } from '../../../../helpers';

class CharacterCard extends Component {

  backInfo = {};
  statusClasses = {
    'Alive': 'card__status--alive',
    'Dead': 'card__status--dead',
    'Unknown': ''
  };

  constructor(props) {
    super(props);
    this.state = {
      isFliped: false
    }

    this.backInfo = {
      'Created at': formatDate(props.character?.created),
      'Location': props.character?.location?.name,
      'Origin': props.character?.origin?.name,
      'Played in Episodes': props.character?.episode.map(ep => ep.split('/').pop()).join(', '),
    }
  }

  toggleFlip() {
    this.setState({
      ...this.state,
      isFliped: !this.state.isFliped
    });
  }

  renderBackSide = () => {
    return (
      <div className="card__face card__face--back">
        {Object.keys(this.backInfo).map( (key) => {
          return (
            <div key={`info-${key}`} className="card__info">
              <label>{key}: </label>
              <span>{this.backInfo[key]}</span>
            </div>
          );
        })};
    </div>
    )
  }

  renderFrontSide = () => {
    return (
      <div className="card__face card__face--front">
        <img loading='lazy' className="card__avatar" src={this.props.character.image} alt='' />
        <div>
          <span className="card__meta">
          &#9737; {`${this.props.character.species} - ${this.props.character.gender}`}
          </span>
          <strong className="card__name">{this.props.character.name}</strong>
        </div>
        <span className={`card__status ${this.statusClasses[this.props.character.status]}`}>{this.props.character.status}</span>
      </div>
    );
  }

  render() {
    return (
      <div title={this.props.character.name} className="scene scene--card">
        <div onClick={() => {this.toggleFlip()}} className={`card ${this.state.isFliped ? 'is-flipped' : ''}`}>
          {this.renderFrontSide()}
          {this.renderBackSide()}
        </div>
      </div>
    );
  }
}

export default CharacterCard;