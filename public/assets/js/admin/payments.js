document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.querySelector('#add-order-button');
    const form = document.querySelector('#addOrder-form');
    // const table = document.querySelector('#item-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');


    // const category = document.querySelector('select[name="category"]');
    // category.onchange = function () {
    //     this.form.submit();
    // }

    // make form visible when add button is clicked
    addButton.addEventListener('click', () => {
        event.preventDefault();
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';

        // focus on first input
        form.querySelector('input').focus();

        // make add button invisible
        addButton.style.display = 'none';

        // make form invisible when submit button is clicked

    });

    submitButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';

        // make add button visible
        addButton.style.display = 'block';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });

});  