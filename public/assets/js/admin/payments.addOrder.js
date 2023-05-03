document.addEventListener('DOMContentLoaded', () => {

    const chevron = document.querySelector('#customer-dropdown')
    const customerdata = document.querySelector('#customer-data-formdiv')
    chevron.addEventListener('click', function () {
        if (chevron.classList.contains('fa-chevron-down')) {
            chevron.classList.remove('fa-chevron-down')
            chevron.classList.add('fa-chevron-up')
            customerdata.style.height = 'auto';
        } else {
            chevron.classList.remove('fa-chevron-up')
            chevron.classList.add('fa-chevron-down')
            customerdata.style.height = '0px';
        }
    })
    const dishtable = document.querySelector('#dishes table tbody');

    const addDishButton = document.querySelector('#add-dish-button');

    function addItem() {
        // Get the selected dish and quantity inputs
        const dishInput = document.getElementById("item1");
        const quantityInput = document.getElementById("quantity1");
        const selectedOption = dishInput.selectedOptions[0];

        // Get the table body
        const tableBody = document.querySelector("#dishes table tbody");

        // Check if the dish already exists in the table
        const existingRow = Array.from(tableBody.children).find(row => {
            const dishIdCell = row.children[0];
            return dishIdCell.textContent === selectedOption.dataset.dishid;
        });

        if (existingRow) {
            // If the dish already exists, increment the quantity
            const quantityCell = existingRow.children[2];
            const newQuantity = Number(quantityCell.textContent) + Number(quantityInput.value);
            quantityCell.textContent = newQuantity;

            // Recalculate the cost
            const costCell = existingRow.children[3];
            costCell.textContent = selectedOption.dataset.price * newQuantity;
        } else {
            // If the dish doesn't exist, create a new row
            // Get the selected option
            const selectedOption = dishInput.selectedOptions[0];

            // Create a new row element
            const newRow = document.createElement("tr");

            // Create the cells for the new row
            const dishIdCell = document.createElement("td");
            const dishNameCell = document.createElement("td");
            const quantityCell = document.createElement("td");
            const costCell = document.createElement("td");
            const removeCell = document.createElement("td");

            // Populate the cells with values from the inputs
            dishIdCell.textContent = selectedOption.dataset.dishid;
            dishNameCell.textContent = dishInput.value;
            quantityCell.textContent = quantityInput.value;
            costCell.textContent = selectedOption.dataset.price * quantityInput.value;
            removeCell.innerHTML = '<i class="fas fa-trash-alt ml-2 text-danger pointer"></i>';

            // Append the cells to the new row
            newRow.appendChild(dishIdCell);
            newRow.appendChild(dishNameCell);
            newRow.appendChild(quantityCell);
            newRow.appendChild(costCell);
            newRow.appendChild(removeCell);

            // Append the new row to the table body
            tableBody.appendChild(newRow);
        }

        // Clear the inputs
        dishInput.value = "";
        quantityInput.value = 1;

    }

    dishtable.addEventListener('click', (e) => {
        if (e.target.classList.contains('fa-trash-alt')) {
            e.target.parentElement.parentElement.remove();
        }
    })

    addDishButton.addEventListener('click', () => {
        event.preventDefault();
        if (document.getElementById("item1").value !== "") {
            addItem();
            calculateCost();
        }
    });


    function calculateCost() {
        // Calculate subtotal
        let subtotal = 0;
        const rows = document.querySelectorAll("#dishes table tbody tr");
        rows.forEach(row => {
            const costCell = row.querySelector("td:nth-last-child(2)");
            subtotal += parseFloat(costCell.textContent);
        });
        const subtotalView = document.getElementById("subtotal-view");
        subtotalView.textContent = subtotal;

        // Calculate service charge
        const orderType = document.getElementById("order-type").value;
        const svCharge = orderType === "dine-in" ? subtotal * 0.05 : 0;
        const svChargeView = document.getElementById("service-charge-view");
        svChargeView.textContent = svCharge;

        const promotion = parseFloat(document.getElementById("promotion-view").textContent);

        // Calculate net total
        const netTotal = subtotal + svCharge - promotion;
        const netTotalView = document.getElementById("net-total-view");
        netTotalView.textContent = netTotal;
    }


    document.querySelector('#order-type').addEventListener("change", () => {
        calculateCost();
    })


    document.querySelector('#timecheck').addEventListener('change', () => {
        if (timecheck.checked) {
            document.querySelector('#sctime').disabled = false;
        } else {
            document.querySelector('#sctime').disabled = true;
            //clear the value
            document.querySelector('#sctime').value = '';
        }
    });

    function collectData() {
        const dishRows = Array.from(document.querySelectorAll('#dishes tbody tr'));
        const dishlist = dishRows.map(row => ({
            //first td
            dish_id: parseFloat(row.children[0].textContent),
            // name: row.children[1].textContent,
            quantity: parseFloat(row.children[2].textContent),
            // cost: parseFloat(row.children[3].textContent),
        }));

        const subtotal = parseInt(document.querySelector('#subtotal-view').textContent);
        const promotion = parseInt(document.querySelector('#promotion-view').textContent);
        const serviceCharge = parseInt(document.querySelector('#service-charge-view').textContent);
        const netTotal = parseInt(document.querySelector('#net-total-view').textContent);

        const customerName = document.querySelector('#fname').value;
        const contactNo = document.querySelector('#contact_no').value;
        const type = document.querySelector('#order-type').value;
        const scheduledTimeCheckbox = document.querySelector('#timecheck');
        const scheduled_time = scheduledTimeCheckbox.checked ? document.querySelector('#sctime').value : null;


        //check url to see if utype parameter exists
        let url = new URL(window.location.href);
        let utype = url.searchParams.get("utype");
        let gid, regid;
        gid = regid = null;
        if (utype && utype === 'guest') {
            gid = parseInt(document.querySelector('#guest-id').innerHTML);
        } else {
            //Nipun's code
            // regid =

        }

        return {
            reg_customer_id: regid,
            guest_id: gid,
            dishlist,
            subtotal,
            promotion,
            serviceCharge,
            netTotal,
            customer: {
                name: customerName,
                contactNo,
            },
            type,
            scheduled_time,
        };
    }

    const createbtn = document.querySelector('#create-order-button');
    createbtn.addEventListener('click', () => {
        let data = collectData();
        console.log(data);
        if (data.guest_id){
            updateGuest(data.guest_id, data.customer.name, data.customer.contactNo)
        }
        makeOrder(data);

    });

    const customerNameSpan = document.getElementById("customer-name");
    const customerContactSpan = document.getElementById("customer-contact");

    const nameInput = document.getElementById("fname");
    const contactInput = document.getElementById("contact_no");

    nameInput.addEventListener("input", () => {
        customerNameSpan.textContent = nameInput.value;
    });

    contactInput.addEventListener("input", () => {
        customerContactSpan.textContent = contactInput.value;
    });

    //send order data to api and redirect to orders page
    function makeOrder(data) {
        fetch(`${ROOT}/api/orders/create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                // window.location.href = `${ROOT}/orders`;
            });
    }
    function updateGuest(guest_id, name, contactNo) {
        fetch(`${ROOT}/api/guest/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                guest_id: guest_id,
                fname: name,
                contact: contactNo,
            }),
        }).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }


});  