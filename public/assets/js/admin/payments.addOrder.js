document.addEventListener('DOMContentLoaded', () => {

    const addDishButton = document.querySelector('#add-dish-button');

    function addItem() {
        const item1 = document.getElementById("item1").value;
        const quantity1 = document.getElementById("quantity1").value;
        const price1 = document.getElementById("item1").selectedOptions[0].dataset.price;

        if (item1 !== "") {
            if (validateItem(item1, quantity1, price1)) {
                return; // exit function if item is already in order
            }

            const orderList = document.getElementById("order-list");
            const newItem1 = document.createElement("li");
            newItem1.setAttribute('data-item', item1);
            newItem1.setAttribute('data-dishid', document.getElementById("item1").selectedOptions[0].dataset.dishid);
            newItem1.innerHTML = `<span class="liquantity">${quantity1}</span> x <span class="liitem">${item1}</span> <span class="liprice">${quantity1 * price1}</span> LKR<i class="fas fa-trash-alt ml-2 text-danger pointer"></i>`;
            newItem1.querySelector("i").onclick = function () {
                newItem1.parentNode.removeChild(newItem1);
                updateTotalCost();
            };
            orderList.appendChild(newItem1);
        }
    }


    addDishButton.addEventListener('click', () => {
        event.preventDefault();
        addItem();
        updateTotalCost();
    });

    function validateItem(itemName, quantity, price) {
        const orderList = document.getElementById("order-list");
        const items = orderList.querySelectorAll("li");

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const itemQuantity = parseInt(item.querySelector(".liquantity").textContent);
            const itemPrice = parseInt(item.querySelector(".liprice").textContent);

            if (item.getAttribute("data-item") === itemName) {
                const newQuantity = itemQuantity + parseInt(quantity);
                const newPrice = newQuantity * parseInt(price);
                item.querySelector(".liquantity").textContent = newQuantity;
                item.querySelector(".liprice").textContent = newPrice;
                return true;
            }
        }

        return false;
    }

    function updateTotalCost() {
        //update subtotal
        const lis = document.querySelectorAll("#order-list li");
        let total = 0;
        lis.forEach(li => {
            const price = parseInt(li.querySelector(".liprice").textContent);
            total += price;
        });
        const totalCostDiv = document.getElementById("subtotal");
        totalCostDiv.textContent = total;
        const svchargediv = document.querySelector('#sv-charge')
        //update net total
        const netTotalDiv = document.getElementById("nettotal");
        let svcharge;
        if (document.querySelector('#order-type').value != "dine-in") {
            svcharge = 0;
        } else {
            svcharge = total * 0.05
        }
        svchargediv.innerHTML = svcharge
        const discount = parseFloat(document.getElementById("discount").innerHTML);
        netTotalDiv.textContent = total - discount + svcharge + "";

    }
    document.querySelector('#order-type').addEventListener("change",()=>{
        updateTotalCost();
    })


    document.querySelector('#confirm-order-button').addEventListener('click', (event) => {
        event.preventDefault();
        getData();
    });

    function getData() {
        const firstName = document.querySelector('#fname').value;
        const lastName = document.querySelector('#lname').value;
        const email = document.querySelector('#email').value;
        const contactNo = document.querySelector('#contact_no').value;
        const total = document.querySelector('#subtotal').textContent;
        let time = null;
        if (document.querySelector('#timecheck').checked) {
            time = document.querySelector('#sctime').value;
        }

        const dishList = [];
        const lis = document.querySelectorAll('#order-list li');
        lis.forEach(li => {
            const dishId = li.getAttribute('data-dishid');
            const quantity = parseInt(li.querySelector('.liquantity').textContent);
            dishList.push({dishId: dishId, quantity: quantity});
        });

        const otype = document.querySelector('#order-type').value;

        const orderData = {
            firstname: firstName,
            lastname: lastName,
            email: email,
            contactno: contactNo,
            total: total,
            dishlist: dishList,
            type: otype
        };
        if (time && time !== '') {
            orderData.sctime = time;
        }

        console.log(orderData);
    }

    document.querySelector('#timecheck').addEventListener('change', () => {
        if (timecheck.checked) {
            document.querySelector('#sctime').disabled = false;
        } else {
            document.querySelector('#sctime').disabled = true;
            //clear the value
            document.querySelector('#sctime').value = '';
        }
    });


});  