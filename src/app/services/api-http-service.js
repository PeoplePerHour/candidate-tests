// Application Constants
import * as Constants from '../constants/constants';

/* #region URL HEPLERS */
function createUrl(apiEndpoint, apiAction, queryStrings) {
  const apiEndpointWithAction = `${apiEndpoint}/${apiAction}`;
  return apiEndpointWithAction + (queryStrings ? `?${queryStrings}` : '');
}

function createQueryParameters(queryStrings) {
  const paramsAndValues = [];
  queryStrings.forEach((queryString) => {
    if (queryString) {
      Object.keys(queryString).forEach((key) => {
        if (key) {
          const value = encodeURIComponent(queryString[key].toString());
          paramsAndValues.push([key, value].join('='));
        }
      });
    }
  });
  return paramsAndValues.join('&');
}
/* #endregion */

/* #region HTTP CALLS */
// GET
function apiHttpGet(apiCallUrl) {
  return new Promise((resolve, reject) => {
    fetch(apiCallUrl)
      .then((r) => {
        if (!r.ok) {
          throw Error(r.statusText);
        } else {
          return r.json();
        }
      })
      .then((data) => resolve(data))
      .catch((e) => reject(e));
  });
}
/* #endregion */

export default function getCharactersList(page, filters) {
  let queryStrings;
  if (filters) {
    queryStrings = createQueryParameters([
      { page },
      ...(filters.gender && { gender: filters.gender }),
      ...(filters.status && { status: filters.status }),
    ]);
  } else {
    queryStrings = createQueryParameters([{ page }]);
  }
  const apiUrl = createUrl(Constants.API_ENDPOINT, 'character', queryStrings);
  return apiHttpGet(apiUrl);
}
