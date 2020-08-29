import { SET_SEARCH_PARAM, FETCH_CHARACTERS } from "../actions/types";

const initialState = {
  data: [],
  locations: [],
  episodes: [],
  loading: false,
  name: '',
  gender:'',
  page: 1,
  info: {}
};

export default function (state = initialState, action) {
  switch (action.type) {
    case SET_SEARCH_PARAM:
      return {
        ...state,
        [action.payload.valueType]: action.payload.value,
        loading: false,
      };
    case FETCH_CHARACTERS:
        
      return {
        ...state,
        data: action.payload.results,
        info: action.payload.info,
        loading: false
      };
    default:
      return state;
  }
}
