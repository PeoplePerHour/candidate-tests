// Application Components
import initializeModalComponent from './modal-component';

/* #region DROPDOWN FILTERS */
// Pass dropdown element by reference
function addOptionsToSelect(options, dropdownEl) {
  dropdownEl.appendChild(new Option(''));
  options.forEach((option) => {
    dropdownEl.appendChild(new Option(option));
  });
}

function createDropdownElement(dropdownEl, id, options, filters, filterProperty) {
  dropdownEl.id = id;
  addOptionsToSelect(options, dropdownEl);
  if (filters && filters[filterProperty] && options.indexOf(filters[filterProperty]) !== -1) {
    dropdownEl.value = filters[filterProperty];
  }
}
/* #endregion */

export default function initializeFilterComponent(filters, loadCharactersList) {
  const GENDERS = ['male', 'female', 'genderless', 'unknown'];
  const GENDER_DROPDOWN_ID = 'gender_fitler';
  const STATUS = ['alive', 'dead', 'unknown'];
  const STATUS_DROPDOWN_ID = 'status_filter';

  const filterEl = document.getElementsByTagName('filters')[0];

  const genderDropdownEl = document.createElement('select');
  createDropdownElement(genderDropdownEl, GENDER_DROPDOWN_ID, GENDERS, filters, 'gender');

  const statusDropdownEl = document.createElement('select');
  createDropdownElement(statusDropdownEl, STATUS_DROPDOWN_ID, STATUS, filters, 'status');

  const searchButtonEl = document.createElement('button');
  searchButtonEl.textContent = 'SEARCH';
  searchButtonEl.addEventListener('click', () => {
    const selectedGender = document.getElementById(GENDER_DROPDOWN_ID).value;
    const selectedStatus = document.getElementById(STATUS_DROPDOWN_ID).value;
    if (selectedGender || selectedStatus) {
      loadCharactersList(1, {
        ...(selectedGender && { gender: selectedGender }),
        ...(selectedStatus && { status: selectedStatus }),
      });
    } else {
      initializeModalComponent(`
        <h3>Incorrect Search</h3>
        <p>Please select a gender or a status!</p>
      `);
    }
  });

  const clearButtonEl = document.createElement('button');
  clearButtonEl.textContent = 'CLEAR';
  clearButtonEl.addEventListener('click', () => {
    genderDropdownEl.value = '';
    statusDropdownEl.value = '';
    loadCharactersList(1, null);
  });

  filterEl.appendChild(genderDropdownEl);
  filterEl.appendChild(statusDropdownEl);
  filterEl.appendChild(searchButtonEl);
  filterEl.appendChild(clearButtonEl);
}
