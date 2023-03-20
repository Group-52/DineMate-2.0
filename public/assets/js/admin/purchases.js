
document.addEventListener('DOMContentLoaded', () => {

    // get all the elements
    const addButton = document.querySelector('#add-purchase-button');
    const form = document.querySelector('#Addform');
    const table = document.querySelector('#purchase-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');


    // make form visible when add button is clicked
    addButton.addEventListener('click', () => {
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';

        // focus on first input
        document.querySelector('#purchase_date').focus();

        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when submit button is clicked
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
