import _ from 'lodash';
import React, { Component } from 'react';
import { Modal, Card } from 'antd';

const { Meta } = Card;

export class CharacterModal extends Component {
  get character() {
    return _.get(this, 'props.character');
  }

  get visible() {
    return this.character !== null;
  }

  get onCancel() {
    return _.get(this, 'props.onCancel');
  }

  renderCover() {
    return (
      <img alt={this.character.name} src={this.character.image}/>
    );
  }

  renderDescription() {
      const description = _.chain(this.character)
        .pick(['status', 'gender', 'species', 'origin', 'location', 'episode'])
        .mapValues(value => {
          if (_.isString(value)) {
            return _.upperFirst(value);
          }

          if (_.isArray(value)) {
            return _.size(value);
          }

          return _.hasIn(value, 'name') ? _.upperFirst(value.name) : value;
        })
        .mapKeys((value, key) =>  _.upperFirst(key))
        .map((value, key) => <div key={key}>{key}: {value}</div>)
        .value();


      return <div>{description}</div>;
  }

  render() {
    if (this.visible) {
      return (
        <Modal
          footer={null}
          width={350}
          closable={false}
          visible={this.visible}
          onCancel={this.onCancel}>
          <Card
            hoverable
            cover={this.renderCover()}>
            <Meta
              title={this.character.name}
              description={this.renderDescription()}/>
          </Card>
        </Modal>
      );
    }
    return <div></div>;
  }
}

export default CharacterModal;
