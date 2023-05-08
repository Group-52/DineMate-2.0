document.addEventListener('DOMContentLoaded', () => {


    // get all the elements
    const addButton = document.querySelector('#add-menu-button');
    const form = document.querySelector('#menu-add-form');
    const cardview = document.querySelector('.card-container');
    const cancelButton = document.querySelector('#cancel-button');

    // make form visible when add button is clicked
    addButton.addEventListener('click', (event) => {
        event.preventDefault();
        form.style.display = 'block';
        cardview.style.filter = 'blur(5px)';
        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        form.style.display = 'none';
        form.querySelector('form').reset();
        cardview.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });



});
