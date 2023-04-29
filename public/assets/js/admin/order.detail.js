document.addEventListener('DOMContentLoaded', function () {
    const ab = document.getElementById('accept-button');
    const rb = document.getElementById('reject-button');
    const cb = document.getElementById('complete-button');
    const os = document.querySelector('.order-status');
    const oid = document.querySelector('.order-id').getAttribute('data-order-id');
    const uid = document.querySelector('.order-id').getAttribute('data-user-id');
    const utype = document.querySelector('.order-id').getAttribute('data-user-type');
    const status = os.getAttribute('data-order-status');
    const blurbox = document.querySelector('.blur-container');
    const editbutton = document.querySelector('#edit-button');
    const finishbutton = document.querySelector('#finish-button');
    const deletebutton = document.querySelector('#delete-button');
    const addbutton = document.querySelector('#add-button');
    const tablebody = document.querySelector('tbody');
    const inputrow = document.querySelector('.input-row');
    const dummyrow = document.querySelector('.dummy-row');

    const redisp = document.querySelector('.request-display');
    const reqfield = document.querySelector('.request-field');
    const retext = redisp.querySelector('span');

    const typefield = document.querySelector('.type-field');
    const typedisp = document.querySelector('.type-display');
    const typeselect = typefield.querySelector('select');

    const timedisp = document.querySelector('.sctime-display');
    if (timedisp) {
        var timefield = document.querySelector('.sctime-field');
        var timetext = timedisp.querySelector('span');
        var crosstime = document.querySelector('.cross-sctime-field');
        var ticktime = document.querySelector('.tick-sctime-field');
        var penciltime = document.querySelector('.edit-sctime-field');
    }

    const promoselect = document.querySelector('.promo-select');

    const crossreq = document.querySelector('.cross-request-field');
    const tickreq = document.querySelector('.tick-request-field');
    const pencilreq = document.querySelector('.edit-request-field');

    // actions for editing request
    pencilreq.addEventListener('click', function () {
        //make request field visible and autofill
        reqfield.style.display = 'block';
        redisp.style.display = 'none';
        //save previous value
        redisp.setAttribute('data-previous-value', retext.innerHTML);
        //autofill text area
        reqfield.children[1].value = retext.innerHTML;
    });
    tickreq.addEventListener('click', function () {
        //make request field invisible and display request
        reqfield.style.display = 'none';
        redisp.style.display = 'block';
        retext.innerHTML = reqfield.children[1].value;

        api_edit({"order_id": oid, "request": reqfield.children[1].value})

    });
    crossreq.addEventListener('click', function () {
        //make request field invisible and display request
        reqfield.style.display = 'none';
        redisp.style.display = 'block';
        // restore previous value
        retext.innerHTML = redisp.getAttribute('data-previous-value');
    });

    //actions for editing scheduled time
    if (timedisp) {
        penciltime.addEventListener('click', function () {
            //make scheduled time field visible and autofill
            timefield.style.display = 'block';
            timedisp.style.display = 'none';
            //save previous value
            timedisp.setAttribute('data-previous-value', timetext.innerHTML);
            let time = timetext.innerHTML;
            console.log(time);
            //autofill time input
            timefield.children[1].value = time;

        });
        ticktime.addEventListener('click', function () {
            //make scheduled time field invisible and display scheduled time
            timefield.style.display = 'none';
            timedisp.style.display = 'block';

            let t = timefield.children[1].value;
            let time = t.slice(11, 16);
            let date = t.slice(0, 10);
            timetext.innerHTML = date + " " + time;

            api_edit({"order_id": oid, "scheduled_time": t})
        });
        crosstime.addEventListener('click', function () {
            //make scheduled time field invisible and display scheduled time
            timefield.style.display = 'none';
            timedisp.style.display = 'block';
            //restore previous value
            timetext.innerHTML = timedisp.getAttribute('data-previous-value');
        });
    }

    deletebutton.addEventListener('click', function (event) {
        event.preventDefault();
        displayPopup3();
    });


    // allow editing of order
    editbutton.addEventListener('click', function () {
        finishbutton.style.display = 'inline-block';
        editbutton.style.display = 'none';

        //table headers
        document.querySelectorAll('.editorderoption').forEach(function (c) {
            c.style.display = 'inline-block';
        });

        //make type field visible and autofill
        typefield.style.display = 'inline-block';
        typedisp.style.display = 'none';

        pencilreq.style.display = 'inline-block';
        if (timedisp)
            penciltime.style.display = 'inline-block';


        //enable promo
        promoselect.disabled = false;

    });
    // finish editing
    finishbutton.addEventListener('click', function () {
        finishbutton.style.display = 'none';
        addbutton.style.display = 'inline-block';
        editbutton.style.display = 'inline-block';
        //table headers
        document.querySelectorAll('.editorderoption').forEach(function (c) {
            c.style.display = 'none';
        });

        pencilreq.style.display = 'none';
        if (timedisp)
            penciltime.style.display = 'none';


        //make type field invisible and display type
        typefield.style.display = 'none';
        typedisp.style.display = 'block';
        let typvalue = typeselect.value;
        //change icon based on type
        if (typvalue == "dine-in")
            typedisp.innerHTML = "Order Type: <img src='" + ASSETS + "/icons/table.png' alt='dine-in' width='30' height='30'> ";
        else if (typvalue == "takeaway")
            typedisp.innerHTML = "Order Type: <img src='" + ASSETS + "/icons/fastcart.png' alt='take-away' width='30' height='30'>";

        //get promo code
        let promo = promoselect.options[promoselect.selectedIndex].value;
        console.log(promo);

        //disable promo type
        promoselect.disabled = true;

        if (reqfield.style.display == 'block') {
            crossreq.click();
        }
        if (timedisp && timefield.style.display == 'block') {
            crosstime.click();
        }


        // update in database
        let data = {"order_id": oid, "type": typvalue, "promo": promo};
        api_edit(data);

    });
    // allow adding a new row
    addbutton.addEventListener('click', function () {
        // simulate click on finish button
        finishbutton.click();
        finishbutton.style.display = 'none';
        editbutton.style.display = 'none';
        addbutton.style.display = 'none';
        //clone input row and add to table at the end
        let clone = inputrow.cloneNode(true);
        clone.style.display = 'table-row';
        tablebody.appendChild(clone);
    });

    // function to add a new row to the table
    function addRow(event) {
        //gather data from input row
        let inputclone = event.target.parentNode.parentNode;
        let dishselect = inputclone.querySelector('select');
        let dishid = dishselect.options[dishselect.selectedIndex].value;
        let dishname = dishselect.options[dishselect.selectedIndex].text;
        let quantity = inputclone.querySelector('input').value;
        let clone = dummyrow.cloneNode(true);
        clone.style.display = 'table-row';
        clone.setAttribute('data-dish-id', dishid);
        clone.classList.remove('dummy-row');
        let tds = clone.querySelectorAll('td');
        tds[0].innerHTML = dishname;
        tds[2].innerHTML = quantity;

        tablebody.appendChild(clone);
        inputclone.remove();
        api_add(oid, dishid, quantity)

    }

    // function to remove a row from the table
    function removeRow(event) {
        let row = event.target.parentNode.parentNode;
        let dishid = row.getAttribute('data-dish-id');
        api_delete(oid, dishid);
        row.remove();
    }

    // function to stop adding
    function stopAdding(event) {
        let row = event.target.parentNode.parentNode;
        row.remove();
    }

    // function to increase quantity
    function increaseQuantity(event) {
        let row = event.target.parentNode.parentNode;
        let quantity = row.querySelectorAll('td')[2];
        quantity.innerHTML = parseInt(quantity.innerHTML) + 1;
        let dishid = row.getAttribute('data-dish-id');
        api_update(oid, dishid, quantity.innerHTML);
    }

    // function to decrease quantity
    function decreaseQuantity(event) {
        let row = event.target.parentNode.parentNode;
        let quantity = row.querySelectorAll('td')[2];
        if (quantity.innerHTML > 1) {
            quantity.innerHTML = parseInt(quantity.innerHTML) - 1;
        }
        let dishid = row.getAttribute('data-dish-id');
        api_update(oid, dishid, quantity.innerHTML);
    }

    // Event delegation on table
    document.querySelector('table').addEventListener('click', function (event) {
        if (event.target.classList.contains('save-dish')) {
            if (checkQuantity(event) && checkDish(event)) {
                addRow(event);
                addbutton.style.display = 'inline-block';
                editbutton.style.display = 'inline-block';
            } else if (checkDish(event)) {
                let row = event.target.parentNode.parentNode;
                displayError("Quantity must be greater than 0", row.getBoundingClientRect().top, row.getBoundingClientRect.left);
            } else if (checkQuantity(event)) {
                let row = event.target.parentNode.parentNode;
                displayError("Dish already added", row.getBoundingClientRect().top, row.getBoundingClientRect.left);
            }
        } else if (event.target.classList.contains('trash-icon')) {
            removeRow(event);
        } else if (event.target.classList.contains('cancel-dish')) {
            stopAdding(event);
            addbutton.style.display = 'inline-block';
            editbutton.style.display = 'inline-block';
        } else if (event.target.classList.contains('increase')) {
            increaseQuantity(event);
        } else if (event.target.classList.contains('decrease')) {
            decreaseQuantity(event);
        }

    });

    //check quantity
    function checkQuantity(event) {
        let quantity = event.target.parentNode.parentNode.querySelector('input').value;
        return !(quantity < 1 || quantity == "");
    }

    //check duplicate dish
    function checkDish(event) {
        let dishid = event.target.parentNode.parentNode.querySelector('select').value;
        let rows = document.querySelectorAll('tbody tr');
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].getAttribute('data-dish-id') == dishid) {
                return false;
            }
        }
        return true;
    }


    // make buttons visible
    if (status == 'pending') {
        toggleButtons('visible');
    } else if (status == 'accepted') {
        cb.style.display = 'inline-block';
    }

    // when select option value is changed then update status of order
    os.addEventListener('change', function () {
        if (os.value != 'completed' && os.value != 'rejected') {
            updateOrderStatus(oid, os.value);
            os.setAttribute('data-order-status', os.value);
        }

        // making accept,reject,complete buttons visible/invisible
        if (os.value == 'pending') {
            toggleButtons('visible');
        } else if (os.value == 'accepted') {
            toggleButtons('invisible');
            cb.style.display = 'inline-block';
        } else if (os.value == 'rejected') {
            toggleButtons('invisible');
        } else if (os.value == 'completed') {
            toggleButtons('invisible');
        }

    });

    // change status of order
    ab.addEventListener('click', function () {
        // change visible status of order
        os.value = 'accepted';

        // make both buttons invisible
        toggleButtons('invisible');
        cb.style.display = 'inline-block';

        os.setAttribute('data-order-status', 'accepted');

        // make ajax call to update status
        updateOrderStatus(oid, 'accepted');
    });

    cb.addEventListener('click', function () {
        // change visible status of order
        os.value = 'completed';

        // make both buttons invisible
        toggleButtons('invisible');

        displayPopup();

    });

    rb.addEventListener('click', function () {
        let x = os.value
        // change visible status of order
        os.value = 'rejected';
        // make both buttons invisible
        toggleButtons('invisible');

        displayPopup2(x);

    });

    // function to make accept/reject buttons visible/invisible
    function toggleButtons(x) {
        if (x == 'visible') {
            ab.style.display = 'inline-block';
            rb.style.display = 'inline-block';
            cb.style.display = 'none';
        } else {
            ab.style.display = 'none';
            rb.style.display = 'none';
            cb.style.display = 'none';
        }
    }

    // function to do ajax call to update order status
    function updateOrderStatus(oid, status) {
        let data = {"order_id": oid, "status": status};
        fetch(`${ROOT}/api/orders/changestatus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
                return response.json();
            }
        ).then(data => {
                console.log(data);
            }
        ).catch(err => {
                console.log(err);
            }
        );
    }

    function displayPopup() {

        let id = document.querySelector('.order-id').getAttribute('data-order-id');
        let status = document.querySelector('.order-status').getAttribute('data-order-status');

        const popup = document.querySelector('.popup')
        popup.style.display = 'flex';
        popup.setAttribute('data-order-id', id);
        popup.setAttribute('data-order-status', status);
        blurbox.style.filter = 'blur(5px)';
    }

    //Buttons inside the popup for order completion
    let confirmButton1 = document.querySelector('#complete-popup #confirm-complete');
    confirmButton1.addEventListener('click', function () {
        const popup = document.querySelector('.popup');
        popup.style.display = 'none';

        // change order status to completed
        updateOrderStatus(oid, 'completed');

        //send notification to user and cashier via websocket
        var socket = new WebSocket("ws://localhost:8080");
        socket.onopen = function () {
            var n = {
                "event_type": "completed_order",
                "order_id": oid,
                "user_id": uid,
                "user_type": utype
            };
            console.log(n);
            socket.send(JSON.stringify(n));
        };

        // redirect to orders page after 1 second
        setTimeout(function () {
            window.location.href = `${ROOT}/admin/orders`;
        }, 1000);
    });
    let cancelButton1 = document.querySelector('#complete-popup #cancel-complete');
    cancelButton1.addEventListener('click', function () {
        const popup = document.querySelector('.popup');
        popup.style.display = 'none';
        // reset order status
        let v = os.getAttribute('data-order-status');
        os.value = v;
        if (v == 'accepted') {
            cb.style.display = 'inline-block';
        } else if (v == 'pending') {
            toggleButtons('visible');
        }
        // unblur the background
        blurbox.style.filter = 'none';
    });


    function displayPopup2() {

        let id = document.querySelector('.order-id').getAttribute('data-order-id');
        let status = document.querySelector('.order-status').getAttribute('data-order-status');

        const popup = document.querySelector('#reject-popup')
        popup.style.display = 'flex';
        popup.setAttribute('data-order-id', id);
        popup.setAttribute('data-order-status', status);

        // blur the entire background
        blurbox.style.filter = 'blur(5px)';

    }

    //Buttons inside the popup for order rejection
    let confirmButton2 = document.querySelector('#reject-popup #confirm-reject');
    confirmButton2.addEventListener('click', function () {
        const popup = document.querySelector('#reject-popup');
        popup.style.display = 'none';

        // change order status to rejected
        updateOrderStatus(oid, 'rejected');
        // redirect to orders page
        window.location.href = `${ROOT}/admin/orders`;
    });
    let cancelButton2 = document.querySelector('#reject-popup #cancel-reject');
    cancelButton2.addEventListener('click', function () {
        const popup = document.querySelector('#reject-popup');
        popup.style.display = 'none';
        // reset order status
        let v = os.getAttribute('data-order-status');
        os.value = v;
        rb.style.display = 'inline-block';
        if (v == 'accepted') {
            cb.style.display = 'block';
        } else if (v == 'pending') {
            toggleButtons('visible');
        }

        // unblur the background
        blurbox.style.filter = 'blur(0px)';

    });

    function displayPopup3() {
        const popup = document.querySelector('#delete-popup')
        popup.style.display = 'flex';
        // blur the entire background
        blurbox.style.filter = 'blur(5px)';
    }

    //Buttons inside the popup for order deletion
    let confirmButton3 = document.querySelector('#delete-popup #confirm-delete');
    confirmButton3.addEventListener('click', function () {
        const popup = document.querySelector('#delete-popup');
        popup.style.display = 'none';
        // redirect to orders page
        window.location.href = `${ROOT}/admin/orders`;
    });
    let cancelButton3 = document.querySelector('#delete-popup #cancel-delete');
    cancelButton3.addEventListener('click', function () {
        const popup = document.querySelector('#delete-popup');
        popup.style.display = 'none';
        // unblur the background
        blurbox.style.filter = 'blur(0px)';
    });

    // call display popup function when order status is changed to completed
    os.addEventListener('change', function () {
            if (os.value == 'completed') {
                displayPopup();
            }
        }
    );

    // call display popup2 function when order status is changed to rejected
    os.addEventListener('change', function () {
            if (os.value == 'rejected') {
                displayPopup2();
            }
        }
    );


//     API CALLS
    function api_delete($order_id, $dish_id) {
        fetch(`${ROOT}/api/orderdishes/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"order_id": $order_id, "dish_id": $dish_id})
        }).then(response => {
                return response.json();
            }
        ).then(data => {
                console.log(data);
            }
        ).catch(err => {
                console.log(err);
            }
        );
    }

    function api_update($order_id, $dish_id, $quantity) {
        fetch(`${ROOT}/api/orderdishes/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"order_id": $order_id, "dish_id": $dish_id, "quantity": $quantity})
        }).then(response => {
                return response.json();
            }
        ).then(data => {
                console.log(data);
            }
        ).catch(err => {
                console.log(err);
            }
        );
    }

    function api_add($order_id, $dish_id, $quantity) {
        fetch(`${ROOT}/api/orderdishes/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"order_id": $order_id, "dish_id": $dish_id, "quantity": $quantity})
        }).then(response => {
            return response.json();

        }).then(data => {
                console.log(data);
            }
        ).catch(err => {
                console.log(err);
            }
        );
    }

    function api_edit(data) {
        fetch(`${ROOT}/api/orders/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
            return response.json();
        }).then(data => {
                console.log(data);
            }
        ).catch(err => {
                console.log(err);
            }
        );
    }
})
