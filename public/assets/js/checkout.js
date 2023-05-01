document.addEventListener("DOMContentLoaded", () => {
  const orderTypeSelect = document.getElementById("order-type");
  const scheduleCheckbox = document.getElementById("schedule-order");
  const orderTimeInput = document.getElementById("order-time");
  const tableNumberInput = document.getElementById("table-number");

  scheduleCheckbox.onchange = () =>
    (orderTimeInput.disabled = !scheduleCheckbox.checked);

  orderTypeSelect.onchange = () => {
    if (orderTypeSelect.value !== "dine-in") {
      scheduleCheckbox.disabled = false;
      tableNumberInput.disabled = true;
      orderTimeInput.disabled = !scheduleCheckbox.checked;
    } else {
      scheduleCheckbox.disabled = true;
      scheduleCheckbox.checked = false;
      tableNumberInput.disabled = false;
      orderTimeInput.disabled = true;
    }
  };

  const checkoutBtn = document.querySelector("button");
  let socket = new WebSocket("ws://localhost:8080");
  checkoutBtn.onclick = (e) => {
    e.preventDefault();
    socket.onopen = function () {
      console.log("Event sent");
      let n = {
        "event_type": "new_order",
        "order_id": 25,
        "status": "pending",
        "time_placed": Date().toString(),
        "request": "more food",
        "reg_customer_id": 112,
        "type": "dine-in",
        "table_id": 4,
        "order_dishes":
          [
            {
              "dish_name": "Burger",
              "quantity": 2,
            },
            {
              "dish_name": "Chillie Parata",
              "quantity": 3
            },
            {
              "dish_name": "Salad",
              "quantity": 1
            }
          ]


      };
      socket.send(JSON.stringify(n));
    };
  }

});