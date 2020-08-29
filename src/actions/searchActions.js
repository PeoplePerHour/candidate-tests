import { SET_SEARCH_PARAM, FETCH_CHARACTERS } from "./types";
import axios from "axios";


export const setSearchParams = (valueType, value) => (dispatch) => {
  dispatch({
    type: SET_SEARCH_PARAM,
    payload: { valueType, value },
  });
};

export const fetchCharacters = (name, gender, page) => (dispatch) => {
  axios
    .get(
      `https://rickandmortyapi.com/api/character/?name=${name}&gender=${gender}&page=${page}`
    )
    .then((response) => {
      return dispatch({
        type: FETCH_CHARACTERS,
        payload: response.data,
      });
    })
    .catch((error) => console.log(error));
};
