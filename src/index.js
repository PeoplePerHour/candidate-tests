import React, { /*StrictMode*/ } from 'react';
import ReactDOM from 'react-dom';
import { ConnectedRouter } from 'connected-react-router';
import { renderRoutes } from 'react-router-config';
import { Provider } from 'react-redux';

import "antd/dist/antd.css";
import "./index.css";

import configureStore, { history } from './store/configureStore';
import { routes } from './routing';

const store = configureStore();

ReactDOM.render(
    <Provider store={store}>
        <ConnectedRouter history={history} routes={routes}>
          {renderRoutes(routes)}
        </ConnectedRouter>
    </Provider>,
  document.getElementById('root')
);
