document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.querySelector('#add-order-button');
    const form = document.querySelector('#addOrder-form');
    // const table = document.querySelector('#item-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');


    // const category = document.querySelector('select[name="category"]');
    // category.onchange = function () {
    //     this.form.submit();
    // }

    // make form visible when add button is clicked
    addButton.addEventListener('click', () => {
        event.preventDefault();
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';

        // focus on first input
        form.querySelector('input').focus();

        // make add button invisible
        addButton.style.display = 'none';

        // make form invisible when submit button is clicked

    });

    submitButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';

        // make add button visible
        addButton.style.display = 'block';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });

});

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