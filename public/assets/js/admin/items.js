document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.querySelector('#add-item-button');
    const form = document.querySelector('#item-form');
    const table = document.querySelector('#item-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');


    const category = document.querySelector('select[name="category"]');
    category.onchange = function () {
        if (category.value == 'All') {
            window.location.href = `${ROOT}/admin/items`;
        }
        this.form.submit();
    }

    // make form visible when add button is clicked
    addButton.addEventListener('click', () => {
        event.preventDefault();
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';
        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';


    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        form.querySelector('form').reset();
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });

});