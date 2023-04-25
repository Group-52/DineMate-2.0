document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.querySelector('#add-vendor-button');
    const form = document.querySelector('#vendor-form');
    const table = document.querySelector('#vendor-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');

    //make first row of tbody disappear (Unknown vendor)
    table.querySelector('tbody tr').style.display = 'none';

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
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("vendor-table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
});

