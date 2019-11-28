import * as action from "./characters.actions";
import * as actionTypes from "./actionTypes";
import {mockdata} from '../../__mocks__/mocks'


it("should create an action whenfetch has started", () => {
  const expectedAction = {
    type: actionTypes.FETCH_CHARACTERS_START
  };
  expect(action.fetchCharactersStart()).toEqual(expectedAction);
});
it("should create an action whenfetch succsess", () => {
  
  
  const species = ["Human",];

  const expectedAction = {
    type: actionTypes.FETCH_CHARACTERS_SUCCESS,
    payload: mockdata,
    species: species
  };
  expect(action.fetchCharactersSuccess(mockdata)).toEqual(expectedAction);
});
it("should create an action whenfetch fails", () => {
  const expectedAction = {
    type: actionTypes.FETCH_CHARACTERS_FAIL
  };
  expect(action.fetchCharactersFail()).toEqual(expectedAction);
});

