export default (filterBy,value) => {

    let urlParams = window.location.search;
    let urlSearchParams = new URLSearchParams(urlParams);
    const joinArg = urlParams[0] === "?" ? "&" : "?";
    let newArg = `${joinArg}${filterBy}=${value}`;

    if (!urlParams.includes(filterBy)) {
      window.history.pushState(
        { newArg: newArg },
        "newArg",
        urlParams.concat(newArg)
      );
    }

    if (urlParams.includes(filterBy)) {
      let filter = urlSearchParams.get(filterBy);
      let newParams = urlParams.replace(filter, value);
      console.log("new params", newParams);
      window.history.replaceState({ data: newParams }, "data", newParams);
    }

    const apiEndpoint =
      urlParams === ""
        ? `https://rickandmortyapi.com/api/character/?${filterBy}=${value}`
        : `https://rickandmortyapi.com/api/character/${window.location.search}`;
    console.log(apiEndpoint);

    return apiEndpoint;
  }
