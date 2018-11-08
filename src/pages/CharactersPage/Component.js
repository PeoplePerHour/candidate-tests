import _ from 'lodash';
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { withRouter } from 'react-router-dom';

import apiActions from '../../store/actions/api';

import { getQueryParameters } from '../../lib/helpers';

import CharactersList from '../../components/CharactersList';

export class CharactersPage extends Component {
  get characters() {
    return _.get(this.props, 'characters');
  }

  get location() {
    return _.get(this.props, 'history.location');
  }

  get selections() {
    const selections = _.omit(getQueryParameters(this.location.search), 'page');
    return _.defaults(selections, {gender: '', species: '', status: ''});
  }

  constructor(props) {
    super(props);

    this.unlisten = props.history.listen(({search}, action) => {
      if (action === 'POP') {
        this.fetchCharacters(search);
      }
    });
  }

  setSearch(search = '') {
    if (this.location.search === search) {
      return Promise.resolve();
    }

    this.props.history.push(`${this.location.pathname}${search}`);
    return this.fetchCharacters(search);
  }

  fetchCharacters(search) {
    return this.props.apiActions.fetchCharacters(search); 
  }

  render() {
    return <CharactersList
              characters={this.characters}
              selections={this.selections}
              setSearch={this.setSearch.bind(this)}/>;
  }

  componentDidMount() {
    this.fetchCharacters(this.location.search);
  }

  componentWillUnmount() {
    this.unlisten();
  }
}

function mapStateToProps(state, props) {
  return _.chain(state).get('api.data').pick(['characters']).value();
}

function mapDispatchToProps(dispatch) {
  return {
    apiActions: bindActionCreators(apiActions, dispatch)
  }
}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(CharactersPage));
