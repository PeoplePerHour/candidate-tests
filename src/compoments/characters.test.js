import React from "react";
import { render, unmountComponentAtNode } from "react-dom";
import { act } from "react-dom/test-utils";
import Characters from "./characters";
import { Provider } from "react-redux";
import configureMockStore from "redux-mock-store";
import thunk from "redux-thunk";

const middlewares = [thunk];
const mockStore = configureMockStore(middlewares);

describe("Characters tests", () => {
  let container;

  beforeEach(() => {
    container = document.createElement("div");
    document.body.appendChild(container);
  });

  afterEach(() => {
    unmountComponentAtNode(container);
    container.remove();
    container = null;
  });

  it("Should contain form", () => {
    act(() => {
      const initialState = {
        characterState: {
          loading: false,
          characters: [],
          error: "",
          next: null,
          prev: null
        }
      };
      let store;
      store = mockStore(initialState);

      render(
        <Provider store={store}>
          <Characters />
        </Provider>,
        container
      );
    });
    expect(container.getElementsByTagName("form").length).toBe(1);
  });

  it("Should contain card", () => {
    act(() => {
      const initialState = {
        characterState: {
          loading: false,
          characters: [
            {
              name: "Morty Smith",
              gender: "Male",
              status: "Alive",
              species: "Human",
              location: "Earth (Replacement Dimension)",
              origin: "Earth (C-137)",
              episode: ["https://rickandmortyapi.com/api/episode/1"]
            }
          ],
          error: "",
          next: null,
          prev: null
        }
      };
      let store;
      store = mockStore(initialState);

      render(
        <Provider store={store}>
          <Characters />
        </Provider>,
        container
      );
    });
    expect(container.getElementsByClassName("card").length).toBe(1);
  });
});
