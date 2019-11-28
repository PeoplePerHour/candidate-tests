import * as actionTypes from "../actions/actionTypes";
import * as models from "../../models";

interface Iaction extends models.IState {
  results: [models.ICharacter];
  type: string;
  payload: { results: models.ICharacter; info: models.Iinfo };
}

const initialState: models.IState = {
  characters: [],
  info: [],
  loading: true,
  species: [],
  errorInSearch: false
};
const reducer = (state = initialState, action: Iaction) => {
  switch (action.type) {
    case actionTypes.FETCH_CHARACTERS_SUCCESS:
      return {
        ...state,
        characters: action.payload.results,
        info: action.payload.info,
        species: action.species,
        loading: false,
        errorInSearch: false
      };
    case actionTypes.FETCH_CHARACTERS_FAIL:
      return {
        ...state,
        characters: {},
        loading: true,
        errorInSearch: true
      };
    default:
      return {
        ...state
      };
  }
};

export default reducer;
