import {FiltersForm} from "./modules/FiltersForm.js";
// import {FiltersFormWithPagination} from "./modules/FiltersFormWithPagination.js";


const form = new FiltersForm("filters");
// const pagination = new FiltersFormWithPagination("filters");

// // Get a reference to the "reset" button and add an event listener
// const resetButton = document.getElementById('reset-filters');
// resetButton.addEventListener('click', () => filters.uncheckAllCheckboxes());
// Get a reference to the "reset" button
// const resetButton = document.getElementById('reset-filters');
//
// // Bind the click event to the button
// resetButton.addEventListener('click', function (event) {
//     // Get the form element using the data-form-id attribute
//     event.preventDefault();
//     const formId = this.dataset.formId;
//     const formElement = document.getElementById(formId);
//
//     // Get all checkbox inputs within the form element
//     const checkboxes = formElement.querySelectorAll('input[type="checkbox"]');
//
//     // Loop through the checkboxes and set their checked property to false
//     checkboxes.forEach(checkbox => {
//         checkbox.checked = false;
//     });
// });

