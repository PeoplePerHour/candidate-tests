import { combineReducers } from 'redux';
import characters, { STATE_KEY as CHARACTERS_STATE_KEY } from './characters';
import species, { STATE_KEY as SPECIES_STATE_KEY } from './species';
import modal, { STATE_KEY as MODAL_STATE_KEY } from './modal';

const rootReducer = combineReducers({
  [CHARACTERS_STATE_KEY]: characters,
  [SPECIES_STATE_KEY]: species,
  [MODAL_STATE_KEY]: modal
});

export default rootReducer;
