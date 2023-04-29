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
});