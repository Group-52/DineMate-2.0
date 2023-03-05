document.addEventListener("DOMContentLoaded", () => {
    const dishSelect = document.getElementById("dish-select");
    const addbutton = document.getElementById("add-button");
    const editbutton = document.getElementById("edit-button");
    const finishbutton = document.getElementById("finish-button");
    const inputrow = document.querySelector(".input-row");
    const dummyrow = document.querySelector(".dummy-row");
    const table = document.querySelector('table');

    editbutton.addEventListener("click", () => {
        event.preventDefault();
        editbutton.style.display = 'none';
        finishbutton.style.display = 'inline-block';
        //     make all pencil and trash icons visible
        document.querySelectorAll(".edit-icon").forEach((ic) => {
            ic.parentNode.style.display = "inline-block";
        });
    });
    finishbutton.addEventListener("click", () => {
        //     simulate click on all cross icons
        document.querySelectorAll(".cross-icon").forEach((ic) => {
            ic.click();
        });
        // make all pencil and trash icons invisible
        document.querySelectorAll(".edit-icon").forEach((ic) => {
            ic.parentNode.style.display = "none";
        });
        //     make edit button visible and finish button invisible
        editbutton.style.display = 'inline-block';
        finishbutton.style.display = 'none';
    });
    addbutton.addEventListener("click", () => {
        event.preventDefault();
        editbutton.style.display = 'none';
        addbutton.style.display = 'none';
        finishbutton.style.display = 'none';

        //     clone input row and show it
        let clone = inputrow.cloneNode(true);
        clone.style.display = "table-row";
        //     add before last row
        table.insertBefore(clone, table.lastElementChild);
        //     make add button and xmark visible
        clone.querySelector('.add-new-row').parentNode.style.display = 'inline-block';
        clone.querySelector('.fa-circle-xmark').parentNode.style.display = 'inline-block';
    });

    // go to different page when dish is selected
    dishSelect.addEventListener("change", (event) => {
        const dishId = event.target.value;
        if (dishId) {
            window.location.href = `${ROOT}/admin/ingredients/?d=${dishId}`;
        }
    });

    // function to add row on add button click
    function addRow(event) {
        console.log("Add Row");
        // get the row that was clicked
        let row = event.target.parentNode.parentNode;
        // get the dish,ingredient, quantity, and unit
        let dish = table.getAttribute("data-dish");
        let ingselect = row.querySelectorAll('select')[0];
        let ingredient = ingselect.value;
        let ingredientName = ingselect.options[ingselect.selectedIndex].text;
        let quantity = row.querySelector('input').value;
        let unitselect = row.querySelectorAll('select')[1];
        let unit = unitselect.value;
        let unitName = unitselect.options[unitselect.selectedIndex].text;

        addIngredient(dish, ingredient, quantity, unit);

        // clone dummy row and fill in the values
        let clone2 = dummyrow.cloneNode(true);
        // remove the dummy class
        clone2.classList.remove("dummy-row");
        clone2.style.display = "table-row";
        clone2.setAttribute("data-ingredient", ingredient);
        clone2.setAttribute("data-quantity", quantity);
        clone2.setAttribute("data-unit", unit);
        let tds = clone2.querySelectorAll('td');
        tds[0].innerHTML = ingredientName;
        tds[1].innerHTML = quantity;
        tds[2].innerHTML = unitName;
        // remove the input row
        row.remove();
        // insert the clone at the end of the table
        table.querySelector('tbody').appendChild(clone2);

        // make add button and edit button visible
        addbutton.style.display = 'inline-block';
        editbutton.style.display = 'inline-block';
    }

    // function to edit row on pencil icon click
    function editRow(event) {
        //get the row that was clicked
        let row = event.target.parentNode.parentNode;
        // add a class to the row for identification
        row.classList.add("being-edited");
        // get the ingredient, quantity, and unit
        let ingredient = row.getAttribute("data-ingredient");
        let quantity = row.getAttribute("data-quantity");
        let unit = row.getAttribute("data-unit");
        // hide the pencil and trash icons
        row.querySelectorAll(".edit-icon").forEach((ic) => {
            ic.parentNode.style.display = "none";
        });

        //clone input row before the row that was clicked and fill in the values
        let clone = inputrow.cloneNode(true);
        // show the tick and cross icons
        clone.querySelector(".tick-icon").parentNode.style.display = "inline-block";
        clone.querySelector(".cross-icon").parentNode.style.display = "inline-block";
        console.log("Clone:")
        console.log(clone);
        clone.style.display = "table-row";
        console.log(`Ingredient: ${ingredient}, Quantity: ${quantity}, Unit: ${unit}`)
        clone.querySelectorAll('select')[0].value = ingredient;
        clone.querySelector('input').value = quantity;
        clone.querySelectorAll('select')[1].value = unit;
        // insert the clone before the row that was clicked
        row.parentNode.insertBefore(clone, row);
        // hide the row that was clicked
        row.style.display = "none";
    }

    // function to cancel row editing on cross icon click
    function cancelRow(event) {
        // get the row that was clicked
        let row = event.target.parentNode.parentNode;
        // show the earlier row
        let r = document.querySelector(".being-edited");
        r.style.display = "table-row";
        // show the pencil and trash icons
        r.querySelectorAll(".edit-icon").forEach((ic) => {
            ic.parentNode.style.display = "inline-block";
        });
        // remove the class from the earlier row
        r.classList.remove("being-edited");
        // delete the clone
        row.remove();
    }

    // function to save row on tick icon click
    function saveRow(event) {
        console.log("Save Row");
        let row = event.target.parentNode.parentNode;
        // get the dish,ingredient, quantity, and unit
        let dish = table.getAttribute("data-dish");
        let ingselect = row.querySelectorAll('select')[0];
        let ingredient = ingselect.value;
        let ingredientName = ingselect.options[ingselect.selectedIndex].text;
        let quantity = row.querySelector('input').value;
        let unitselect = row.querySelectorAll('select')[1];
        let unit = unitselect.value;
        let unitName = unitselect.options[unitselect.selectedIndex].text;

        updateIngredient(dish, ingredient, quantity, unit)

        //find earlier row
        let r = document.querySelector(".being-edited");
        // update the earlier row with the new values
        r.setAttribute("data-ingredient", ingredient);
        r.setAttribute("data-quantity", quantity);
        r.setAttribute("data-unit", unit);
        let tds = r.querySelectorAll("td");
        tds[0].innerHTML = ingredientName;
        tds[1].innerHTML = quantity;
        tds[2].innerHTML = unitName;
        // show the earlier row
        r.style.display = "table-row";
        // show the pencil and trash icons
        r.querySelectorAll(".edit-icon").forEach((ic) => {
            ic.parentNode.style.display = "inline-block";
        });
        // remove the class from the earlier row
        r.classList.remove("being-edited");
        // delete the clone
        row.remove();
    }

    // function to delete on trash icon click
    function deleteRow(event) {
        // get the row that was clicked
        let row = event.target.parentNode.parentNode;
        // get the dish name and ingredient name
        let dish = table.getAttribute("data-dish");
        let ingredient = row.getAttribute("data-ingredient");

        // animate the row to shrink and fade out
        let height = row.offsetHeight;
        row.style.transition = 'all 0.5s ease';
        row.style.height = height + 'px';
        row.style.opacity = '0';
        setTimeout(function() {
            row.remove();
        }, 500);


        // delete the row
        // row.remove();
        // delete the ingredient from the dish
        deleteIngredient(dish, ingredient);
    }

    // function to stop adding new row on cross icon click
    function stopAddingRow(event) {
        // get the row that was clicked
        let row = event.target.parentNode.parentNode;
        // delete the row
        row.remove();
        //     display the buttons
        addbutton.style.display = "inline-block";
        editbutton.style.display = "inline-block";
    }

    // add event listener to icons using event delegation
    document.querySelector("table").addEventListener("click", (event) => {
        if (event.target.classList.contains("fa-pencil-square-o")) {
            editRow(event);
        } else if (event.target.classList.contains("cross-icon")) {
            cancelRow(event);
        } else if (event.target.classList.contains("tick-icon")) {
            saveRow(event);
        } else if (event.target.classList.contains("trash-icon")) {
            deleteRow(event);
        } else if (event.target.classList.contains("add-new-row")) {
            addRow(event);
        } else if (event.target.classList.contains("fa-circle-xmark")) {
            stopAddingRow(event);
        }
    });

    // Functions to send request to API
    function updateIngredient(dish, ingredient, quantity, unit) {
        let data = {
            dish: dish,
            ingredient: ingredient,
            quantity: quantity,
            unit: unit,
        }
        fetch(`${ROOT}/api/ingredients/edit`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log("success");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });

    }

    function deleteIngredient(dish, ingredient) {
        let data = {
            dish: dish,
            ingredient: ingredient,
        };

        // send the data to the server to delete the ingredient from the dish
        fetch(`${ROOT}/api/ingredients/delete`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log("success");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    function addIngredient(dish, ingredient, quantity, unit) {
        let data = {
            dish: dish,
            ingredient: ingredient,
            quantity: quantity,
            unit: unit
        }
        fetch(`${ROOT}/api/ingredients/add`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
            })
            .catch((error) => {
                console.error("Error:", error);
            });

    }
});
