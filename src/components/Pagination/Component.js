import _ from 'lodash';
import React, { Component } from 'react';
import { Badge, Avatar, Button, Icon } from 'antd';

import "./styles.scss";

export class Pagination extends Component {
  get pages() {
    return _.get(this, 'props.pagination.pages');
  }

  get current() {
    return _.get(this, 'props.pagination.current');
  }

  get next() {
    return _.get(this, 'props.pagination.next');
  }

  get prev() {
    return _.get(this, 'props.pagination.prev'); 
  }

  onPaginate(page) {
    this.props.onPaginate(page);
  }

  render() {
    return (
      <div className="paginationComponent">
        <Badge count={this.current}>
          <Avatar size="small">{this.pages}</Avatar>
        </Badge>
        <Button.Group size="small">
          <Button 
            onClick={this.onPaginate.bind(this, this.prev)}
            disabled={!this.prev}>
            <Icon type="left" />
          </Button>
          <Button
            onClick={this.onPaginate.bind(this, this.next)}
            disabled={!this.next}>
            <Icon type="right" />
          </Button>
        </Button.Group>
      </div>
    );
  }
}

export default Pagination;
