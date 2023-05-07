document.addEventListener('DOMContentLoaded', () => {


    // get all the elements
    const addButton = document.querySelector('#add-menu-button');
    const form = document.querySelector('#menu-add-form');
    const cardview = document.querySelector('.card-container');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');
    const allDay = document.querySelector('#all_day');
    const startTimeDiv = document.querySelector('#start-time-div');
    const endTimeDiv = document.querySelector('#end-time-div');


    // make form visible when add button is clicked
    addButton.addEventListener('click', (event) => {
        event.preventDefault();
        form.style.display = 'block';
        cardview.style.filter = 'blur(5px)';

        // focus on first input
        form.querySelector('input').focus();

        //hide time divs
        startTimeDiv.style.display = 'none';
        endTimeDiv.style.display = 'none';

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

    //when all-day is checked hide start and end time
    allDay.addEventListener('change', () => {
        if (allDay.checked) {
            startTimeDiv.style.display = 'none';
            endTimeDiv.style.display = 'none';
            //clear the values
            document.querySelector('#start_time').value = '';
            document.querySelector('#end_time').value = '';
            startTimeDiv.querySelector('input').setAttribute('required', false);
            endTimeDiv.querySelector('input').setAttribute('required', false);
        } else {
            startTimeDiv.style.display = 'block';
            endTimeDiv.style.display = 'block';
            //add required attribute
            startTimeDiv.querySelector('input').setAttribute('required', true);
            endTimeDiv.querySelector('input').setAttribute('required', true);
        }
    });

    function validateTime() {
        const startTime = document.querySelector('#start_time').value;
        const endTime = document.querySelector('#end_time').value;
        // Ensure start time is before end time
        if (startTime >= endTime) {
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Start time must be less than end time", false, 3000);
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    }

// validate time when start,end time is changed and all-day is checked
document.querySelector('#start_time').addEventListener('change', validateTime);
document.querySelector('#end_time').addEventListener('change', validateTime);
// document.querySelector('#all_day').addEventListener('change', validateTime);


});
