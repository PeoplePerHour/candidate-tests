import {combineReducers} from 'redux';
import characters from './charactersReducer';

export default combineReducers({
    characters: characters
});