import { createBrowserHistory } from 'history'
import { createStore, compose, applyMiddleware } from 'redux';
import thunkMiddleware from 'redux-thunk';
import { routerMiddleware } from 'connected-react-router'
import createRootReducer from './reducers';

export const history = createBrowserHistory();

export let store = null;

export default (state) => {
  store = createStore(createRootReducer(history), state, compose(applyMiddleware(thunkMiddleware, routerMiddleware(history))));

  return store;
};
