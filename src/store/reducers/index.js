import { combineReducers } from 'redux';
import { connectRouter } from 'connected-react-router'

import api from './api';

export default (history) => combineReducers({
    api,
    router: connectRouter(history)
});