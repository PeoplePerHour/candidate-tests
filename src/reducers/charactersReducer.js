import { FETCH_CHARACTERS_REQUEST, FETCH_CHARACTERS_SUCCESS, FETCH_CHARACTERS_FAILURE } from "../actions/characterActions";

//
//Initial state of characterState
//
const initialState = {
  loading: false,
  characters: [],
  error: "",
  next: null,
  prev: null,
};

export const characterReducer = (state = initialState, action) => {
  switch (action.type) {
    case FETCH_CHARACTERS_REQUEST:
      return {
        ...state,
        loading: true
      };
    case FETCH_CHARACTERS_SUCCESS:
      return {
        loading: false,
        characters: action.payload,
        next: action.next,
        prev: action.prev,
        error: ""
      };
    case FETCH_CHARACTERS_FAILURE:
      return {
        loading: false,
        characters: [],
        next: action.next,
        prev: action.prev,
        error: action.payload
      };
    default:
      return state;
  }
};

export default characterReducer;
