document.addEventListener('DOMContentLoaded', () => {

    //check url to see if utype parameter exists
    const url = new URL(window.location.href);
    const utype = url.searchParams.get("utype");
    const dishtable = document.querySelector('#dishes table tbody');
    const addDishButton = document.querySelector('#add-dish-button');
    const chevron = document.querySelector('#customer-dropdown')
    const customerdata = document.querySelector('#customer-data-formdiv')
    const promoselect = document.querySelector('#promotion-select');

    var gid, regid;
    gid = regid = null;
    if (utype && utype === 'guest') {
        gid = parseInt(document.querySelector('#guest-id').innerHTML);
    } else {
        regid = document.querySelector('#reg-user-id').innerHTML;
        console.log(regid)
        //disable all inputs in customer data
        document.querySelectorAll('#customer-data-formdiv input').forEach(input => {
            input.disabled = true;
        })
    }


    //fetch opening and closing times
    let rtimes = fetch(`${ROOT}/api/GeneralDetails`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(response => {
        return response.json();
    })

    let sctime = document.querySelector('#sctime')
    var op, cp;
    sctime.addEventListener('change', () => {
        //if scheduled time be less than current time + 1 hour show error
        let date = new Date();
        let chour = date.getHours();
        let cmin = date.getMinutes();
        //today date only
        let cdate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), chour + 2, cmin, 0, 0);
        let sdate = new Date(sctime.value);
        if (sdate < cdate) {
            new Toast('fa-solid fa-exclamation-circle', 'red', 'Invalid Time', 'Scheduled time should be at least 2 hours from now', false, 3000);
            sctime.value = "";
        }
        rtimes.then(data => {
            op = data.details.opening_time
            cp = data.details.closing_time

            let temp = sctime.value.split("T")[1];
            let openingTime = new Date("1970-01-01T" + op + "Z");
            let closingTime = new Date("1970-01-01T" + cp + "Z");
            let selectedTime = new Date("1970-01-01T" + temp + "Z");

// Compare the selectedTime with openingTime and closingTime
            if (selectedTime < openingTime || selectedTime > closingTime) {
                new Toast('fa-solid fa-exclamation-circle', 'red', 'Invalid Time', 'Scheduled time should be between opening and closing times', false, 3000);
                sctime.value = "";
            }
        })
    })


    //Hides/displays customer detail form
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

    //Applies promtion when select is changed
    promoselect.addEventListener('change', () => {
        let promotionId = promoselect.value;
        if (utype == 'guest') {
            getReduction(gid, promotionId, "guest");
        } else
            getReduction(regid, promotionId, "registered");
        calculateCost();
    });
    //Deletes a dish from the table
    dishtable.addEventListener('click', (e) => {
        if (e.target.classList.contains('fa-trash-alt')) {
            e.target.parentElement.parentElement.remove();
            calculateCost();

            if (utype == 'guest') {
                //remove from cart
                const dishId = e.target.parentElement.parentElement.children[0].textContent;
                deleteFromCart(dishId, gid, "guest");
                getValidPromotions(gid, "guest")
            } else {
                const dishId = e.target.parentElement.parentElement.children[0].textContent;
                deleteFromCart(dishId, regid, "registered");
                getValidPromotions(regid, "registered")
            }
        }
    })

    //Adds a dish to the table
    addDishButton.addEventListener('click', () => {
        event.preventDefault();
        if (document.getElementById("item1").value !== "") {
            addItem();
            calculateCost();
        }
    });

    //Add/Removes service charge when order type is changed
    document.querySelector('#order-type').addEventListener("change", () => {
        calculateCost();
    })

    //Disables/Enables scheduled time
    document.querySelector('#timecheck').addEventListener('change', () => {
        if (timecheck.checked) {
            document.querySelector('#sctime').disabled = false;
        } else {
            document.querySelector('#sctime').disabled = true;
            //clear the value
            document.querySelector('#sctime').value = '';
        }
    });

    //Creates the order
    const createbtn = document.querySelector('#create-order-button');
    createbtn.addEventListener('click', () => {
        let data = collectData();
        console.log(data);
        //if no dishes are added
        if (data.dishlist.length == 0) {
            new Toast("fa-solid fa-exclamation-circle", "red", "Empty Order", "No Dishes Added", false, 3000);
            return;
        }
        if (data.guest_id) {
            updateGuest(data.guest_id, data.customer.fname, data.customer.lname, data.customer.contactNo, data.customer.email);
        }
        makeOrder(data);
        // getCart(gid, "guest");

    });

    //Updates the view when the form changes
    const customerNameSpan = document.getElementById("customer-name");
    const customerContactSpan = document.getElementById("customer-contact");
    const FnameInput = document.getElementById("fname");
    const LnameInput = document.getElementById("lname");
    const contactInput = document.getElementById("contact_no");
    FnameInput.addEventListener("input", () => {
        customerNameSpan.textContent = FnameInput.value + " " + LnameInput.value;
    });
    LnameInput.addEventListener("input", () => {
        customerNameSpan.textContent = FnameInput.value + " " + LnameInput.value;
    });
    contactInput.addEventListener("input", () => {
        customerContactSpan.textContent = contactInput.value;
    });

    //Takes the dish from the select option and add/update view
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

            if (utype == 'guest') {
                //add to cart
                const dishId = selectedOption.dataset.dishid;
                updateCart(dishId, newQuantity, gid, "guest");
                getValidPromotions(gid, "guest")
            } else {
                const dishId = selectedOption.dataset.dishid;
                updateCart(dishId, newQuantity, regid, "registered");
                getValidPromotions(regid, "registered")
            }

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

            if (utype == 'guest') {
                //add to cart
                const dishId = selectedOption.dataset.dishid;
                const quantity = quantityInput.value;
                addToCart(dishId, quantity, gid, "guest");
                getValidPromotions(gid, "guest")

            } else {
                const dishId = selectedOption.dataset.dishid;
                const quantity = quantityInput.value;
                addToCart(dishId, quantity, regid, "registered");
                getValidPromotions(regid, "registered")
            }
        }

        // Clear the inputs
        dishInput.value = "";
        quantityInput.value = 1;

    }

    //Calculates the cost of the order and updates the view
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

    //Gets all the data from different input fields and views
    function collectData() {
        const dishRows = Array.from(document.querySelectorAll('#dishes tbody tr'));
        const dishlist = dishRows.map(row => ({
            //first td
            dish_id: parseFloat(row.children[0].textContent),
            dish_name: row.children[1].textContent,
            quantity: parseFloat(row.children[2].textContent),
            // cost: parseFloat(row.children[3].textContent),
        }));

        const subtotal = parseInt(document.querySelector('#subtotal-view').textContent);
        const promotion = promoselect.value
        const serviceCharge = parseInt(document.querySelector('#service-charge-view').textContent);
        const netTotal = parseInt(document.querySelector('#net-total-view').textContent);

        const customerFname = document.querySelector('#fname').value;
        const customerLname = document.querySelector('#lname').value;
        const contactNo = document.querySelector('#contact_no').value || null;
        const email = document.querySelector('#email').value || null;
        const type = document.querySelector('#order-type').value;
        const scheduledTimeCheckbox = document.querySelector('#timecheck');
        const scheduled_time = scheduledTimeCheckbox.checked ? document.querySelector('#sctime').value : null;
        const request = document.querySelector('#special-instructions').value;


        return {
            reg_customer_id: regid,
            guest_id: gid,
            dishlist,
            subtotal,
            promotion,
            serviceCharge,
            netTotal,
            customer: {
                fname: customerFname,
                lname: customerLname,
                contactNo,
                email,
            },
            type,
            scheduled_time,
            request,
        };
    }

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
                window.location.href = `${ROOT}/admin/payments`;
            });
    }

    function updateGuest(guest_id, fname = "", lname = "", email = null, contactNo = null) {
        let data = {
            guest_id: guest_id,
            email: email,
            contact: contactNo,
            fname: fname,
            lname: lname,
        }
        //remove null values
        Object.keys(data).forEach(key => data[key] == null ? delete data[key] : '');

        fetch(`${ROOT}/api/guest/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }

    function addToCart($dish, $quantity, $user_id, $utype = "guest") {
        fetch(`${ROOT}/api/cart/cashierAdd`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
                ,
                body: JSON.stringify({
                    dish_id: $dish,
                    qty: $quantity,
                    user_id: $user_id,
                    utype: $utype,
                }),
            }
        ).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }

    function deleteFromCart($dish, $user_id, $utype = "guest") {
        fetch(`${ROOT}/api/cart/cashierDelete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
                ,
                body: JSON.stringify({
                    dish_id: $dish,
                    user_id: $user_id,
                    utype: $utype,
                }),
            }
        ).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }

    //gets cart and console logs it
    function updateCart($dish, $quantity, $user_id, $utype = "guest") {
        fetch(`${ROOT}/api/cart/cashierUpdate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
                ,
                body: JSON.stringify({
                    dish_id: $dish,
                    qty: $quantity,
                    user_id: $user_id,
                    utype: $utype,
                }),
            }
        ).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }

    function getCart($user_id, $utype = "guest") {
        fetch(`${ROOT}/api/cart/cashierGet`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
                ,
                body: JSON.stringify({
                    user_id: $user_id,
                    utype: $utype,
                }),
            }
        ).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            });
    }

    //Gets all valid promotions for order and updates the select field
    function getValidPromotions(user_id, user_type = 'guest') {
        fetch(`${ROOT}/api/promotions/getValidPromotions`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json',},
            body: JSON.stringify({
                uid: user_id,
                utype: user_type
            })
        })
            .then(response => response.json())
            .then(data => {
                // getCart(user_id, user_type);
                console.log('Success:', data);
                let promotions = data.promotions;
                promoselect.innerHTML = "";
                //add default option
                let option = document.createElement('option');
                option.value = "1";
                option.innerHTML = "None";
                promoselect.appendChild(option);
                promotions.forEach((promo) => {
                    let option = document.createElement('option');
                    option.value = promo.promo_id;
                    option.innerHTML = promo.title;
                    promoselect.appendChild(option);
                });
            });
    }

    //gets the reduction and updates the field and recalculates the cost
    function getReduction(user_id, promo_id, user_type = 'guest') {
        fetch(`${ROOT}/api/promotions/getReduction`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json',},
            body: JSON.stringify({
                uid: user_id,
                utype: user_type,
                promo: promo_id
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                document.querySelector('#promotion-view').innerHTML = data.reduction;
                calculateCost();
            });
    }


});


