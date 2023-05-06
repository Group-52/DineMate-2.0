document.addEventListener("DOMContentLoaded", function () {

    var editbutton = document.querySelector("#edit-button");
    editbutton.addEventListener("click", makeEditable);
    var finishbutton = document.querySelector("#finish-button");
    finishbutton.addEventListener('click', () => {
        //     look for any rows with the cross icon visible and simulate a click on the cross icon
        let crossIcons = document.querySelectorAll(".cross-icon");
        crossIcons = Array.from(crossIcons);
        crossIcons.forEach(icon => {
            //check if displayed
            if (icon.parentNode.style.display == "inline-block") {
                icon.click();
            }
        });
    });
    finishbutton.addEventListener("click", makeUneditable);
    const pencilIcons = document.querySelectorAll(".edit-icon");
    const trashIcons = document.querySelectorAll(".trash-icon");
    const popup = document.querySelector(".popup");
    const confirmButton = document.querySelector("#confirm");
    const cancelButton = document.querySelector("#cancel");

    const fieldNames = ['max_stock_level', 'buffer_stock_level', 'reorder_level', 'lead_time'];


    function makeEditable() {
        // Hide the edit button
        editbutton.style.display = "none";
        // Show the update button
        finishbutton.style.display = "inline-block";

        // Show the trash can icon
        for (let i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "inline-block";
        }
        // Show the pencil icon
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
        for (let i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "none";
        }
        // Hide the pencil icon
        for (let i = 0; i < pencilIcons.length; i++) {
            pencilIcons[i].parentNode.style.display = "none";
        }
    }


    // attach click event listener to each pencil icon to make pencil icon disappear and make the cell editable and tick,cross icon appear
    // make only amount remaining, special notes and expiry risk editable

    pencilIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            let row = event.target.parentNode.parentNode;
            // make tick and cross icon visible
            row.querySelector('.tick-icon').parentNode.style.display = 'inline-block';
            row.querySelector('.cross-icon').parentNode.style.display = 'inline-block';
            // make the pencil icon invisible
            event.target.parentNode.style.display = 'none';
            // make the trash icon invisible
            row.querySelector('.trash-icon').parentNode.style.display = 'none';

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
                let row = event.target.parentNode.parentNode;
                row.setAttribute('data-validity', 1);
                if (event.target.classList.contains('tick-icon') && !(validate(row))) {
                    row.setAttribute('data-validity', 0);
                    return;
                }

                // make tick and cross icon invisible
                row.querySelector('.tick-icon').parentNode.style.display = 'none';
                row.querySelector('.cross-icon').parentNode.style.display = 'none';
                // make pencil icon visible
                row.querySelector('.edit-icon').parentNode.style.display = 'inline-block';
                // make trash icon visible
                row.querySelector('.trash-icon').parentNode.style.display = 'inline-block';

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
            let row = event.target.parentNode.parentNode;
            if (row.getAttribute('data-validity') == 1)
                updateInventory(icon);
            else
                row.setAttribute('data-validity', 1);
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
            .then(res => {
                console.log(res);
                new Toast("fa-solid fa-check", "#28a745", "Updated", "Item has been updated", false, 3000);
            })
            .catch(err => {
                new Toast("fa-solid fa-times", "#dc3545", "Error", "Item could not be updated", false, 3000);
                console.log(err)
            })

    }

//Attach event listener to trash icon to display popup
    trashIcons.forEach(t => {
        t.addEventListener('click', function (event) {
            popup.style.display = 'block';
            popup.setAttribute("data-item-id", t.parentNode.parentNode.getAttribute("data-item-id"));
        });
    });

    //Attach event listener to cancel button to hide popup
    cancelButton.addEventListener('click', function (event) {
        popup.style.display = 'none';
        popup.removeAttribute("data-item-id");
    });
    //Attach event listener to delete button to delete item from database
    confirmButton.addEventListener('click', function (event) {
        let id = popup.getAttribute("data-item-id");
        popup.removeAttribute("data-item-id");
        let fetchRes = fetch(
            `${ROOT}/api/inventory/deleteMain`, {
                method: "POST",
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({itemid: id})
            });
        fetchRes.then(res => res.json())
            .then(res => {
                console.log(res);
                new Toast("fa-solid fa-check", "#28a745", "Deleted", "Item has been deleted", false, 3000);
            })
            .catch(err => {
                new Toast("fa-solid fa-times", "#dc3545", "Error", "Item could not be deleted", false, 3000);
                console.log(err)
            })
        popup.style.display = 'none';
        document.querySelector(`tr[data-item-id="${id}"]`).remove();
    });

    //Validate input
    function validate(row) {
        let values = row.querySelectorAll('input');
        //convert to number
        let maxlevel = parseFloat(values[0].value);
        let bufferlevel = parseFloat(values[1].value);
        let reorderlevel = parseFloat(values[2].value);
        let leadtime = parseFloat(values[3].value);

        if (maxlevel == "" || bufferlevel == "" || reorderlevel == "" || leadtime == "" || isNaN(maxlevel) || isNaN(bufferlevel) || isNaN(reorderlevel) || isNaN(leadtime)) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Please fill all fields with valid values", false, 3000);
            return false;
        }
        if (maxlevel < bufferlevel) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Max stock level cannot be less than buffer stock level", false, 3000);
            return false;
        } else if (maxlevel < reorderlevel) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Max stock level cannot be less than re-order level", false, 3000);
            return false;
        } else if (reorderlevel < bufferlevel) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Re-order level cannot be less than buffer stock level", false, 3000);
            return false;
        } else if (leadtime < 0) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Lead time cannot be less than zero", false, 3000);
            return false;
        }
        return true;
    }
});