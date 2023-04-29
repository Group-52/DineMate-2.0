document.addEventListener('DOMContentLoaded', function () {

    const toBePaidDiv = document.querySelector('#tobepaid-table');
    const toBeCollectedDiv = document.querySelector('#tobecollected-table');
    const toBePaidHeader = document.querySelector('#unpaid-header');
    const toBeCollectedHeader = document.querySelector('#tocollect-header');
    const notification = document.querySelector('#notification');
    const xnotify = document.querySelector('#notification i');

    xnotify.onclick = function () {
       notification.style.display = 'none';
    }

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

    // Uses a websocket to receive data
    var socket = new WebSocket("ws://localhost:8080");
    socket.onmessage = function (event) {
        let d = JSON.parse(event.data);
        if (d.event_type === "completed_order") {
            console.log(`Order ${d.order_id} has been completed for ${d.user_type}User: ${d.user_id}`);
            // alert(`Order ${d.order_id} has been completed`);
            // window.location.reload();

            notification.style.display = "block";
            notification.querySelector('.message').textContent = `Order ${d.order_id} has been completed`;
            // Hide the notification after 5 seconds
            setTimeout(function () {
                notification.style.display = "none";
            } , 5000);

            // Get the row of the order
            const row = document.querySelector(`tr[data-order-id="${d.order_id}"]`);
            //make row border glow light green and fade back to white slowly
            row.style.border = "4px solid #00ff00";
            row.style.transition = "border 2s ease-in-out";
            setTimeout(function () {
                row.style.border = "2px solid white";
            } , 2000);
            // Get the estimated time cell (6th td)
            const estimatedTimeCell = row.querySelector("td:nth-child(6)");
            // Update the estimated time cell
            estimatedTimeCell.textContent = "Completed";

        }
    };

});