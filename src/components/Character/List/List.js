import React, { Component } from 'react';
import qs from 'qs';

import { connect } from 'react-redux';
import { fetchCharacters } from '../../../actions';
import {
  getCharacters,
  getCharacterPaginationInfo,
  getCharactersIsFetching
} from '../../../selectors';

import CharacterListItem from './Item';
import CharacterListFooter from './ListFooter';
import CharacterListHeader from './ListHeader';
import './List.scss';

export class CharacterList extends Component {
  constructor(props) {
    super(props);
    this.loadData = this.loadData.bind(this);
    this.onFilter = this.onFilter.bind(this);
  }

  componentDidMount() {
    this.loadData();
  }

  loadData(params = this.props.params) {
    this.props.fetchCharacters(params);
  }

  onFilter({ gender, species, status }) {
    const { history } = this.props;
    this.loadData({ gender, species, status });
    history.push({
      pathname: history.location.pathname,
      search: qs.stringify({ gender, species, status })
    });
  }

  render() {
    const { characters, info, loading, params } = this.props;

    return (
      <div className="CharacterList">
        <CharacterListHeader params={params} onFilter={this.onFilter} />

        <div className="CharacterList__items-container">
          {loading && <div className="CharacterList__loading" />}
          {characters.map(n => (
            <CharacterListItem key={n.id} {...n} />
          ))}
        </div>
        <CharacterListFooter onClick={this.loadData} info={info} />
      </div>
    );
  }
}

const mapStateToProps = (state, ownProps) => ({
  characters: getCharacters(state, ownProps.params),
  info: getCharacterPaginationInfo(state),
  loading: getCharactersIsFetching(state),
  params: qs.parse(ownProps.history.location.search, {
    ignoreQueryPrefix: true
  })
});

export default connect(
  mapStateToProps,
  {
    fetchCharacters,
    getCharacterPaginationInfo
  }
)(CharacterList);
