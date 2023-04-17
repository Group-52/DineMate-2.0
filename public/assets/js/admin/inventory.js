document.addEventListener("DOMContentLoaded", function () {

    var editbutton = document.querySelector("#edit-button");
    editbutton.addEventListener("click", makeEditable);
    var finishbutton = document.querySelector("#finish-button");
    finishbutton.addEventListener('click', () => {
        //     look for any rows with the cross icon visible and simulate a click on the cross icon
        let crossIcons = document.querySelectorAll(".cross-icon");
        crossIcons = Array.from(crossIcons);
        crossIcons.forEach(icon => {
            if (icon.parentNode.style.display !== 'none') {
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

    //Validate input
    function validate(row) {
        let values = row.querySelectorAll('input');
        //convert to number
        let maxlevel = parseFloat(values[0].value);
        let bufferlevel = parseFloat(values[1].value);
        let reorderlevel = parseFloat(values[2].value);
        let leadtime = parseFloat(values[3].value);

        let y = row.getBoundingClientRect().top;
        if (maxlevel == "" || bufferlevel == "" || reorderlevel == "" || leadtime == "" || isNaN(maxlevel) || isNaN(bufferlevel) || isNaN(reorderlevel) || isNaN(leadtime)) {
            displayError("All fields are required", y)
            return false;
        }
        if (maxlevel < bufferlevel) {
            displayError("Max stock level cannot be less than buffer stock level", y)
            return false;
        } else if (maxlevel < reorderlevel) {
            displayError("Max stock level cannot be less than re-order level", y)
            return false;
        } else if (reorderlevel < bufferlevel) {
            displayError("Re-order level cannot be less than buffer stock level", y)
            return false;
        } else if (leadtime < 0) {
            displayError("Lead time cannot be less than zero", y)
            return false;
        }
        return true;
    }
});


// <!DOCTYPE html>
// <html lang="en">
//
// <head>
// <?php include VIEWS . "/partials/admin/head.partial.php" ?>
// <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
//     <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
//     <script src="<?= ASSETS ?>/js/admin/inventory.js"></script>
// </head>
//
// <body class="dashboard">
// <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
// <div class="dashboard-container">
//     <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
//     <div class="w-100 h-100 p-5">
//         <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
//             <h1 class="display-3">Inventory</h1>
//             <div class="dashboard-buttons">
//                 <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
//                 <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
//                 <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/inventory/info" id="switch-button">View Batches</a>
//             </div>
//         </div>
//
//         <table class="table">
//             <thead>
//             <tr>
//                 <th>Name</th>
//                 <th>Amount Remaining</th>
//                 <th>Last Updated</th>
//                 <th> Max Stock Level</th>
//                 <th> Buffer Stock Level</th>
//                 <th>Reorder Level</th>
//                 <th> Lead Time</th>
//                 <th>Status</th>
//
//             </tr>
//             </thead>
//             <tbody>
//             <?php if (isset($inventory)) : ?>
//             <?php foreach ($inventory as $item) : ?>
//             <tr data-item-id="<?= $item->item_id ?>">
//                 <td><?= $item->item_name ?></td>
//                 <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
//                 <td><?= $item->last_updated ?></td>
//                 <td data-field-name="max_stock_level"><?= $item->max_stock_level ?></td>
//                 <td data-field-name="buffer_stock_level"><?= $item->buffer_stock_level ?></td>
//                 <td data-field-name="reorder_level"><?= $item->reorder_level ?></td>
//                 <td data-field-name="lead_time"><?= $item->lead_time ?></td>
//                 <td>
//                     <div id="circle" class="pending"></div>
//                 </td>
//                 <td><i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i></td>
//                 <td><i class="fa fa-trash trash-icon" aria-hidden="true"></i></td>
//                 <td><i class="fa fa-check-circle tick-icon edit-options" aria-hidden="true"></i></td>
//                 <td><i class="fa fa-times-circle cross-icon edit-options" aria-hidden="true"></i></td>
//             </tr>
//             <?php endforeach; ?>
//             <?php endif; ?>
//             </tbody>
//         </table>
//         <?php include VIEWS . "/partials/admin/paginationbar.partial.php" ?>
//         <div class="popup" id="delete-popup">
//             <p>
//                 Are you sure you want to delete this item from the inventory? New inventory entries will be created only upon purchase of new items
//             </p>
//             <div class="popup-button-div">
//                 <button class="btn btn-success" id="confirm">Yes</button>
//                 <button class="btn btn-danger" id="cancel">No</button>
//             </div>
//         </div>
//     </div>
// </div>
// </body>
//
// </html>