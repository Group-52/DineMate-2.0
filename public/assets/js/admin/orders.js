document.addEventListener("DOMContentLoaded", () => {

  const rows = document.querySelectorAll('tbody tr');
  const circles = document.querySelectorAll('#circle');

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
      let oid = circle.parentElement.parentElement.getAttribute('data-order-id');
      status = circle.getAttribute('data-order-status');
      // update order status in database
      if (status !== "completed") {
        updateOrderStatus(oid, status);
      }
    });
  });

  // add links to each order id field
  const orderIds = document.querySelectorAll('.order-id-field');
  orderIds.forEach(orderId => {
    let id = orderId.parentElement.getAttribute('data-order-id');
    orderId.addEventListener('click', function () {
      // redirect to order details page
      window.location.href = `${ROOT}/admin/orders/id/${id}`;
    });
  });

  // filter orders by type and status
  let typeFilter = document.getElementById("type");
  let statusFilter = document.getElementById("status");
  typeFilter.addEventListener("change", function () {

    let typeValue = this.value.toLowerCase();

    for (let i = 0; i < rows.length; i++) {
      let orderType = rows[i].getAttribute("data-order-type");
      console.log(`orderType: ${orderType}, typeValue: ${typeValue}`)
      if (typeValue === "all") {
        rows[i].style.display = "";
      } else if (orderType !== typeValue) {
        rows[i].style.display = "none";
      } else {
        rows[i].style.display = "";
      }
    }
  });

  statusFilter.addEventListener("change", function () {
    let statusValue = this.value.toLowerCase();

    for (let i = 0; i < rows.length; i++) {
      let statusCircle = rows[i].getAttribute("data-order-status");
      console.log(`statusValue: ${statusValue}, statusCircle: ${statusCircle}`)
      if (statusValue === "all") {
        rows[i].style.display = "";
      } else if (statusCircle !== statusValue) {
        rows[i].style.display = "none";
      } else {
        rows[i].style.display = "";
      }
    }
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


  // // Listening to server events to add new order
  // const evtSource = new EventSource(`${ROOT}/api/orders/stream`);
  // evtSource.addEventListener("ping", (event) => {
  //   const newElement = document.createElement("tr");
  //   const time = JSON.parse(event.data).time;
  //   newElement.textContent = `ping at ${time}`;
  //   // console.log(newElement);
  //   let data = JSON.parse(event.data).data;
  //   if (data.order_id) {
  //     addRow(data);
  //   }
  //   console.log(data);
  // });

  function addRow(order) {
    var table = document.querySelector(".table");
    var row = table.insertRow(-1);
    row.setAttribute("data-order-id", order.order_id);
    row.setAttribute("data-order-type", order.type);
    row.setAttribute("data-order-status", order.status);

    var orderIdCell = row.insertCell(0);
    orderIdCell.innerHTML = order.order_id;
    orderIdCell.classList.add("order-id-field");
    var customerIdCell = row.insertCell(1);
    customerIdCell.innerHTML = order.reg_customer_id ? order.reg_customer_id : order.guest_id;
    var timePlacedCell = row.insertCell(2);
    timePlacedCell.innerHTML = order.time_placed;
    var scheduledTimeCell = row.insertCell(3);
    scheduledTimeCell.innerHTML = order.scheduled_time ? order.scheduled_time : "-";
    var requestCell = row.insertCell(4);
    requestCell.innerHTML = order.request.length > 30 ? order.request.substring(0, 30) + "..." : order.request;
    var typeCell = row.insertCell(5);
    var typeImg = document.createElement("img");
    typeImg.alt = order.type;
    typeImg.width = "30";
    typeImg.height = "30";
    typeCell.appendChild(typeImg);
    if (order.type == "dine-in") {
      typeImg.src = `${ASSETS}/icons/table.png`;
      if (order.table_id)
        typeCell.appendChild(document.createTextNode(" " + order.table_id));
    } else if (order.type == "takeaway") {
      typeImg.src = `${ASSETS}/icons/fastcart.png`;
    } else if (order.type == "bulk") {
      typeImg.src = `${ASSETS}/icons/bulk.svg`;
    }
    var statusCell = row.insertCell(6);
    var statusDiv = document.createElement("div");
    statusDiv.setAttribute("data-order-status", order.status);
    statusDiv.setAttribute("id", "circle");
    statusDiv.setAttribute("class", "pending");
    statusCell.appendChild(statusDiv);

    // add event listener to new circle
    statusDiv.addEventListener('click', function () {
      var status = statusDiv.getAttribute('data-order-status');

      switch (status) {
        case "pending":
          statusDiv.style.backgroundColor = "yellow";
          statusDiv.setAttribute('data-order-status', 'accepted');
          break;
        case "accepted":
          statusDiv.style.backgroundColor = "transparent";
          statusDiv.setAttribute('data-order-status', 'pending');
          break;
      }
      // get order id and status
      let oid = statusDiv.parentElement.parentElement.getAttribute('data-order-id');
      status = statusDiv.getAttribute('data-order-status');
      // update order status in database
      if (status !== "completed") {
        updateOrderStatus(oid, status);
      }
    });

    // add event listener to new order id field
    orderIdCell.addEventListener('click', function () {
      // redirect to order details page
      window.location.href = `${ROOT}/admin/orders/id/${order.order_id}`;
    }
    );

  }

});