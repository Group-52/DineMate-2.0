document.addEventListener("DOMContentLoaded", function () {

    var editbutton = document.querySelector("#edit-button");
    editbutton.addEventListener("click", makeEditable);
    var finishbutton = document.querySelector("#finish-button");
    finishbutton.addEventListener("click", makeUneditable);
    const pencilIcons = document.querySelectorAll(".edit-icon");

    let rows = document.querySelectorAll('tr');
    rows = Array.from(rows).slice(1);
    rows.forEach(row => {
            // turn into floats and compare
            const cells = row.querySelectorAll('td');
            // get only numeric part of the amount_remaining
            const amount_remaining = cells[1].textContent.split(' ')[0];
            const max_stock_level = parseFloat(cells[3].textContent);
            const buffer_stock_level = parseFloat(cells[4].textContent);
            const reorder_level = parseFloat(cells[5].textContent);

            if (amount_remaining < buffer_stock_level) {
                row.style.color = 'red';
            }else if (amount_remaining < reorder_level) {
                row.style.color = '#c07906';
            } else if (amount_remaining > max_stock_level) {
                row.style.color = 'blue';
            } else {
                row.style.color = 'green';
            }

        }
    );

    const fieldNames = ['max_stock_level', 'buffer_stock_level', 'reorder_level', 'lead_time'];


    function makeEditable() {
        // Hide the edit button
        editbutton.style.display = "none";
        // Show the update button
        finishbutton.style.display = "inline-block";

        // Show the trash can icon
        const trashIcons = document.querySelectorAll(".trash-icon");
        for (let i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "inline-block";
        }
        // Show the pencil icon
        const pencilIcons = document.querySelectorAll(".edit-icon");
        for (let i = 0; i < pencilIcons.length; i++) {
            pencilIcons[i].parentNode.style.display = "inline-block";
        }
    }

    function makeUneditable() {
        // Show the edit button
        editbutton.style.display = "inline-block";
        // Hide the update button
        finishbutton.style.display = "none";

        // Hide the trash can icon
        const trashIcons = document.querySelectorAll(".trash-icon");
        for (let i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "none";
        }
        // Hide the pencil icon
        const pencilIcons = document.querySelectorAll(".edit-icon");
        for (let i = 0; i < pencilIcons.length; i++) {
            pencilIcons[i].parentNode.style.display = "none";
        }
    }


    // attach click event listener to each pencil icon to make pencil icon disappear and make the cell editable and tick,cross icon appear
    // make only amount remaining, special notes and expiry risk editable

    pencilIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            // make tick and cross icon visible
            event.target.parentNode.parentNode.querySelector('.tick-icon').parentNode.style.display = 'inline-block';
            event.target.parentNode.parentNode.querySelector('.cross-icon').parentNode.style.display = 'inline-block';
            // make the pencil icon invisible
            event.target.parentNode.style.display = 'none';

            const row = event.target.parentNode.parentNode;
            row.classList.add('row-in-form');

            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                if (fieldNames.includes(cell.dataset.fieldName)) {
                    cell.classList.add('editable');

                    const currentValue = cell.textContent;
                    cell.innerHTML = '';

                    const input = document.createElement('input');
                    input.type = 'number';
                    input.value = currentValue;
                    input.min = '0';
                    input.style.width = '30%';
                    input.setAttribute('oninput', "validity.valid||(value='');");
                    input.classList.add('newly-editable');
                    cell.appendChild(input);
                    // store the previous value temporarily
                    cell.setAttribute('data-previous-value', input.value);

                }
            });
        });
    });

    // Attach click event listener to each tick and cross icon to make the cell uneditable and pencil icon appear
    const editIcons = document.querySelectorAll('.edit-options');
    editIcons.forEach(icon => {
            icon.addEventListener('click', function (event) {
                // make tick and cross icon invisible
                event.target.parentNode.parentNode.querySelector('.tick-icon').parentNode.style.display = 'none';
                event.target.parentNode.parentNode.querySelector('.cross-icon').parentNode.style.display = 'none';
                // make pencil icon visible
                event.target.parentNode.parentNode.querySelector('.edit-icon').parentNode.style.display = 'inline-block';

                const row = event.target.parentNode.parentNode;
                row.classList.remove('row-in-form');

                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    if (fieldNames.includes(cell.dataset.fieldName)) {
                        cell.classList.remove('editable');

                        const input = cell.querySelector('input');
                        // if the icon is the cross icon, revert the value to the previous value
                        if (icon.classList.contains('cross-icon')) {
                            cell.textContent = cell.getAttribute('data-previous-value');
                            cell.removeAttribute('data-previous-value');
                        }
                        // else, update the value to the new value
                        else
                            cell.textContent = input.value;
                    }
                });
            });
        }
    );

    // Attach click event listener to each tick icon to update the database
    const tickIcons = document.querySelectorAll('.tick-icon');
    tickIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            updateInventory(icon);
        });
    });


    function updateInventory(icon) {

        let data = [];

        // collect data from the row
        let row = icon.parentNode.parentNode;
        let cells = row.querySelectorAll('td');
        let id = row.getAttribute("data-item-id");
        for (let i = 0; i < cells.length; i++) {
            const fieldName = cells[i].getAttribute("data-field-name");
            // remove the data-previous-value attribute
            cells[i].removeAttribute('data-previous-value');
            if (fieldName) {
                let newValue = cells[i].innerHTML;
                data.push({
                    itemid: id,
                    fieldName: fieldName,
                    newValue: newValue
                });
            }
        }

        // Send data to server
        let fetchRes = fetch(
            `${ROOT}/api/inventory/updateMain`, {
                method: "POST",
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            });

        fetchRes.then(res => res.json())
            .catch(err => {
                console.log(err)
            })

    }
});