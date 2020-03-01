const LOADER_ID = 'app_loader';

function destroy() {
  const loaderEl = document.getElementById(LOADER_ID);
  if (loaderEl) {
    loaderEl.parentNode.removeChild(loaderEl);
  }
}

function init() {
  // Remove if there is a remaining loader in DOM
  destroy();
  // Create a new one
  const loaderEl = document.createElement('div');
  loaderEl.id = LOADER_ID;
  document.getElementsByTagName('app')[0].appendChild(loaderEl);
}

export { init, destroy };
