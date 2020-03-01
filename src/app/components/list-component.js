// Application Components
import * as loaderComponent from './loader-component';
import intializePagerComponent from './pager-component';
import initializeModalComponent from './modal-component';
// Application Services
import * as apiHttpService from '../services/api-http-service';

function createCharacterBasicInfo(character, extraInfo) {
  return `
    <img class="character-photo" src="${character.image}">
    <h3 class="character-name">${character.name}</h3>
    <div class="character-info-container">
      <div class="character-info">Gender: ${character.name}</div>
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
  for (let i = 0; i < charactersList.length; i++) {
    const listTileEl = document.createElement('div');
    listTileEl.className = 'list-tile';
    listTileEl.innerHTML = createCharacterBasicInfo(charactersList[i], '');
    listTileEl.addEventListener('click', () => {
      initializeModalComponent(createCharacterModalBody(charactersList[i]));
    });
    listEl.appendChild(listTileEl);
  }
}

function loadCharactersList(page) {
  // Show a loader
  loaderComponent.init();
  // Get characters list
  apiHttpService.getCharactersList(page).then((charactersListInfo) => {
    console.log(charactersListInfo);
    window.scrollTo(0, 0);
    createCharacterListTiles(charactersListInfo.results);
    intializePagerComponent(charactersListInfo.info, loadCharactersList);
    // Remove loader
    loaderComponent.destroy();
  });
}

export default function initializeListComponent() {
  loadCharactersList(1);
}
