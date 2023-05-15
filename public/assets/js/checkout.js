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

  // Tip
  const tipElement = document.getElementById("tip-calc");
  const tipSelect = document.getElementById("tip");

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
      const serviceCharge = subTotal * 0.05;
      const tip = subTotal * parseFloat(tipSelect.value);
      serviceChargeElement.innerHTML = serviceCharge.toFixed();
      totalElement.innerHTML = (subTotal + serviceCharge - discount + tip).toFixed();
      tableNumberInput.disabled = false;
    }
  };

  // Tip Select on change
  tipSelect.onchange = () => {
    const tip = subTotal * parseFloat(tipSelect.value);
    tipElement.innerHTML = tip.toFixed();

    // Service charge based on order type
    let serviceCharge = 0;
    if (orderTypeSelect.value === "dine-in") {
      serviceCharge = subTotal * 0.05;
    }

    // Calculating total
    totalElement.innerHTML = (subTotal + serviceCharge - discount + tip).toFixed();
  }

  //fetch opening and closing times
  let rtimes = fetch(`${ROOT}/api/GeneralDetails`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => {
    return response.json();
  })

  rtimes.then(data => {
    console.log(data);
    const maxAmt = data.details["max_nonbulk"];
    if (subTotal >= maxAmt) {
      let option = document.createElement("option");
      option.value = "bulk";
      option.innerHTML = "Bulk";
      orderTypeSelect.appendChild(option);
      orderTypeSelect.value = "bulk";
      orderTypeSelect.disabled = true;
      serviceChargeElement.innerHTML = "0";
      totalElement.innerHTML = total.toFixed();
      tableNumberInput.disabled = true;
      if (scheduleCheckbox !== null) {
        scheduleCheckbox.disabled = false;
        scheduleTimeInput.disabled = false;
      }
      tableNumberInput.disabled = true;
    }
  })


  // Schedule order time validation
  let sctime = scheduleTimeInput;
  if (sctime !== null) {
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
  }

});