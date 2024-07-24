document.addEventListener('DOMContentLoaded', function() {
    const searchBooksForm = document.getElementById('search-books-form');
    const bookDetailsForm = document.getElementById('book-details-form');
    const borrowBookForm = document.getElementById('borrow-book-form');
    const returnBookForm = document.getElementById('return-book-form');
    const patronAccountForm = document.getElementById('patron-account-form');
    const librarianManagementForm = document.getElementById('librarian-management-form');
    function validateForm(event, form) {
    const inputs = form.querySelectorAll('input');
    let valid = true;
    inputs.forEach(input => {
    if (input.value.trim() === '') {
    valid = false;
    input.style.border = '1px solid red';
    } else {
    input.style.border = '';
    }
    });
    if (!valid) {
    event.preventDefault();
    alert('Please fill out all fields.');
    }
    }
    if (searchBooksForm) searchBooksForm.addEventListener('submit', (event) =>
   validateForm(event, searchBooksForm));
    if (bookDetailsForm) bookDetailsForm.addEventListener('submit', (event) => validateForm(event,
   bookDetailsForm));
    if (borrowBookForm) borrowBookForm.addEventListener('submit', (event) => validateForm(event,
   borrowBookForm));
    if (returnBookForm) returnBookForm.addEventListener('submit', (event) => validateForm(event,
   returnBookForm));
    if (patronAccountForm) patronAccountForm.addEventListener('submit', (event) =>
   validateForm(event, patronAccountForm));
    if (librarianManagementForm) librarianManagementForm.addEventListener('submit', (event) =>
   validateForm(event, librarianManagementForm));
   });