import React, { Component } from 'react';
import { renderRoutes } from 'react-router-config';

import { Layout } from 'antd';
const { Content } = Layout;

export class App extends Component {
  render() {
    return (
      <Content>
          {this.props.route && renderRoutes(this.props.route.routes)}
      </Content>
    );
  }
}

export default App;
