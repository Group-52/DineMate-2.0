document.addEventListener("DOMContentLoaded", () => {

    // set initial color of circle based on status
    document.querySelectorAll('#circle').forEach(circle => {
        let s = circle.getAttribute('data-order-status');
        switch (s) {
            case "pending":
                circle.style.backgroundColor = "transparent"
                break;
            case "accepted":
                circle.style.backgroundColor = "yellow"
                break;
        }
    });

    // hover effect
    document.querySelectorAll('.card-body').forEach(cardbody => {
        cardbody.addEventListener('mouseover', function (e) {
            console.log("mouse over")
            cardbody.parentElement.style.transform = "scale(1.05)";
        });
        cardbody.addEventListener('mouseout', function (e) {
            cardbody.parentElement.style.transform = "scale(1)";
        });
    });

    // function to be called on card-body click
    function onCardBodyClick(e) {
        let id = e.target.parentElement.getAttribute('data-order-id');
        location.href = `${ROOT}/admin/orders/id/${id}`;
    }

    // function to be called on circle click
    function onCircleClick(e) {
        // change color of circle based on status
        let status = e.target.getAttribute('data-order-status');
        let statusdata = {
            "pending": {
                "color": "yellow",
                "status": "accepted",
            },
            "accepted": {
                "color": "transparent",
                "status": "pending",
            }
        }
        e.target.style.backgroundColor = statusdata[status].color;
        e.target.setAttribute('data-order-status', statusdata[status].status);

        // get order id and status
        let oid = e.target.parentElement.parentElement.parentElement.getAttribute('data-order-id');
        status = statusdata[status].status;
        // update order status in database
        updateOrderStatus(oid, status);
    }

    // Use event delegation to add event listener to all circles
    document.querySelector('.card-deck').addEventListener('click', function (e) {
        if (e.target && e.target.id == 'circle') {
            onCircleClick(e);
        } else if (e.target && e.target.classList.contains('card-body')) {
            onCardBodyClick(e);
        }
    });

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

    // function to fill a new card with data and append to card deck
    function addCard(order) {

        // clone dummy card
        let card = document.querySelector('.dummy-card').cloneNode(true);
        card.classList.remove('dummy-card');
        card.setAttribute("data-order-id", order.order_id);
        card.setAttribute("data-order-type", order.type);
        card.setAttribute("data-order-status", order.status);

        card.querySelector('.time').innerHTML = formatOrderTime(order.scheduled_time, order.time_placed);
        let iconimg = card.querySelector('.type-icon').children[0];
        let url = ""
        if (order.type == "dine-in") {
            url = `${ASSETS}/icons/table.png`;
        } else if (order.type == "takeaway") {
            url = `${ASSETS}/icons/fastcart.png`;
        } else if (order.type == "bulk") {
            url = `${ASSETS}/icons/bulk.svg`;
        }
        iconimg.src = url;
        iconimg.alt = order.type;

        if (order.type == "dine-in") {
            iconimg.nextSibling.innerHTML = order.table_id;
        }
        card.querySelector('#circle').setAttribute('data-order-status', order.status);

        // Add dishes to card
        let orderDishes = order.order_dishes;
        let cardbody = card.querySelector('.card-body');

        // hover effect
        cardbody.addEventListener('mouseover', function (e) {
            cardbody.parentElement.transform = "scale(1.05)";
        });
        cardbody.addEventListener('mouseout', function (e) {
            cardbody.parentElement.transform = "scale(1)";
        });

        let dishcomponent = card.querySelector('.dish-component').cloneNode(true);
        cardbody.innerHTML = "";

        orderDishes.forEach(function (dish) {
            let dc = dishcomponent.cloneNode(true);
            cardbody.appendChild(dc);
            dc.children[0].innerHTML = dish.dish_name;
            dc.children[1].innerHTML = dish.quantity;

        });
        // cardDeck.insertBefore(card, cardDeck.firstChild);
        let cardDeck = document.querySelector(".card-deck");
        cardDeck.appendChild(card);
    }

    function formatOrderTime(scheduled_time, time_placed) {
        const today = new Date().toLocaleString('en-US', {timeZone: 'Asia/Colombo', day: 'numeric'});

        if (!scheduled_time) {
            const time = new Date(time_placed);
            return time.toLocaleString('en-US', {
                timeZone: 'Asia/Colombo',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });
        } else {
            const scheduledDate = new Date(scheduled_time);
            const scheduledDay = scheduledDate.toLocaleString('en-US', {timeZone: 'Asia/Colombo', day: 'numeric'});

            if (scheduledDay === today) {
                return scheduledDate.toLocaleString('en-US', {
                    timeZone: 'Asia/Colombo',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true
                });
            } else if (scheduledDay === today + 1) {
                return 'tomorrow';
            } else {
                return scheduledDate.toLocaleString('en-US', {
                    timeZone: 'Asia/Colombo',
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
            }
        }
    }

// Get the notification and close icon elements
    const notification = document.querySelector('.notification');
    const closeIcon = document.querySelector('.close-icon');
// Add an event listener to the close icon to hide the notification instantly
    closeIcon.addEventListener('click', () => {
        notification.classList.add('hide');
    });

// Uses a websocket to receive data and add it to the table
    var socket = new WebSocket("ws://localhost:8080");
    socket.onmessage = function (event) {
        let d = JSON.parse(event.data);
        if (d.event_type === "new_order") {
            console.log(d);
            addCard(d);
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
    };

});