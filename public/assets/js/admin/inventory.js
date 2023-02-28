document.addEventListener("DOMContentLoaded", function () {

    var editbutton = document.querySelector("#edit-button");
    editbutton.addEventListener("click", makeEditable);
    var finishbutton = document.querySelector("#finish-button");
    finishbutton.addEventListener("click", makeUneditable);
    const pencilIcons = document.querySelectorAll(".edit-icon");
    const trashIcons = document.querySelectorAll(".trash-icon");
    const popup = document.querySelector(".popup");
    const confirmButton = document.querySelector("#confirm");
    const cancelButton = document.querySelector("#cancel");


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

            const circle = cells[7].querySelector('#circle');
            // change color of circle icon
            if (amount_remaining < buffer_stock_level) {
                circle.style.backgroundColor = '#EE4A1C';
            } else if (amount_remaining < reorder_level) {
                circle.style.backgroundColor = '#E5A113';
            } else if (amount_remaining > max_stock_level) {
                circle.style.backgroundColor = '#138DE5';
            } else {
                circle.style.backgroundColor = 'lightgreen';
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

    // Attach click event listener to each tick icon to update the database
    const tickIcons = document.querySelectorAll('.tick-icon');
    tickIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            updateInventory(icon);
        });
    });

    // Attach click event listener to each tick and cross icon to make the cell uneditable and pencil icon appear
    const editIcons = document.querySelectorAll('.edit-options');
    editIcons.forEach(icon => {
            icon.addEventListener('click', function (event) {
                let row = event.target.parentNode.parentNode;
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


    // Get the current page number from the URL
    const currentPage = parseInt(new URLSearchParams(window.location.search).get('page')) || 1;
    const pages = document.querySelectorAll('.page-item');

    pages.forEach(page => {
        const pageLink = page.querySelector('.page-link');
        const pageNumber = parseInt(pageLink.innerText);

        if (pageNumber === currentPage) {
            page.classList.add('active');
        }
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
            .catch(err => {
                console.log(err)
            })
        popup.style.display = 'none';
        document.querySelector(`tr[data-item-id="${id}"]`).remove();
    });
});