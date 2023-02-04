document.addEventListener('DOMContentLoaded', function () {
    const ab = document.getElementById('accept-button');
    const rb = document.getElementById('reject-button');
    const os = document.querySelector('.order-status');
    const oid = document.querySelector('.order-id').getAttribute('data-order-id');
    const status = os.getAttribute('data-order-status');

    // make buttons visible
    if (status == 'pending') {
        toggleButtons('visible');
    }

    // when select option value is changed then update status of order
    os.addEventListener('change', function () {
        updateOrderStatus(oid, os.value);
        if (os.value == 'pending') {
            toggleButtons('visible');
        } else {
            toggleButtons('invisible');
        }
    });


    // change status of order
    ab.addEventListener('click', function () {
        // change visible status of order
        os.value = 'accepted';

        // make both buttons invisible
        toggleButtons('invisible');

        os.setAttribute('data-order-status', 'accepted');

        // make ajax call to update status
        updateOrderStatus(oid, 'accepted');
    });

    rb.addEventListener('click', function () {
        // change visible status of order
        os.value = 'rejected';
        // make both buttons invisible
        toggleButtons('invisible');

        os.setAttribute('data-order-status', 'rejected');

        // make ajax call to update status
        updateOrderStatus(oid, 'rejected');


    });
    // function to make buttons visible/invisible
    function toggleButtons(x) {
        if (x == 'visible') {
            ab.style.display = 'block';
            rb.style.display = 'block';
        } else {
            ab.style.display = 'none';
            rb.style.display = 'none';
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

});