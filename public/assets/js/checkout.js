document.addEventListener("DOMContentLoaded", () => {
  const orderTypeSelect = document.getElementById("order-type");
  const scheduleCheckbox = document.getElementById("schedule-order");
  const orderTimeInput = document.getElementById("order-time");
  const tableNumberInput = document.getElementById("table-number");

  let total = parseFloat(document.getElementById("total").innerHTML);
  const serviceChargeElement = document.getElementById("service-charge");
  const totalElement = document.getElementById("total");

  if (scheduleCheckbox !== null)
  {
    scheduleCheckbox.onchange = () =>
      (orderTimeInput.disabled = !scheduleCheckbox.checked);
  }

  orderTypeSelect.onchange = () => {
    if (orderTypeSelect.value !== "dine-in") {
      serviceChargeElement.innerHTML = "0";
      totalElement.innerHTML = total.toFixed();
      if (scheduleCheckbox !== null)
      {
        scheduleCheckbox.disabled = false;
        orderTimeInput.disabled = !scheduleCheckbox.checked;
      }
      tableNumberInput.disabled = true;
    } else {
      const serviceCharge = total * 0.05;
      serviceChargeElement.innerHTML = serviceCharge.toFixed();
      totalElement.innerHTML = (total + serviceCharge).toFixed();
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