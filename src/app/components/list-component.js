// Application Components
import * as loaderComponent from './loader-component';
import intializePagerComponent from './pager-component';
// Application Services
import * as apiHttpService from '../services/api-http-service';

function createCharacterListTiles(charactersList) {
  const listEl = document.getElementsByTagName('list')[0];
  listEl.innerHTML = '';
  for (let i = 0; i < charactersList.length; i++) {
    const listTileEl = document.createElement('div');
    listTileEl.id = charactersList[i].id;
    listTileEl.className = 'list-tile';
    listTileEl.innerHTML = `
      <img class="character-photo" src="${charactersList[i].image}">
      <div class="character-info-container">
        <h3 class="character-name">${charactersList[i].name}</h3>
        <div class="character-info">Gender: ${charactersList[i].name}</div>
        <div class="character-info">Species: ${charactersList[i].species}</div>
        <div class="character-info">Status: ${charactersList[i].status}</div>
        <div class="character-info">Origin: ${charactersList[i].origin.name}</div>
      </div>
    `;
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
