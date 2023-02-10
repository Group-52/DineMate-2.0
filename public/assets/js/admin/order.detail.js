document.addEventListener('DOMContentLoaded', function () {
    const ab = document.getElementById('accept-button');
    const rb = document.getElementById('reject-button');
    const cb = document.getElementById('complete-button');
    const os = document.querySelector('.order-status');
    const oid = document.querySelector('.order-id').getAttribute('data-order-id');
    const status = os.getAttribute('data-order-status');

    // make buttons visible
    if (status == 'pending') {
        toggleButtons('visible');
    }
    else if (status == 'accepted') {
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
        }
        else if (os.value == 'accepted') {
            toggleButtons('invisible');
            cb.style.display = 'block';
        }
        else if (os.value == 'rejected') {
            toggleButtons('invisible');
        }
        else if (os.value == 'completed') {
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
        let data = { "order_id": oid, "status": status };
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
        }
        else if (v == 'pending') {
            toggleButtons('visible');
        }
    });



    function displayPopup2() {

        let id = document.querySelector('.order-id').getAttribute('data-order-id');
        let status = document.querySelector('.order-status').getAttribute('data-order-status');

        const popup = document.querySelector('#reject-popup')
        popup.style.display = 'flex';
        popup.setAttribute('data-order-id', id);
        popup.setAttribute('data-order-status', status);
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
        }
        else if (v == 'pending') {
            toggleButtons('visible');
        }
        
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


});