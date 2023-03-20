document.addEventListener('DOMContentLoaded', function () {
    const ab = document.getElementById('accept-button');
    const rb = document.getElementById('reject-button');
    const cb = document.getElementById('complete-button');
    const os = document.querySelector('.order-status');
    const oid = document.querySelector('.order-id').getAttribute('data-order-id');
    const status = os.getAttribute('data-order-status');
    const blurbox = document.querySelector('.blur-container');
    const editbutton = document.querySelector('#edit-button');
    const finishbutton = document.querySelector('#finish-button');
    const addbutton = document.querySelector('#add-button');
    const tablebody = document.querySelector('tbody');
    const inputrow = document.querySelector('.input-row');
    const dummyrow = document.querySelector('.dummy-row');

    // allow editing of order
    editbutton.addEventListener('click', function () {
        finishbutton.style.display = 'inline-block';
        document.querySelectorAll('.editorderoption').forEach(function (c) {
            c.style.display = 'inline-block';
        });
    });
    // finish editing
    finishbutton.addEventListener('click', function () {
        finishbutton.style.display = 'none';
        addbutton.style.display = 'inline-block';
        document.querySelectorAll('.editorderoption').forEach(function (c) {
            c.style.display = 'none';
        });
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

        let data = {"order_id": oid, "dish_id": dishid, "quantity": quantity};

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
            addRow(event);
            addbutton.style.display = 'inline-block';
            editbutton.style.display = 'inline-block';
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


    // make buttons visible
    if (status == 'pending') {
        toggleButtons('visible');
    } else if (status == 'accepted') {
        cb.style.display = 'block';
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
            cb.style.display = 'block';
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
        cb.style.display = 'block';

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

        // os.setAttribute('data-order-status', 'accepted');

        // make ajax call to update status
        // updateOrderStatus(oid, 'accepted');
    });

    rb.addEventListener('click', function () {
        let x = os.value
        // change visible status of order
        os.value = 'rejected';
        // make both buttons invisible
        toggleButtons('invisible');

        displayPopup2(x);

        // os.setAttribute('data-order-status', 'rejected');

        // make ajax call to update status
        // updateOrderStatus(oid, 'rejected');

    });

    // function to make accept/reject buttons visible/invisible
    function toggleButtons(x) {
        if (x == 'visible') {
            ab.style.display = 'block';
            rb.style.display = 'block';
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
        fetch(`${ROOT}/api/orders/update`, {
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
    let confirmButton1 = document.querySelector('#complete-popup #confirm');
    confirmButton1.addEventListener('click', function () {
        const popup = document.querySelector('.popup');
        popup.style.display = 'none';

        // change order status to completed
        updateOrderStatus(oid, 'completed');

        // redirect to orders page
        window.location.href = `${ROOT}/admin/orders`;
    });
    let cancelButton1 = document.querySelector('#complete-popup #cancel');
    cancelButton1.addEventListener('click', function () {
        const popup = document.querySelector('.popup');
        popup.style.display = 'none';
        // reset order status
        let v = os.getAttribute('data-order-status');
        os.value = v;
        if (v == 'accepted') {
            cb.style.display = 'block';
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
    let confirmButton2 = document.querySelector('#reject-popup #confirm');
    confirmButton2.addEventListener('click', function () {
        const popup = document.querySelector('#reject-popup');
        popup.style.display = 'none';

        // change order status to rejected
        updateOrderStatus(oid, 'rejected');
        // redirect to orders page
        window.location.href = `${ROOT}/admin/orders`;
    });
    let cancelButton2 = document.querySelector('#reject-popup #cancel');
    cancelButton2.addEventListener('click', function () {
        const popup = document.querySelector('#reject-popup');
        popup.style.display = 'none';
        // reset order status
        let v = os.getAttribute('data-order-status');
        os.value = v;
        rb.style.display = 'block';
        if (v == 'accepted') {
            cb.style.display = 'block';
        } else if (v == 'pending') {
            toggleButtons('visible');
        }

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
})