document.addEventListener("DOMContentLoaded", function () {

    var editbutton = document.querySelector("#edit-button");
    editbutton.addEventListener("click", makeEditable);
    var finishbutton = document.querySelector("#finish-button");
    finishbutton.addEventListener("click", makeUneditable);
    const fieldNames = ['expiry_risk', 'amount_remaining', 'special_notes'];

    function makeEditable() {
        // Hide the edit button
        editbutton.style.display = "none";
        // Show the update button
        finishbutton.style.display = "inline-block";

        // Show the trash can icon
        const trashIcons = document.querySelectorAll(".trash-icon");
        for (i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "inline-block";
        }
        // Show the pencil icon
        const pencilIcons = document.querySelectorAll(".edit-icon");
        for (i = 0; i < pencilIcons.length; i++) {
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
        for (i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "none";
        }
        // Hide the pencil icon
        const pencilIcons = document.querySelectorAll(".edit-icon");
        for (i = 0; i < pencilIcons.length; i++) {
            pencilIcons[i].parentNode.style.display = "none";
        }
    }

    function updateInventory(icon) {

        var data = [];
        let newValue;

        // collect data from the row
        let row = icon.parentNode.parentNode;
        let cells = row.querySelectorAll('td');
        let id = row.getAttribute("data-purchase-id");
        for (let i = 0; i < cells.length; i++) {
            const fieldName = cells[i].getAttribute("data-field-name");
            if (fieldName) {
                if (fieldName == 'expiry_risk') {
                    newValue = cells[i].querySelector('select').value;
                }
                else if (fieldName == 'special_notes') {
                    newValue = cells[i].querySelector('input').value;
                    if (newValue == '')
                        newValue = null;
                }
                else if (fieldName == 'amount_remaining') {
                    newValue = cells[i].querySelector('input').value;
                    newValue = newValue == '' ? '0' : newValue;
                }
                data.push({
                    pid: id,
                    fieldName: fieldName,
                    newValue: newValue
                });
                console.log("Gonna send this data to server: ", data);
            }
        }

        // Send data to server
        let fetchRes = fetch(
            `${ROOT}/api/inventory/updateInventory`, {
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


    // Select all trash can icons
    const trashIcons = document.querySelectorAll(".fa-trash");
    // Attach click event listener to each trash can icon
    trashIcons.forEach(function (trashIcon) {
        trashIcon.addEventListener("click", function (event) {
            // Get the purchase ID from the parent tr element
            const purchaseId = this.parentNode.parentNode.getAttribute("data-purchase-id")

            // Use the fetch API to send a DELETE request to the server
            let fetchRes2 = fetch(`${ROOT}/api/inventory/deleteInventory`, {
                method: 'POST',
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    purchaseId: purchaseId
                })
            })

            fetchRes2
                .then(res => res.json())
                .then(() => {
                    const tableRow = event.target.parentNode.parentNode;
                    tableRow.style.height = "0";
                    tableRow.classList.add("shrink");

                    setTimeout(function () {
                        tableRow.remove();
                    }, 300);
                })
                .catch(err => {
                    console.log(err)
                })
        });
    });

    // attach click event listener to each pencil icon to make trash and pencil icon disappear and make the cell editable and tick,cross icon appear
    const pencilIcons = document.querySelectorAll('.edit-icon');
    pencilIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            // make tick and cross icon visible
            event.target.parentNode.parentNode.querySelector('.tick-icon').parentNode.style.display = 'inline-block';
            event.target.parentNode.parentNode.querySelector('.cross-icon').parentNode.style.display = 'inline-block';
            // make trash and pencil icon invisible
            event.target.parentNode.style.display = 'none';
            event.target.parentNode.parentNode.querySelector('.trash-icon').parentNode.style.display = 'none';

            const row = event.target.parentNode.parentNode;
            row.classList.add('row-in-form');

            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                if (fieldNames.includes(cell.dataset.fieldName)) {
                    cell.classList.add('editable');

                    var currentValue = cell.textContent;
                    cell.innerHTML = '';

                    // Add input element to the cell and set the value to the current value
                    if (cell.dataset.fieldName === 'amount_remaining') {
                        const input = document.createElement('input');
                        currentValue = currentValue.replace(/[^0-9.]/g, "");
                        currentValue = parseFloat(currentValue);
                        input.type = 'number';
                        input.value = currentValue;
                        cell.appendChild(input);
                        let unit = " " + cell.getAttribute('data-unit');
                        cell.append(unit);
                        input.classList.add('newly-editable');
                    } else if (cell.dataset.fieldName === 'special_notes') {
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.value = currentValue;
                        input.classList.add('newly-editable');
                        cell.appendChild(input);
                    }
                    else if (cell.dataset.fieldName === 'expiry_risk') {
                        const input = document.createElement('select');
                        input.innerHTML = `<option value="1">Yes</option>
                        <option value="0">No</option> `;
                        input.value = (currentValue == 'No') ? 0 : 1;
                        input.classList.add('newly-editable');
                        cell.appendChild(input);
                    }
                }
            });
        });
    });

    // Attack click eevent listener to each tick icon to update the database
    const tickIcons = document.querySelectorAll('.tick-icon');
    tickIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            updateInventory(event.target);
        });

    });

    // Attach click event listener to each tick and cross icon to make the cell uneditable and trash and pencil icon appear
    const editIcons = document.querySelectorAll('.edit-options');
    editIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            // make tick and cross icon invisible
            event.target.parentNode.parentNode.querySelector('.tick-icon').parentNode.style.display = 'none';
            event.target.parentNode.parentNode.querySelector('.cross-icon').parentNode.style.display = 'none';
            // make trash and pencil icon visible
            event.target.parentNode.parentNode.querySelector('.trash-icon').parentNode.style.display = 'inline-block';
            event.target.parentNode.parentNode.querySelector('.edit-icon').parentNode.style.display = 'inline-block';

            const row = event.target.parentNode.parentNode;
            row.classList.remove('row-in-form');

            // Remove the input element from the cell and set the value to the current value
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                if (fieldNames.includes(cell.dataset.fieldName)) {

                    if (cell.dataset.fieldName === 'expiry_risk') {
                        let input = cell.querySelector('select');
                        cell.textContent = input.value == 1 ? 'Yes' : 'No';
                    }
                    else if (cell.dataset.fieldName === 'special_notes') {
                        let input = cell.querySelector('input');
                        if (!input.value)
                            input.value = "";
                        cell.textContent = input.value;
                    }
                    else if (cell.dataset.fieldName === 'amount_remaining') {
                        let input = cell.querySelector('input');
                        if (input.value == "" || input.value == null)
                            input.value = 0;
                        cell.textContent = input.value + " " + cell.getAttribute('data-unit');
                    }
                    cell.classList.remove('editable');
                }
            });
        });
    }
    );


});