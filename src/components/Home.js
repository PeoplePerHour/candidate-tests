import React, { useEffect } from "react";
import SearchForm from "./SearchForm";
import CharacterList from "./CharacterList";
import Pagination from "./Pagination";
import { useHistory, useLocation} from "react-router-dom";
import { useSelector, useDispatch } from "react-redux";
import { setSearchParams, fetchCharacters } from "../actions/searchActions";

import * as QueryString from "query-string";

function Home() {
  const name = useSelector((state) => state.characters.name);
  const gender = useSelector((state) => state.characters.gender);
  const page = useSelector((state) => state.characters.page);
  const characters = useSelector((state) => state.characters.data);

  let location = useLocation();
  const params = QueryString.parse(location.search);

  useEffect(() => {
    paramsInitialization();
  }, [params.name, params.gender, params.page]);

  const paramsInitialization = () => {
    const name = params && params.name ? params.name : "";
    const gender = params && params.gender ? params.gender : "";
    const page = params && params.page ? params.page : 1;

    dispatch(setSearchParams("name", name));
    dispatch(setSearchParams("gender", gender));
    dispatch(setSearchParams("page", parseInt(page)));
    dispatch(fetchCharacters(name, gender, page));
  };

  let history = useHistory();
  const dispatch = useDispatch();

  const onInputChange = (valueType, e) => {
    dispatch(setSearchParams(valueType, e.target.value));
  };

  const onPageChange = (action) => {
    let pageNumber = parseInt(page);
    action === "prev"
      ? (pageNumber = parseInt(page) - 1)
      : (pageNumber = parseInt(page) + 1);

    dispatch(setSearchParams("page", pageNumber));
    history.replace({
      search: `?name=${name}&gender=${gender}&page=${pageNumber}`,
    });
  };

  const updateParams = () => {
    history.push({
      search: `?name=${name}&gender=${gender}&page=${page}`,
    });
  };

  const onSubmit = (e) => {
    e.preventDefault();
    updateParams();
  };
  return (
    <div className="container">
      <SearchForm
        onChange={onInputChange}
        onSubmit={onSubmit}
        name={name}
        gender={gender}
      />
      <CharacterList characters={characters} />
      <Pagination changePage={onPageChange} />
    </div>
  );
}

export default Home;
