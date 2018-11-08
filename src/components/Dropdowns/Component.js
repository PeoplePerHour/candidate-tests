import _ from 'lodash';
import React, { Component } from 'react';
import { Dropdown, Menu, Button, Icon } from 'antd';

import './styles.scss';

export class Dropdowns extends Component {
  renderMenuItems(key, values) {
    return _.map(values, value => {
      return (
        <Menu.Item
          key={value}
          onClick={this.onSelect.bind(this, key, value)}>{_.upperFirst(value || `any ${key}`)}</Menu.Item>
      );
    });
  }

  renderMenu(key, values) {
    return (<Menu>{this.renderMenuItems(key, values)}</Menu>);
  }

  renderDropdown(key, values) {
    const selection = _.get(this.props, `selections.${key}`);
    return (
      <Dropdown
        key={key}
        overlay={this.renderMenu(key, values)}>
        <Button>
          {_.upperFirst(`${selection || 'any'} ${key}`)} <Icon type="down" />
        </Button>
      </Dropdown>
    );
  }

  renderDropdowns() {
    return _.chain(this)
      .get('props.dropdowns')
      .map((values, key) => this.renderDropdown(key, values))
      .value();
  }

  onSelect(key, value) {
    this.props.onSelect(_.set({}, `${key}`, `${value}`));
  }

  render() {
    return (
      <div className="dropdownsComponent">
        {this.renderDropdowns()}
      </div>
    );
  }
}

export default Dropdowns;
