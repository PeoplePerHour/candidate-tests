import { createStore, applyMiddleware } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';
import { combineReducers } from 'redux';
import {characterReducer} from './reducers/charactersReducer';
import logger from 'redux-logger';
import thunk from 'redux-thunk';


const rootReducer = combineReducers({
  characterState: characterReducer,
});



const store = createStore(
  rootReducer,
  composeWithDevTools(applyMiddleware(logger, thunk))
);

export default store;
