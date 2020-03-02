// Application Services
import * as urlFiltersService from '../services/url-filters-service';

// Pass button element by reference
function createPagerButton(loadCharactersList, buttonEl, buttonUrl, type) {
  buttonEl.textContent = type === 'prev' ? 'PREVIOUS' : 'NEXT';
  if (buttonUrl) {
    buttonEl.className = 'btn';
    buttonEl.addEventListener('click', () => {
      loadCharactersList(
        Number(urlFiltersService.getFiltersFromUrl()[0])
        + (type === 'prev' ? -1 : +1),
        urlFiltersService.getFiltersFromUrl()[1],
      );
    });
  } else {
    buttonEl.className = 'btn btn-disabled';
  }
}

export default function intializePagerComponent(charactersPages, loadCharactersList) {
  // Pager
  const pagerEl = document.getElementsByTagName('pager')[0];
  pagerEl.innerHTML = '';

  // Previous button
  const prevButtonEL = document.createElement('button');
  createPagerButton(loadCharactersList, prevButtonEL, charactersPages.prev, 'prev');

  // Next button
  const nextButtonEL = document.createElement('button');
  createPagerButton(loadCharactersList, nextButtonEL, charactersPages.next, 'next');

  // Add them to pager
  pagerEl.appendChild(prevButtonEL);
  pagerEl.appendChild(nextButtonEL);
}
