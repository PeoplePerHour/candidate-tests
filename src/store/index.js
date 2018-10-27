import { applyMiddleware, compose as composeRedux, createStore } from 'redux';
import thunkMiddleware from 'redux-thunk';
import apiMiddleware from '../middleware/api';
import { composeWithDevTools } from 'redux-devtools-extension';
import rootReducer from '../reducers';

let compose = composeRedux;

if (process.env.NODE_ENV !== 'production') {
  compose = composeWithDevTools;
}

function configureStore(preloadedState) {
  const middlewares = [thunkMiddleware, apiMiddleware];
  const middlewareEnhancer = applyMiddleware(...middlewares);

  const enhancers = [middlewareEnhancer];
  const composedEnhancers = compose(...enhancers);

  const store = createStore(rootReducer, preloadedState, composedEnhancers);

  return store;
}

export default configureStore;
