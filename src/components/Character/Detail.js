import React, { PureComponent } from 'react';
import { getCharacterById } from '../../selectors';
import { Avatar } from '../Common';
import Status from './Status';
import { connect } from 'react-redux';

import './Detail.scss';

class CharacterDetail extends PureComponent {
  render() {
    const {
      image,
      origin,
      name,
      status,
      species,
      subspecies,
      gender,
      location
    } = this.props;

    return (
      <div className="CharacterDetail">
        <div className="CharacterDetail__avatar">
          <Avatar square src={image} />
          <div className="CharacterDetail__status">
            <Status text={status} />
          </div>
        </div>
        <div className="CharacterDetail__info">
          <header>
            <h2>
              {name}{' '}
              <span>
                from <b>{origin.name}</b>
              </span>
            </h2>
          </header>
          <p>Gender: {gender}</p>
          <p>Species: {species}</p>
          {subspecies && <p>Subspecies: {subspecies}</p>}
          <p>Location: {location.name}</p>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state, ownProps) => ({
  ...getCharacterById(state, ownProps.id)
});

export default connect(mapStateToProps)(CharacterDetail);
