import _ from 'lodash';
import React, { Component } from 'react';
import { List, Avatar } from 'antd';

import './styles.scss';

export class CharacterListItem extends Component {
  get character() {
    return this.props.character;
  }

  renderDescription() {
    const descriptionItems = _.chain(this.character)
      .pick(['status', 'gender', 'species'])
      .map((value, key) => {
        return (
          <div
            key={key}>{_.upperFirst(value)}</div>
        );
      })
      .value();

      return <div>{descriptionItems}</div>;
  }

  render() {
    return (
      <div className="characterListItemComponent">
        <List.Item
          key={this.character.name}>
          <List.Item.Meta
            avatar={<Avatar size={150} src={this.character.image} />}
            title={this.character.name}
            description={this.renderDescription()}></List.Item.Meta>
        </List.Item>
      </div>
    );
  }
}

export default CharacterListItem;
