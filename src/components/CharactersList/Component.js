import _ from 'lodash';
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Icon, Card, List, Skeleton } from 'antd';

import { getSearchString } from '../../lib/helpers';

import { Dropdowns } from './../Dropdowns';
import { Pagination } from './../Pagination';
import { CharacterModal } from './../CharacterModal';
import { CharacterListItem } from './../CharacterListItem';

export class CharactersList extends Component {
  get dataSource() {
    return _.chain(this).get('props.characters').values().value();
  }

  get character() {
    return _.get(this, 'state.character');
  }

  get pagination() {
    return _.get(this, 'props.pagination'); 
  }

  get selections() {
    return _.get(this, 'props.selections');  
  }

  get dropdowns() {
    return _.get(this, 'props.dropdowns');   
  }

  get fetching() {
    return _.get(this, 'props.communication.fetching');
  }

  get error() {
    return _.get(this, 'props.communication.error');
  }

  constructor(props) {
    super(props);

    this.state = {
      character: null
    };

    this.grid = { gutter: 16, xs: 1, sm: 2, md: 2, lg: 3, xl: 4, xxl: 4 };
  }

  onOpen(character) {
    this.setState({character});
  }

  onCancel() {
    this.setState({character: null});
  }

  onPaginate(page) {
    const searchParams = _.assign({}, {page}, this.selections);
    const search = getSearchString(searchParams);
    return this.props.setSearch(search);
  }

  onSelect(selection) {
    const selections = _.assign({}, this.selections, selection);
    const search = getSearchString(selections);
    return this.props.setSearch(search);
  }

  renderModal() {
    return (
      <CharacterModal
        character={this.character}
        onCancel={this.onCancel.bind(this)}/>
    );
  }

  renderListItem(character) {
    return (
      <div
        onClick={this.onOpen.bind(this, character)}>
        <CharacterListItem character={character} />
      </div>
    );
  }

  renderTitle() {
    return (
      <Dropdowns
        onSelect={this.onSelect.bind(this)}
        selections={this.selections}
        dropdowns={this.dropdowns}/>
    );
  }

  renderExtra() {
    return (
      <Pagination
        onPaginate={this.onPaginate.bind(this)}
        pagination={this.pagination}/>
    );
  }

  renderList() {
    return (
      <List
        grid={this.grid}
        dataSource={this.dataSource}
        renderItem={this.renderListItem.bind(this)}>{this.renderModal()}</List>
    ); 
  }

  renderError() {
    return (
      <h1>
        <Icon
          spin
          type="meh"/> {this.error}
      </h1>
    );
  }

  render() {
    return (
      <div className="charactersListComponent">
        <Card
          title={this.renderTitle()}
          extra={this.renderExtra()}>
          <Skeleton
            active
            avatar
            loading={this.fetching}>
            {this.error ? this.renderError() : this.renderList()}
          </Skeleton>
        </Card>
      </div>
    );
  }
}

function mapStateToProps(state, props) {
  const pagination = _.get(state, 'api.pagination');
  const dropdowns = _.chain(state).get('api.data').omit('characters').value();
  const communication = _.get(state, 'api.communication');
  return {pagination, dropdowns, communication};
}

export default connect(mapStateToProps)(CharactersList);
