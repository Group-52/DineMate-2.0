document.addEventListener("DOMContentLoaded", () => {
  const orderTypeSelect = document.getElementById("order-type");
  const scheduleCheckbox = document.getElementById("schedule-order");
  const orderTimeInput = document.getElementById("order-time");
  const tableNumberInput = document.getElementById("table-number");

  if (scheduleCheckbox !== null)
  {
    scheduleCheckbox.onchange = () =>
      (orderTimeInput.disabled = !scheduleCheckbox.checked);
  }

  orderTypeSelect.onchange = () => {
    if (orderTypeSelect.value !== "dine-in") {
      if (scheduleCheckbox !== null)
      {
        scheduleCheckbox.disabled = false;
        orderTimeInput.disabled = !scheduleCheckbox.checked;
      }
      tableNumberInput.disabled = true;
    } else {
      if (scheduleCheckbox !== null)
      {
        scheduleCheckbox.disabled = true;
        scheduleCheckbox.checked = false;
        orderTimeInput.disabled = true;
      }
      tableNumberInput.disabled = false;
    }
  };
});