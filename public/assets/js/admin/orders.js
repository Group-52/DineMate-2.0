document.addEventListener("DOMContentLoaded", () => {

  var confirm_button = document.querySelector('#confirm');
  var cancel_button = document.querySelector('#cancel');
  const rows = document.querySelectorAll('tbody tr');

  // if confirm button is clicked, update order status to completed
  confirm_button.addEventListener('click', function (event) {
    document.querySelector('.popup').style.display = 'none';
    let popup = document.querySelector('.popup');
    updateOrderStatus(popup.getAttribute('data-order-id'), "completed");
    // unblur all rows
    rows.forEach(row => {
      row.style.filter = 'blur(0)';
    }
    );

  });

  // if cancel button is clicked, remove popup and reset circle color and data-order-status
  cancel_button.addEventListener('click', function (event) {
    const popup = document.querySelector('.popup')
    popup.style.display = 'none';
    // reset status of order to previous status
    let oid = popup.getAttribute('data-order-id');

    let row = document.querySelector(`tr[data-order-id="${oid}"]`);
    let circle = row.querySelector('#circle');
    circle.setAttribute('data-order-status', "accepted");
    circle.style.backgroundColor = "yellow";
    // unblur all rows
    rows.forEach(row => {
      row.style.filter = 'blur(0)';
    }
    );
  });

  function displayPopup(c) {

    let oid = c.parentElement.parentElement.getAttribute('data-order-id');
    const popup = document.querySelector('.popup')
    popup.style.display = 'flex';
    popup.setAttribute('data-order-id', oid);
    popup.setAttribute('data-order-status', c.getAttribute('data-order-status'));
    // blur all other rows
    rows.forEach(row => {
      if (row.getAttribute('data-order-id') !== oid) {
        row.style.filter = 'blur(5px)';
      }
    });

  }

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

});