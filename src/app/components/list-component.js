// Application Components
import * as loaderComponent from './loader-component';
// Application Services
import * as apiHttpService from '../services/api-http-service';

function loadCharactersList(page) {
  // Show a loader
  loaderComponent.init();
  // Get characters list
  apiHttpService.getCharactersList(page).then((charactersList) => {
    console.log(charactersList);
    // Remove loader
    loaderComponent.destroy();
  });
}

export default function initializeListComponent() {
  loadCharactersList(1);
}
