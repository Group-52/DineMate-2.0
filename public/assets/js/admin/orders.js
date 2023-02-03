document.addEventListener("DOMContentLoaded", () => {



  const circles = document.querySelectorAll('#circle');

  // set initial color of circle based on status
  circles.forEach(circle => {
    var s = circle.getAttribute('data-status');
    switch (s) {
      case "pending":
        circle.style.backgroundColor = "transparent";
        circle.style.borderColor = "black";
        break;
      case "accepted":
        circle.style.backgroundColor = "yellow";
        circle.style.borderColor = "black";
        break;
      case "completed":
        circle.style.backgroundColor = "lightgreen";
        circle.style.borderColor = "black";
        break;
      case "rejected":
        circle.style.backgroundColor = "red";
        circle.style.borderColor = "black";
        break;
    }
  });

  // change color of circle based on status
  circles.forEach(circle => {
    circle.addEventListener('click', function () {
      var status = circle.getAttribute('data-status');

      switch (status) {
        case "pending":
          circle.style.backgroundColor = "yellow";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'accepted');
          break;
        case "accepted":
          circle.style.backgroundColor = "lightgreen";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'completed');
          break;
        case "completed":
          circle.style.backgroundColor = "red";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'rejected');
          break;
        case "rejected":
          circle.style.backgroundColor = "transparent";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'pending');
          break;
      }
      // get order id and status
      let oid = circle.parentElement.parentElement.getAttribute('data-order-id');
      status = circle.getAttribute('data-status');
      let data = { "order_id": oid, "status": status };
      // use fetch to send data to server
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
    });
  });

  // add links to each order id field
  const orderIds = document.querySelectorAll('.order-id-field');
  orderIds.forEach(orderId => {
    let id = orderId.parentElement.getAttribute('data-order-id');
    orderId.addEventListener('click', function () {
      // redirect to order details page
      window.location.href = `${ROOT}/admin/orders/${id}`;
    });
  });

  // filter orders by type and status
  let typeFilter = document.getElementById("type");
  let statusFilter = document.getElementById("status");
  let rows = document.querySelectorAll("tbody tr");
  
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

});