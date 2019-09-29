export default (clickedNext,currentPage) => {
  const urlParams = window.location.search;
  const urlSearchParams = new URLSearchParams(window.location.search);
  const paramStartsWith = window.location.search.startsWith("?page=");
  const pageNumber = urlSearchParams.get("page");
  let apiEndpoint = "https://rickandmortyapi.com/api/character/";
  let oldParams = "";
  let newParams = "";
  let newApiEndpoint = null;

  const page = clickedNext
    ? currentPage + 1
    : currentPage - 1;

  if (paramStartsWith) {
    newParams = urlParams.replace(
      pageNumber,
      page
    );
    newApiEndpoint = `${apiEndpoint}${newParams}`;
  } else {
    oldParams = urlParams.replace("?", "&");
    newParams = `?page=${page}${oldParams}`;
    newApiEndpoint = `${apiEndpoint}${newParams}`;
  }
  window.history.pushState({ data: newParams }, "data", newParams);

  return newApiEndpoint;
};
