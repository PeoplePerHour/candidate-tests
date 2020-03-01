function getPageNumber(pagerUrl) {
  try {
    return Number(pagerUrl.split('=').pop());
  } catch (ex) {
    // In case that a number is not retreived for some
    // unexpected return to first page
    return 1;
  }
}

export default function intializePagerComponent(charactersPages, loadCharactersList) {
  // Pager
  const pagerEl = document.getElementsByTagName('pager')[0];
  pagerEl.innerHTML = '';

  // Previous button
  const prevButtonEL = document.createElement('button');
  prevButtonEL.textContent = 'PREVIOUS';
  if (charactersPages.prev) {
    prevButtonEL.className = 'btn';
    prevButtonEL.addEventListener('click', () => loadCharactersList(getPageNumber(charactersPages.prev)), null);
  } else {
    prevButtonEL.className = 'btn btn-disabled';
  }

  // Next button
  const nextButtonEL = document.createElement('button');
  nextButtonEL.textContent = 'NEXT';
  if (charactersPages.next) {
    nextButtonEL.className = 'btn';
    nextButtonEL.addEventListener('click', () => loadCharactersList(getPageNumber(charactersPages.next)), null);
  } else {
    nextButtonEL.className = 'btn btn-disabled';
  }

  // Add them to pager
  pagerEl.appendChild(prevButtonEL);
  pagerEl.appendChild(nextButtonEL);
}
