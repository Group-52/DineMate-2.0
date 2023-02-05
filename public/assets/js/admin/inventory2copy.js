// Stuff to do when the edit button is clicked
function makeEditable() {
    let i;
    // Hide the edit button
    document.querySelector("#editButton").style.display = "none";
    // Show the update button
    document.querySelector("#updateButton").style.display = "block";

    // Show the trash can icon
    const trashIcons = document.querySelectorAll(".trash-icon");
    for (i = 0; i < trashIcons.length; i++) {
        trashIcons[i].classList.add("visible");
    }

    var checkboxes = document.querySelectorAll("input[name='expiryrisk']");

    // Make the expiry risk checkboxes 1 or 0 when checked or unchecked
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener("change", function () {
            if (this.checked) {
                this.value = "1";
            } else {
                this.value = "0";
            }
        });
        // Make the expiry risk checkboxes editable
        checkboxes[i].disabled = false;
        // Add an event listener to each checkbox to set the data-changed attribute to true
        checkboxes[i].addEventListener("change", function () {
            this.setAttribute("data-changed", true);
        });
    }

    // Make the amount remaining and special notes cells editable
    const cells = document.querySelectorAll("td[data-field-name='amount_remaining'], td[data-field-name='special_notes']");
    for (i = 0; i < cells.length; i++) {
        cells[i].setAttribute("contenteditable", "true");
        cells[i].classList.add("editable");
        cells[i].addEventListener("input", function () {
            this.setAttribute("data-changed", true);
        })
    }
    cells[0].focus();
}

function makeUneditable() {
    let i;
    // Show the edit button
    document.querySelector("#editButton").style.display = "block";
    // Hide the update button
    document.querySelector("#updateButton").style.display = "none";

    // Hide the trash can icon
    const trashIcons = document.querySelectorAll(".trash-icon");
    for (i = 0; i < trashIcons.length; i++) {
        trashIcons[i].classList.remove("visible");
    }

    // Make the expiry risk checkboxes uneditable
    const checkboxes = document.querySelectorAll("input[name='expiryrisk']");
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].disabled = true;
        checkboxes[i].removeEventListener("change", function () {
            this.setAttribute("data-changed", true);
        });
    }

    // Make the amount remaining and special notes cells uneditable
    const cells = document.querySelectorAll("td[data-field-name='amount_remaining'], td[data-field-name='special_notes']");
    for (i = 0; i < cells.length; i++) {
        cells[i].setAttribute("contenteditable", "false");
        cells[i].classList.remove("editable");
    }
}

function updateInventory() {
    let newValue;
    let pid;
    let row;
    let i;
    // Collect data from editable cells
    const cells = document.querySelectorAll(".editable");
    const data = [];

    //Collect checkboxes that were changed
    const checkboxes = document.querySelectorAll("input[name='expiryrisk']");
    for (i = 0; i < checkboxes.length; i++) {
        row = checkboxes[i].parentNode.parentNode;
        pid = row.getAttribute("data-purchase-id");
        newValue = checkboxes[i].value;
        console.log(`pid: ${pid}, newValue: ${newValue}, data-changed: ${checkboxes[i].hasAttribute('data-changed')}`)
        if (checkboxes[i].hasAttribute('data-changed')) {
            data.push({
                pid: pid,
                fieldName: 'expiryrisk',
                newValue: newValue
            });
        }
    }

    // Collect data from other grid cells that were changed
    for (i = 0; i < cells.length; i++) {
        row = cells[i].parentNode;
        pid = row.getAttribute("data-purchase-id");
        const fieldName = cells[i].getAttribute("data-field-name");
        newValue = cells[i].innerHTML;
        if (cells[i].hasAttribute('data-changed')) {
            data.push({
                pid: pid,
                fieldName: fieldName,
                newValue: newValue
            });
        }
    }

    makeUneditable();

    // Send data to server
    let fetchRes = fetch(
        "<?= ROOT ?>/admin/inventory/updateInventory", {
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
        let fetchRes2 = fetch("<?= ROOT ?>/admin/inventory/deleteInventory", {
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
