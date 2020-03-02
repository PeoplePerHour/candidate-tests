// Application Components
import * as loaderComponent from './loader-component';
import intializePagerComponent from './pager-component';
import initializeModalComponent from './modal-component';
import initializeFilterComponent from './filter-component';
// Application Services
import getCharactersList from '../services/api-http-service';
import * as urlFiltersService from '../services/url-filters-service';

/* #region LIST TILES */
function createCharacterBasicInfo(character, extraInfo) {
  return `
    <img class="character-photo" src="${character.image}">
    <h3 class="character-name">${character.name}</h3>
    <div class="character-info-container">
      <div class="character-info">Gender: ${character.gender}</div>
      <div class="character-info">Species: ${character.species}</div>
      <div class="character-info">Status: ${character.status}</div>
      ${extraInfo}
    </div>
  `;
}

function createCharacterModalBody(character) {
  const episodes = character.episode.map((episode) => `<span>${episode.split('/').pop()}</span>`);
  const extraInfo = `
    <div class="character-info">Origin: ${character.origin.name}</div>
    <div class="character-info">Location: ${character.location.name}</div>
    <div class="character-info">Episodes: ${episodes.toString()}</div>
  `;
  return createCharacterBasicInfo(character, extraInfo);
}

function createCharacterListTiles(charactersList) {
  const listEl = document.getElementsByTagName('list')[0];
  listEl.innerHTML = '';
  charactersList.forEach((character) => {
    const listTileEl = document.createElement('div');
    listTileEl.className = 'list-tile';
    listTileEl.innerHTML = createCharacterBasicInfo(character, '');
    listTileEl.addEventListener('click', () => {
      initializeModalComponent(createCharacterModalBody(character));
    });
    listEl.appendChild(listTileEl);
  });
}
/* #endregion */

/* #region LOAD LIST */
function loadCharactersList(page, filters) {
  // Show a loader
  loaderComponent.init();
  // Get characters list
  getCharactersList(page, filters).then((charactersListInfo) => {
    // Scroll to top of the page
    window.scrollTo(0, 0);
    // Create list with pager
    createCharacterListTiles(charactersListInfo.results);
    intializePagerComponent(charactersListInfo.info, loadCharactersList);
    // Add filter to url in order to user to see
    // the same list items when hits refresh
    urlFiltersService.addFiltersToUrl(page, filters);
    // Remove loader
    loaderComponent.destroy();
  }, () => {
    // Remove loader
    loaderComponent.destroy();
    initializeModalComponent(`
      <h3>We are sorry :(</h3>
      <p>Something went wrong, please try again!</p>
    `);
  });
}
/* #endregion */

export default function initializeListComponent() {
  const userFilters = urlFiltersService.getFiltersFromUrl();
  loadCharactersList(userFilters[0], userFilters[1]);
  initializeFilterComponent(userFilters[1], loadCharactersList);
}
