import React, { PureComponent } from 'react';
import { connect } from 'react-redux';
import { openCharacterModal } from '../../../actions';

import { Avatar } from '../../Common';
import Status from '../Status';

import './Item.scss';

class CharacterListItem extends PureComponent {
  openModal = () => {
    const { id, openCharacterModal } = this.props;
    openCharacterModal({ id });
  };

  render() {
    const {
      image,
      origin,
      name,
      status,
      species,
      subspecies,
      gender,
      episode,
      location
    } = this.props;

    return (
      <div role="button" onClick={this.openModal} style={{ cursor: 'pointer' }}>
        <div className="CharacterListItem">
          <div className="CharacterListItem__Avatar">
            <Avatar src={image} alt={name} />
          </div>
          <div className="CharacterListItem__Info">
            <header>
              <Status text={status} />
              <h5>
                {name}
                <span>
                  from <b>{origin.name}</b>
                </span>
              </h5>
            </header>
            {gender}, {species}
            {subspecies && `/${subspecies}`}
            <br />
            {location.name}
            <br />
            Episodes: {episode.length}
          </div>
        </div>
      </div>
    );
  }
}

export default connect(
  null,
  { openCharacterModal }
)(CharacterListItem);
