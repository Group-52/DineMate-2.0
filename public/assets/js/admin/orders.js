document.addEventListener("DOMContentLoaded", () => {

<<<<<<< HEAD
    const cards = document.querySelectorAll('.card');
    const circles = document.querySelectorAll('#circle');
=======
    //Kitchen Display System mode
    const KDSbutton = document.querySelector('#KDS-button');
    if (sessionStorage.getItem('KDSmode') === "true") {
        KDSmode();
    }
    KDSbutton.addEventListener('click', function (e) {
        KDSmode();
    });

    //function to hide/display unnecessary elements
    function KDSmode() {
        let maindiv = document.querySelector('.w-100');
        let nav = document.querySelector('.nav');
        let sidebar = document.querySelector('#sidebar');
        let mode = KDSbutton.innerHTML !== "Exit KDS mode";
        let h1title = document.querySelector('h1');

        if (mode) {
            sessionStorage.setItem('KDSmode', "true");
            nav.style.display = "none";
            sidebar.style.display = "none";
            KDSbutton.innerHTML = "Exit KDS mode";
            //got to full screen
            if (document.fullscreenEnabled) {
                document.documentElement.requestFullscreen();
            }
            maindiv.classList.remove('p-5')
            maindiv.classList.add('p-2')
            h1title.style.display = "none";
        } else {
            sessionStorage.setItem('KDSmode', "false");
            nav.style.display = 'flex';
            sidebar.style.display = 'block';
            KDSbutton.innerHTML = "KDS Mode";
            //exit full screen
            if (document.fullscreenEnabled) {
                document.exitFullscreen();
            }
            maindiv.classList.add('p-5')
            maindiv.classList.remove('p-2')
            h1title.style.display = "block";
        }
    }
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

    // set initial color of circle based on status
    circles.forEach(circle => {
        var s = circle.getAttribute('data-order-status');
        switch (s) {
            case "pending":
                circle.style.backgroundColor = "transparent"
                break;
            case "accepted":
                circle.style.backgroundColor = "yellow"
                break;
        }
    });

    // change color of circle based on status
    circles.forEach(circle => {
        circle.addEventListener('click', function () {
            var status = circle.getAttribute('data-order-status');

            switch (status) {
                case "pending":
                    circle.style.backgroundColor = "yellow";
                    circle.setAttribute('data-order-status', 'accepted');
                    break;
                case "accepted":
                    circle.style.backgroundColor = "transparent";
                    circle.setAttribute('data-order-status', 'pending');
                    break;
            }
            // get order id and status
            let oid = circle.parentElement.parentElement.parentElement.getAttribute('data-order-id');
            status = circle.getAttribute('data-order-status');
            // update order status in database
            if (status !== "completed") {
                updateOrderStatus(oid, status);
            }
        });
    });

    // card selection
    cards.forEach(card => {
        let id = card.getAttribute('data-order-id');
        let cardbody = card.children[1];
        // go to order details page
        cardbody.addEventListener('click', function () {
            location.href = `${ROOT}/admin/orders/id/${id}`;
        });
        //when hovering over card, increase size of card
        cardbody.addEventListener('mouseover', function () {
            card.style.transform = "scale(1.05)";
            cardbody.style.cursor = "pointer";
        });
        cardbody.addEventListener('mouseout', function () {
            card.style.transform = "scale(1)";
        });

    });


    // function to do ajax call to update order status
    function updateOrderStatus(oid, status) {
        let data = {"order_id": oid, "status": status};

        //get card with data-order-id = oid
        let card = document.querySelector(`[data-order-id="${oid}"]`);
        let uid = card.getAttribute('data-user-id');
        let utype = card.getAttribute('data-user-type');
        (new Socket()).send_data("accepted_order", {"order_id": oid, "user_id": uid, "user_type": utype})

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


    function addCard(order) {
        var cardDeck = document.querySelector(".card-deck");

        var card = document.createElement("div");
        card.classList.add("card");
        card.setAttribute("data-order-id", order.order_id);
        card.setAttribute("data-order-type", order.type);
        card.setAttribute("data-order-status", order.status);
        card.setAttribute("data-user-id", order.user_id);
        card.setAttribute("data-user-type", order.user_type);
        if (order.scheduled_time) card.querySelector('.card-header').classList.add('time');

<<<<<<< HEAD
        var cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header");

        var headerContent = document.createElement("div");
        headerContent.classList.add("d-flex", "justify-content-between");

        var orderTime = document.createElement("div");
        orderTime.innerHTML = formatOrderTime(order.scheduled_time, order.time_placed);
        headerContent.appendChild(orderTime);
        // add 5 tabspaces
        headerContent.appendChild(document.createTextNode("\u00a0\u00a0\u00a0\u00a0\u00a0"));

        var orderType = document.createElement("div");
        var typeImg = document.createElement("img");
        typeImg.width = "30";
        typeImg.height = "30";
        typeImg.alt = order.type;
=======
        card.querySelector('.id-strip').innerHTML = "#" + order.order_id + "&nbsp";
        card.querySelector('.time').innerHTML = formatOrderTime(order.scheduled_time, order.time_placed);
        let iconimg = card.querySelector('.type-icon').children[0];
        let url = ""
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
        if (order.type == "dine-in") {
            typeImg.src = `${ASSETS}/icons/table.png`;
        } else if (order.type == "takeaway") {
            typeImg.src = `${ASSETS}/icons/fastcart.png`;
        } else if (order.type == "bulk") {
            typeImg.src = `${ASSETS}/icons/bulk.svg`;
        }
        orderType.appendChild(typeImg);
        headerContent.appendChild(orderType);

        if (order.type == "dine-in") {
            var tableId = document.createElement("div");
            tableId.innerHTML = order.table_id;
            headerContent.appendChild(tableId);
        }
        // add 3 tabspaces
        headerContent.appendChild(document.createTextNode("\u00a0\u00a0\u00a0"));

        var orderStatus = document.createElement("div");
        orderStatus.setAttribute("data-order-status", order.status);
        orderStatus.setAttribute("id", "circle");
        orderStatus.addEventListener("click", function () {
            if (order.status == "pending") {
                orderStatus.setAttribute("data-order-status", "accepted");
                updateOrderStatus(order.order_id, "accepted");
                orderStatus.style.backgroundColor = "yellow";
            } else if (order.status == "accepted") {
                orderStatus.setAttribute("data-order-status", "pending");
                updateOrderStatus(order.order_id, "pending");
                orderStatus.style.backgroundColor = "white";
            }
        });
        headerContent.appendChild(orderStatus);

        cardHeader.appendChild(headerContent);
        card.appendChild(cardHeader);

        var cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        var orderDishes = order.order_dishes;
        orderDishes.forEach(function (dish) {
            var dishRow = document.createElement("div");
            dishRow.style.display = "flex";
            dishRow.style.justifyContent = "space-between";

            var dishName = document.createElement("div");
            dishName.style.flex = "1";
            dishName.innerHTML = dish.dish_name;
            dishRow.appendChild(dishName);

            var dishQuantity = document.createElement("div");
            dishQuantity.style.marginLeft = "auto";
            dishQuantity.innerHTML = dish.quantity;
            dishRow.appendChild(dishQuantity);
            cardBody.appendChild(dishRow);
        });

        card.appendChild(cardBody);
        // cardDeck.insertBefore(card, cardDeck.firstChild);
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
            return scheduledDate.toLocaleString('en-US', {
                timeZone: 'Asia/Colombo',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });
        }
    }

<<<<<<< HEAD
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
=======
    // Uses a websocket to receive data and add a new card
    (new Socket()).receive_data('new_order', function (d) {
        console.log(d);
        addCard(d);
        new Toast("fa-solid fa-check", "#28a745", "Order Received", "", true, 3000);
    });

>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

});