document.addEventListener('DOMContentLoaded', () => {

    // get all the elements
    const addButton = document.querySelector('#add-purchase-button');
    const form = document.querySelector('#Addform');
    const table = document.querySelector('#purchase-table');
    const formcancelButton = document.querySelector('#cancel-button');
    const unitspan = document.querySelector('#unitspan');

    const editbutton = document.querySelector('#edit-button');
    const finishbutton = document.querySelector('#finish-button');
    const pencilIcons = document.querySelectorAll(".edit-icon");
    const trashIcons = document.querySelectorAll(".fa-trash");

    let rows = document.querySelectorAll('tr');
    rows = Array.from(rows).slice(1);
    const fieldNames = ['purchase_date', 'item', 'quantity', 'brand', 'expiry_date', 'cost', 'discount', 'final_price', 'tax'];

    editbutton.addEventListener('click', makeEditable);
    finishbutton.addEventListener('click', () => {
        //     look for any rows with the cross icon visible and simulate a click on the cross icon
        let crossIcons = document.querySelectorAll(".cross-icon");
        crossIcons = Array.from(crossIcons);
        crossIcons.forEach(icon => {
            if (icon.parentNode.style.display =='table-cell') {
                icon.click();
            }
        });
    });
    finishbutton.addEventListener('click', makeUneditable);

    // make form visible when add button is clicked
    addButton.addEventListener('click', () => {
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';

        // focus on first input
        document.querySelector('#purchase_date').focus();

        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when cancel button is clicked
    formcancelButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'inline-block';
    });

    function makeEditable() {
        // Hide the edit button
        editbutton.style.display = "none";
        // Show the update button
        finishbutton.style.display = "inline-block";

        // Show the trash can icon
        const trashIcons = document.querySelectorAll(".trash-icon");
        for (let i = 0; i < trashIcons.length; i++) {
            trashIcons[i].parentNode.style.display = "table-cell";
        }
        // Show the pencil icon
        const pencilIcons = document.querySelectorAll(".edit-icon");
        for (let i = 0; i < pencilIcons.length; i++) {
            pencilIcons[i].parentNode.style.display = "table-cell";
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
    pencilIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            let row = event.target.parentNode.parentNode;
            // make tick and cross icon visible
            row.querySelector('.tick-icon').parentNode.style.display = 'table-cell';
            row.querySelector('.cross-icon').parentNode.style.display = 'table-cell';
            // make the pencil icon invisible
            event.target.parentNode.style.display = 'none';
            // make trash icon invisible
            row.querySelector('.trash-icon').parentNode.style.display = 'none';

            row.classList.add('row-in-form');

            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                if (fieldNames.includes(cell.dataset.fieldName)) {
                    let currentValue = cell.textContent;
                    cell.innerHTML = '';
                    const input = document.createElement('input');

                    if (cell.dataset.fieldName === 'purchase_date' || cell.dataset.fieldName === 'expiry_date') {
                        input.type = 'date';
                    } else if (cell.dataset.fieldName === 'brand') {
                        input.type = 'text';
                        input.style.width = '60%';
                    } else if (cell.dataset.fieldName === 'quantity') {
                        input.type = 'number';
                        input.step = '0.01';
                        // parse numeric value from string
                        currentValue = currentValue.replace(/[^0-9.]/g, '');
                        input.min = '0';
                        input.style.width = '60%';
                    } else {
                        input.type = 'number';
                        input.step = '0.01';
                        input.min = '0';
                        input.style.width = '60%';
                    }
                    input.style.margin = '2px';
                    input.style.padding = '2px';
                    input.value = currentValue;

                    input.setAttribute('oninput', "validity.valid||(value='');");
                    input.classList.add('newly-editable');
                    cell.appendChild(input);
                    // store the previous value temporarily
                    cell.setAttribute('data-previous-value', input.value);
                } else if (cell.dataset.fieldName === 'vendor') {
                    let selectInput = document.createElement('select');
                    currentVendor = cell.textContent;
                    cell.setAttribute('data-previous-value', currentVendor);
                    cell.innerHTML = '';
                    cell.appendChild(selectInput);
                    // Populate the select input with options dynamically
                    fetch(`${ROOT}/api/purchases/getvendors`)
                        .then(response => response.json())
                        .then(data => {
                            // Loop through the response data and create an option element for each vendor
                            for (let j = 0; j < data.data.length; j++) {
                                var vendor = data.data[j];
                                var option = document.createElement('option');
                                option.value = vendor.vendor_id;
                                option.text = vendor.vendor_name;
                                option.selected = vendor.vendor_name == currentVendor;
                                selectInput.appendChild(option);
                            }
                        });
                }
            });
        });
    });

    // Attach click event listener to each trash can icon
    trashIcons.forEach(function (trashIcon) {
        trashIcon.addEventListener("click", function (event) {
            // Get the purchase ID from the parent tr element
            const purchaseId = this.parentNode.parentNode.dataset.purchaseId;

            // Use the fetch API to send a DELETE request to the server
            let fetchRes2 = fetch(`${ROOT}/api/purchases/delete`, {
                method: 'POST',
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    purchase_id: purchaseId
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

    // Attach click event listener to each tick icon to update the database
    const tickIcons = document.querySelectorAll('.tick-icon');
    tickIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            updatePurchase(event);
        });
    });

    // Attach click event listener to each tick and cross icon to make the cell uneditable and pencil & trash icon appear
    const editIcons = document.querySelectorAll('.edit-options');
    editIcons.forEach(icon => {
            icon.addEventListener('click', function (event) {
                // make tick and cross icon invisible
                let row = event.target.parentNode.parentNode;
                row.querySelector('.tick-icon').parentNode.style.display = 'none';
                row.querySelector('.cross-icon').parentNode.style.display = 'none';
                // make pencil icon visible
                row.querySelector('.edit-icon').parentNode.style.display = 'table-cell';
                // make trash icon visible
                row.querySelector('.trash-icon').parentNode.style.display = 'table-cell';

                row.classList.remove('row-in-form');

                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    if (fieldNames.includes(cell.dataset.fieldName)) {
                        cell.classList.remove('editable');

                        const input = cell.querySelector('input');
                        // if the icon is the cross icon, revert the value to the previous value
                        if (icon.classList.contains('cross-icon')) {
                            cell.textContent = cell.getAttribute('data-previous-value');
                            if (cell.dataset.fieldName === 'quantity')
                                cell.textContent += " " + cell.getAttribute('data-unit');
                            cell.removeAttribute('data-previous-value');
                        }
                        // else, update the value to the new value
                        else {
                            // check for null values and set to zero or input value otherwise
                            if (cell.dataset.fieldName === 'cost' || cell.dataset.fieldName === 'final_price' || cell.dataset.fieldName === 'discount' || cell.dataset.fieldName === 'tax') {
                                if (input.value === '')
                                    cell.textContent = '0';
                                else
                                    cell.textContent = input.value;
                            }

                            if (cell.dataset.fieldName === 'quantity' && input.value !== '')
                                cell.textContent = input.value + " " + cell.getAttribute('data-unit');
                            else if (cell.dataset.fieldName === 'quantity' && input.value === '')
                                cell.textContent = '0' + " " + cell.getAttribute('data-unit');

                            if (cell.dataset.fieldName === 'purchase_date' || cell.dataset.fieldName === 'expiry_date' || cell.dataset.fieldName === 'brand')
                                cell.textContent = input.value;
                        }
                    } else if (cell.dataset.fieldName === 'vendor') {
                        cell.classList.remove('editable');
                        const input = cell.querySelector('select');
                        cell.textContent = input.options[input.selectedIndex].text;
                        if (icon.classList.contains('cross-icon')) {
                            cell.textContent = cell.getAttribute('data-previous-value');
                        }
                        cell.removeAttribute('data-previous-value');
                    }
                });
            });
        }
    );

    function updatePurchase(event) {
        const row = event.target.parentNode.parentNode;
        const cells = row.querySelectorAll('td');
        const purchaseId = row.getAttribute('data-purchase-id');
        const purchase = {};
        purchase['purchase_id'] = purchaseId;
        cells.forEach(cell => {
            if (fieldNames.includes(cell.dataset.fieldName)) {
                const input = cell.querySelector('input');
                // check if the value has been changed
                if (input.value !== cell.getAttribute('data-previous-value')) {
                    purchase[cell.dataset.fieldName] = input.value;
                    cell.removeAttribute('data-previous-value');
                }
            } else if (cell.dataset.fieldName === 'vendor') {
                const input = cell.querySelector('select');
                if (input.options[input.selectedIndex].text !== cell.getAttribute('data-previous-value')) {
                    purchase[cell.dataset.fieldName] = input.options[input.selectedIndex].value;
                    cell.removeAttribute('data-previous-value');
                }
            }
        });
        // if there are changes to be made, send a POST request to the server
        if (Object.keys(purchase).length > 1) {
            console.log("Changes to be made: ")
            console.log(purchase);
            const url = `${ROOT}/api/purchases/update`;
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(purchase)
            };
            let fetchRes = fetch(url, options);
            fetchRes.then(res => res.json())
                .catch(err => {
                    console.log(err)
                })
        }
    }

    //item_id:abbreviation
    let itemlist = {};
    fetch(`${ROOT}/api/items`)
        .then(res => res.json())
        .then(data => {
            data.items.forEach(item => {
                itemlist[item.item_id] = item.abbreviation;
            });
        });

    //When the form item is changed, change the unit abbreviation
    document.getElementById('item').addEventListener('change', function (event) {
        unitspan.textContent = itemlist[event.target.value];
    });


});