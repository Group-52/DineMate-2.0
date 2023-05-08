document.addEventListener("DOMContentLoaded", () => {

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
        let dashboardbuttons = document.querySelectorAll('.dashboard-buttons a');

        if (mode) {
            sessionStorage.setItem('KDSmode', "true");
            nav.style.display = "none";
            sidebar.style.display = "none";
            KDSbutton.innerHTML = "Exit KDS mode";
            dashboardbuttons.forEach(button => {
                button.classList.add('hide-buttons')
            });
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
            dashboardbuttons.forEach(button => {
                button.classList.remove('hide-buttons')
            });
            //exit full screen
            if (document.fullscreenEnabled) {
                document.exitFullscreen();
            }
            maindiv.classList.add('p-5')
            maindiv.classList.remove('p-2')
            h1title.style.display = "block";
        }
    }

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
            cardbody.parentElement.style.transform = "scale(1.05)";
        });
        cardbody.addEventListener('mouseout', function (e) {
            cardbody.parentElement.style.transform = "scale(1)";
        });
    });

    // function to be called on card-body click or any child of card-body
    function onCardBodyClick(e) {
        let id = e.target.closest('.card').getAttribute('data-order-id');
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

    // Use event delegation to add event listeners
    document.querySelector('.card-deck').addEventListener('click', function (e) {
        if (e.target && e.target.id == 'circle') {
            onCircleClick(e);
        }
        // else if target is card-body or a child of it
        else if (e.target.matches('.card-body') || e.target.closest('.card-body')) {
            onCardBodyClick(e);
        }
    });

    // function to do ajax call to update order status
    function updateOrderStatus(oid, status) {
        let data = {"order_id": oid, "status": status};

        //get card with data-order-id = oid
        let card = document.querySelector(`[data-order-id="${oid}"]`);
        let uid = card.getAttribute('data-user-id');
        let utype = card.getAttribute('data-user-type');
        if (status === "accepted") {
            (new Socket()).send_data("accepted_order", {"order_id": oid, "user_id": uid, "user_type": utype})
        }

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

    // function to fill a new card with data and append to card deck
    function addCard(order) {

        // clone dummy card
        let card = document.querySelector('.dummy-card').cloneNode(true);
        card.classList.remove('dummy-card');
        card.setAttribute("data-order-id", order.order_id);
        card.setAttribute("data-order-type", order.type);
        card.setAttribute("data-order-status", order.status);
        card.setAttribute("data-user-id", order.user_id);
        card.setAttribute("data-user-type", order.user_type);
        if (order.scheduled_time) card.querySelector('.card-header').classList.add('timer');

        card.querySelector('.id-strip').innerHTML = "#" + order.order_id + "&nbsp;";
        card.querySelector('.time').innerHTML = formatOrderTime(order.scheduled_time, order.time_placed);
        let iconimg = card.querySelector('.type-icon').children[0];
        let url = ""
        if (order.type === "dine-in") {
            url = `${ASSETS}/icons/table.png`;
        } else if (order.type === "takeaway") {
            url = `${ASSETS}/icons/fastcart.png`;
        } else if (order.type === "bulk") {
            url = `${ASSETS}/icons/bulk.svg`;
        }
        iconimg.src = url;
        iconimg.alt = order.type;

        if (order.type === "dine-in") {
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
            return scheduledDate.toLocaleString('en-US', {
                timeZone: 'Asia/Colombo',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });
        }
    }

    // Uses a websocket to receive data and add a new card
    (new Socket()).receive_data('new_order', function (d) {
        console.log(d);
        addCard(d);
        new Toast("fa-solid fa-check", "#28a745", "Order Received", "", true, 3000);
    });


});