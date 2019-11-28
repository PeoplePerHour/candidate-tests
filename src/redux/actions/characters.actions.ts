import * as actionTypes from "./actionTypes";
import * as models from "../../models";
import store from '../store'
export type AppDispatch = typeof store.dispatch
import {afetchCharacters} from '../../helpers/apicalls'

export const fetchCharactersStart = () => {
  return {
    type: actionTypes.FETCH_CHARACTERS_START
  };
};

export const fetchCharactersSuccess = (data:any)  => {
  let species = data.results.map((d:models.ICharacter) => d.species);
  const onlyUnique = (value:string, index:number, self:any) => self.indexOf(value) === index;
  species = species.filter(onlyUnique);

  return {
    type: actionTypes.FETCH_CHARACTERS_SUCCESS,
    payload: data,
    species: species
  };
};

export const fetchCharactersFail = (error:string) => {
  return {
    type: actionTypes.FETCH_CHARACTERS_FAIL,
    error
  };
};

export const fetchCharacters = (query = "") => {
  return (dispatch:AppDispatch) => {
    dispatch(fetchCharactersStart());
    afetchCharacters(query).then(response => {
       dispatch(fetchCharactersSuccess(response));
      })
      .catch(error => {
        console.log("ERROR IS SHEARCH",error)
        dispatch(fetchCharactersFail(error.response));
      });
  };
};
