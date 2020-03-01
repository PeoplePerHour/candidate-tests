// Application Components
import * as loaderComponent from './loader-component';
// Application Services
import * as apiHttpService from '../services/api-http-service';

function createCharacterListTiles(charactersList) {
  const listEl = document.getElementsByTagName('list')[0];
  for (let i = 0; i < charactersList.length; i++) {
    const listTileEl = document.createElement('div');
    listTileEl.id = charactersList[i].id;
    listTileEl.className = 'list-tile';
    listTileEl.innerHTML = `
      <img src="${charactersList[i].image}">
      <div class="character-info">
        <h3 class="character-name">${charactersList[i].name}</h3>
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
    createCharacterListTiles(charactersListInfo.results);
    // Remove loader
    loaderComponent.destroy();
  });
}

export default function initializeListComponent() {
  loadCharactersList(1);
}
