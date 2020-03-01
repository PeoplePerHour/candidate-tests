function destroyModalComponent() {
  const modalEl = document.getElementsByTagName('modal')[0];
  const modalBackdropEl = document.getElementsByTagName('modal-backdrop')[0];
  if (modalEl) {
    modalEl.parentNode.removeChild(modalEl);
  }
  if (modalBackdropEl) {
    modalBackdropEl.parentNode.removeChild(modalBackdropEl);
  }
}

export default function initializeModalComponent(modalBody) {
  // Remove if there is a remaining modal in DOM
  destroyModalComponent();
  // Create a new one
  const modalEl = document.createElement('modal');
  const modalBackdropEl = document.createElement('modal-backdrop');
  // Create modal head
  const modalHeadEl = document.createElement('div');
  modalHeadEl.className = 'modal-head';

  const modalCloseButton = document.createElement('button');
  modalCloseButton.textContent = 'x';
  modalCloseButton.addEventListener('click', () => destroyModalComponent());

  modalHeadEl.appendChild(modalCloseButton);

  // Modal body
  const modalBodyEl = document.createElement('div');
  modalBodyEl.className = 'modal-body';
  modalBodyEl.innerHTML = modalBody;

  // Show modal
  modalEl.appendChild(modalHeadEl);
  modalEl.appendChild(modalBodyEl);
  document.getElementsByTagName('app')[0].appendChild(modalBackdropEl);
  document.getElementsByTagName('app')[0].appendChild(modalEl);
}
