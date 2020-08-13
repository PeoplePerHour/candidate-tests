import axios from "axios";

export const FETCH_CHARACTERS_REQUEST = "FETCH_CHARACTERS_REQUEST";
export const FETCH_CHARACTERS_SUCCESS = "FETCH_CHARACTERS_SUCCESS";
export const FETCH_CHARACTERS_FAILURE = "FETCH_CHARACTER_FAILURE";

export const createParameter = filter => {
  return "&name=" + filter.name + "&status=" + filter.status + "&gender=" + filter.gender + "&species=" + filter.species + "&type=" + filter.type;
};

export const fetchCharacters = (page, filter, next) => {
  return dispatch => {
    dispatch(fetchCharactersRequest());
    var url = "";
    if (!next) {
      const parameter = createParameter(filter);
      url = "https://rickandmortyapi.com/api/character?page=" + page + parameter;
    } else {
      url = next;
    }
    axios
      .get(url)
      .then(response => {
        const characters = response.data.results;
        const next = response.data.info.next;
        const prev = response.data.info.prev;

        dispatch(fetchCharactersSuccess(characters, next, prev));
      })
      .catch(error => {
        dispatch(fetchCharactersFailure(error.message));
      });
  };
};

export const fetchCharactersRequest = () => {
  return {
    type: FETCH_CHARACTERS_REQUEST
  };
};

export const fetchCharactersSuccess = (characters, next, prev) => {
  return {
    type: FETCH_CHARACTERS_SUCCESS,
    payload: characters,
    next: next,
    prev: prev
  };
};

export const fetchCharactersFailure = error => {
  return {
    type: FETCH_CHARACTERS_FAILURE,
    payload: error,
    next: null,
    prev: null
  };
};
