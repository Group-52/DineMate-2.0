document.addEventListener('DOMContentLoaded', function () {
    const ab = document.getElementById('accept-button');
    const rb = document.getElementById('reject-button');
    const os = document.querySelector('.order-status');
    const oid = document.querySelector('.order-id').getAttribute('data-order-id');
    const status = os.getAttribute('data-order-status');

    // make buttons visible
    if (status == 'pending') {
        ab.style.display = 'block';
        rb.style.display = 'block';
    }


    // change status of order
    ab.addEventListener('click', function () {
        // change visible status of order
        os.innerHTML = 'Accepted';
        // make both buttons invisible
        ab.style.display = 'none';
        rb.style.display = 'none';

        os.setAttribute('data-order-status', 'accepted');

        // make ajax call to update status
        updateOrderStatus(oid, 'accepted');
    });

    rb.addEventListener('click', function () {
        // change visible status of order
        os.innerHTML = 'Rejected';
        // make both buttons invisible
        ab.style.display = 'none';
        rb.style.display = 'none';

        os.setAttribute('data-order-status', 'rejected');

        // make ajax call to update status
        updateOrderStatus(oid, 'rejected');


    });

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