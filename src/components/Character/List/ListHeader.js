import React, { PureComponent } from 'react';
import { connect } from 'react-redux';
import { getSpecies } from '../../../reducers/species';

import { STATUS, GENDER } from '../../../constants/api';
import Filter from './Filter';

import './ListHeader.scss';

class ListHeader extends PureComponent {
  constructor(props) {
    super(props);

    const { gender, status, species } = props.params;
    this.state = {
      gender,
      status,
      species
    };
  }

  onSpeciesChange = e => {
    const species = e.target.value;
    this.onChange('species')(species);
  };

  onChange = type => filters => {
    this.setState(
      {
        [type]: filters
      },
      () => {
        this.props.onFilter(this.state);
      }
    );
  };

  render() {
    const { allSpecies } = this.props;
    const { gender, status, species } = this.state;

    const speciesFilterInputProps = {
      name: 'species',
      onChange: this.onSpeciesChange,
      value: this.state.species
    };

    return (
      <div className="CharacterListHeader">
        <div className="CharacterListHeader__info">Filter by:</div>
        <Filter
          onChange={this.onChange('gender')}
          initial={gender}
          data={GENDER}
        >
          Gender
        </Filter>
        <Filter
          withTextInput
          initial={species}
          inputProps={speciesFilterInputProps}
          onChange={this.onChange('species')}
          data={allSpecies}
        >
          Species
        </Filter>
        <Filter
          initial={status}
          onChange={this.onChange('status')}
          data={STATUS}
        >
          Status
        </Filter>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  allSpecies: getSpecies(state)
});

export default connect(mapStateToProps)(ListHeader);
