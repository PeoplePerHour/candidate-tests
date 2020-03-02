function addFiltersToUrl(page, filters) {
  let urlFilters = '?';
  if (page && Number(page) > 0) {
    urlFilters += `page=${page}`;
  } else {
    urlFilters += 'page=1';
  }
  if (filters) {
    if (filters.gender) {
      urlFilters += `&gender=${filters.gender}`;
    }
    if (filters.status) {
      urlFilters += `&status=${filters.status}`;
    }
  }
  window.history.pushState('', '', urlFilters);
}

function getFiltersFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page') || 1;
  const gender = urlParams.get('gender');
  const status = urlParams.get('status');
  if (gender || status) {
    return [
      page,
      {
        ...(gender && { gender }),
        ...(status && { status }),
      },
    ];
  }
  return [page, null];
}

export { addFiltersToUrl, getFiltersFromUrl };
