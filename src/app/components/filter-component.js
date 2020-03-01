// Application Components
import initializeModalComponent from './modal-component';

// Pass dropdown element by reference
function addOptionsToSelect(options, dropdownEl) {
  dropdownEl.appendChild(new Option(''));
  options.forEach((option) => {
    dropdownEl.appendChild(new Option(option));
  });
}

export default function initializeFilterComponent(loadCharactersList) {
  const GENDERS = ['male', 'female', 'genderless', 'unknown'];
  const GENDER_DROPDOWN_ID = 'gender_fitler';
  const STATUS = ['alive', 'dead', 'unknown'];
  const STATUS_DROPDOWN_ID = 'status_filter';

  const filterEl = document.getElementsByTagName('filters')[0];

  const genderDropdownEl = document.createElement('select');
  genderDropdownEl.id = GENDER_DROPDOWN_ID;
  addOptionsToSelect(GENDERS, genderDropdownEl);

  const statusDropdownEl = document.createElement('select');
  statusDropdownEl.id = STATUS_DROPDOWN_ID;
  addOptionsToSelect(STATUS, statusDropdownEl);

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

  filterEl.appendChild(genderDropdownEl);
  filterEl.appendChild(statusDropdownEl);
  filterEl.appendChild(searchButtonEl);
}
