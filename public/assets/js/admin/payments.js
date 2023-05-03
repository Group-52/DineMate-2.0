document.addEventListener('DOMContentLoaded', function () {

    const toBePaidDiv = document.querySelector('#tobepaid-table');
    const toBeCollectedDiv = document.querySelector('#tobecollected-table');
    const toBePaidHeader = document.querySelector('#unpaid-header');
    const toBeCollectedHeader = document.querySelector('#tocollect-header');
    const addOrderbtn = document.querySelector('#add-order-button');

    const rcustomer = document.querySelector('#return-customer')
    const ncustomer = document.querySelector('#new-customer')
    const popup = document.querySelector('#customer-type-popup')
    const close = document.querySelector('#close-icon')
    const container = document.querySelector('#blur-container')

    addOrderbtn.addEventListener('click', function () {
        event.preventDefault();
        popup.style.display = 'block'
        container.style.filter = 'blur(5px)'
    })
    close.addEventListener('click', function () {
        popup.style.display = 'none'
        container.style.filter = 'blur(0px)'
    })


    toBePaidHeader.onclick = function () {
        toBePaidDiv.style.display = 'block';
        toBeCollectedDiv.style.display = 'none';
        toBePaidHeader.style.backgroundColor = 'white';
        toBePaidHeader.style.color = 'black';
        toBeCollectedHeader.style.backgroundColor = '#ff0000';
        toBeCollectedHeader.style.color = 'white';
    }
    toBeCollectedHeader.onclick = function () {
        toBePaidDiv.style.display = 'none';
        toBeCollectedDiv.style.display = 'block';
        toBePaidHeader.style.backgroundColor = '#ff0000';
        toBePaidHeader.style.color = 'white';
        toBeCollectedHeader.style.backgroundColor = 'white';
        toBeCollectedHeader.style.color = 'black';
    }
    toBePaidHeader.onclick();

    // select the select element and add an event listener to it
    const select = document.querySelector("select[name='status']");
    select.addEventListener("change", function () {
        const value = select.value;
        const rows = document.querySelectorAll("table tbody tr");

        rows.forEach(row => {
            const status = row.dataset.orderStatus;
            if (value === "all" || value === status) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });

    (new Socket()).receive_data('completed_order', function (d) {
        let message = `Order ${d.order_id} has been completed for ${d.user_type}User: ${d.user_id}`;
        let title = "Order Completed";
        new Toast("fa-solid fa-check", "#28a745", title, message, true, 3000);

        // Get the row of the order
        const row = document.querySelector(`tr[data-order-id="${d.order_id}"]`);
        //make row border glow light green and fade back to white slowly
        row.style.border = "4px solid #00ff00";
        row.style.transition = "border 2s ease-in-out";
        setTimeout(function () {
            row.style.border = "2px solid white";
        }, 2000);
        // Get the estimated time cell (6th td)
        const estimatedTimeCell = row.querySelector("td:nth-child(6)");
        // Update the estimated time cell
        estimatedTimeCell.textContent = "Completed";
    });


});