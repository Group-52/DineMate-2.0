document.addEventListener("DOMContentLoaded", () => {
  const orderTypeSelect = document.getElementById("order-type");
  const scheduleCheckbox = document.getElementById("schedule-order");
  const scheduleTimeInput = document.getElementById("schedule-time");
  const tableNumberInput = document.getElementById("table-number");

  const subTotalElement = document.getElementById("sub-total");
  const totalElement = document.getElementById("total");
  const subTotal = parseFloat(subTotalElement.innerHTML);
  const discount = parseFloat(document.getElementById("discount").innerHTML);
  const total = parseFloat(totalElement.innerHTML);
  const serviceChargeElement = document.getElementById("service-charge");

  // YYYY-MM-DDThh:mm:ssTZD

  if (scheduleCheckbox !== null)
  {
    scheduleCheckbox.onchange = () =>
    {
      scheduleTimeInput.disabled = !scheduleCheckbox.checked;
      tableNumberInput.disabled = scheduleCheckbox.checked;
    }
  }

  orderTypeSelect.onchange = () => {
    if (orderTypeSelect.value !== "dine-in") {
      serviceChargeElement.innerHTML = "0";
      totalElement.innerHTML = total.toFixed();
      tableNumberInput.disabled = true;
    } else {
      console.log(subTotal);
      const serviceCharge = subTotal * 0.05;
      console.log(serviceCharge);
      serviceChargeElement.innerHTML = serviceCharge.toFixed();
      totalElement.innerHTML = (subTotal + serviceCharge - discount).toFixed();
      tableNumberInput.disabled = false;
    }
  };
  //fetch opening and closing times
  let rtimes = fetch(`${ROOT}/api/GeneralDetails`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => {
    return response.json();
  })

  // Schedule order time validation
  let sctime = scheduleTimeInput;
  var op, cp;
  sctime.addEventListener('change', () => {
    //if scheduled time be less than current time + 1 hour show error
    let date = new Date();
    let chour = date.getHours();
    let cmin = date.getMinutes();
    //today date only
    let cdate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), chour + 2, cmin, 0, 0);
    let sdate = new Date(sctime.value);
    if (sdate < cdate) {
      new Toast('fa-solid fa-exclamation-circle', 'red', 'Invalid Time', 'Scheduled time should be at least 2 hours from now', false, 3000);
      sctime.value = "";
    }
    rtimes.then(data => {
      op = data.details.opening_time
      cp = data.details.closing_time

      let temp = sctime.value.split("T")[1];
      let openingTime = new Date("1970-01-01T" + op + "Z");
      let closingTime = new Date("1970-01-01T" + cp + "Z");
      let selectedTime = new Date("1970-01-01T" + temp + "Z");

      // Compare the selectedTime with openingTime and closingTime
      if (selectedTime < openingTime || selectedTime > closingTime) {
        new Toast('fa-solid fa-exclamation-circle', 'red', 'Invalid Time', 'Scheduled time should be between opening and closing times', false, 3000);
      }
    })
  })

});