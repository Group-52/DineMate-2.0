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
        addbutton.style.display = 'none';
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
        addbutton.style.display = 'inline-block';
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
        clone.setAttribute("data-ingredient", ingredient);
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
        setTimeout(function () {
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
            let row = event.target.parentNode.parentNode;
            if (checkEditingIngredient(row)) saveRow(event);

        } else if (event.target.classList.contains("trash-icon")) {
            deleteRow(event);

        } else if (event.target.classList.contains("add-new-row")) {
            // if input has values only
            let row = event.target.parentNode.parentNode;
            if (checkAddingIngredient(row)) addRow(event)

        } else if (event.target.classList.contains("fa-circle-xmark")) {
            stopAddingRow(event);

        }
    });

    // given a tr check if ingredient is already present in the table or empty, if the quantity is empty or if the unit is empty
    function checkAddingIngredient(row) {
        //get value of selected option
        let ingselect = row.querySelectorAll('select')[0];
        //create array with existing ingredient values
        let existing_ings_values = [];
        document.querySelectorAll("tr[data-ingredient]").forEach((ing) => {
            existing_ings_values.push(ing.getAttribute("data-ingredient"));
        });
        //if the ingredient is not selected
        if (!ingselect.value) {
            //show error message
            displayError("Ingredient cannot be empty", ingselect.getBoundingClientRect().top);
            return false;
        }
        //if the selected value is already present in the table
        if (existing_ings_values.includes(ingselect.value)) {
            //show error message
            displayError("Ingredient already present in the table", ingselect.getBoundingClientRect().top);
            //reset the select to default value
            ingselect.value = "";
            return false;
        }
        //if the quantity is empty
        if (!row.querySelector('input').value) {
            //show error message
            displayError("Quantity cannot be empty", row.querySelector('input').getBoundingClientRect().top);
            return false;
        }
        //if the unit is empty
        if (!row.querySelectorAll('select')[1].value) {
            //show error message
            displayError("Unit cannot be empty", row.querySelectorAll('select')[1].getBoundingClientRect().top);
            return false;
        }
        return true;
    }

    // given a tr check if ingredient is already present in the table or if the quantity is empty
    function checkEditingIngredient(row) {
//get value of selected option
        let ingselect = row.querySelectorAll('select')[0];
        //create array with existing ingredient values
        let existing_ings_values = [];
        document.querySelectorAll("tr[data-ingredient]").forEach((ing) => {
            existing_ings_values.push(ing.getAttribute("data-ingredient"));
        });
        //if the selected value is already present in the table
        if (existing_ings_values.includes(ingselect.value) && ingselect.value != row.getAttribute("data-ingredient")) {
            //show error message
            displayError("Ingredient already present in the table", ingselect.getBoundingClientRect().top);
            //reset the select to default value
            ingselect.value = "";
            return false;
        }
        //if the quantity is empty
        if (!row.querySelector('input').value) {
            //show error message
            displayError("Quantity cannot be empty", row.querySelector('input').getBoundingClientRect().top);
            return false;
        }
        return true;
    }


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

// <!DOCTYPE html>
// <html lang="en">
// <head>
// <?php include VIEWS . "/partials/admin/head.partial.php" ?>
// <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
//     <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/ingredients.detail.css">
//     <script src="<?= ASSETS ?>/js/admin/ingredients.detail.js"></script>
// </head>
// <body class="dashboard">
// <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
// <!-- Show all the dishes in a list -->
// <div class="dashboard-container">
//     <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
//     <div class="w-100 h-100 p-5">
//         <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
//             <h1 class="display-3 active">Ingredients</h1>
//             <div class="dashboard-buttons">
//                 <div class="form-group d-inline-block pr-3" style="width:200px">
//                     <select id="dish-select" class="form-control">
//                         <option value="" disabled selected>Select a dish</option>
//                         <?php if (isset($dishes)): ?>
//                         <?php foreach ($dishes as $d) : ?>
//                         <option value="<?= $d->dish_id ?>" data-id="<?= $d->dish_id ?>"
//                                 data-imgurl="<?= $d->image_url ?>">
//                             <?= $d->dish_name ?>
//                         </option>
//                         <?php endforeach; ?>
//                         <?php endif; ?>
//                     </select>
//                 </div>
//
//                 <a class="btn btn-primary text-uppercase fw-bold" id="add-button">Add Ingredient</a>
//                 <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
//                 <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
//             </div>
//         </div>
//         <!--        div with two columns-->
//
//         <div class="row">
//             <div class="col-6 text-center">
//                 <img src="<?= ASSETS ?>/images/dishes/<?= $dish->image_url ?>" alt="dish image">
//             </div>
//             <div class="col-6 text-center">
//                 <h1 class="display-3 active"><?= $dish->dish_name ?></h1>
//                 <p class="lead"><?= $dish->description ?></p>
//             </div>
//         </div>
//
//         <div class="row">
//             <div class="col-12">
//                 <!-- create a table for ingredients of dish -->
//                 <table class="table table-striped" data-dish="<?= $dish->dish_id ?>">
//                     <thead>
//                     <tr>
//                         <th>Ingredient</th>
//                         <th>Quantity</th>
//                         <th>Unit</th>
//                     </tr>
//                     </thead>
//                     <tbody class="text-center">
//                     <?php foreach ($dishIngredients as $ingredient) : ?>
//                     <tr data-ingredient="<?= $ingredient->item_id ?>" data-unit="<?= $ingredient->unit_id ?>"
//                         data-quantity="<?= $ingredient->quantity ?>">
//                         <td><?= $ingredient->item_name ?></td>
//                         <td><?= $ingredient->quantity ?></td>
//                         <td><?= $ingredient->unit_name ?></td>
//                         <td><i class="fa fa-pencil-square-o edit-icon"></i></td>
//                         <td><i class="fa fa-trash trash-icon edit-icon"></i></td>
//                     </tr>
//                     <?php endforeach; ?>
//
//                     <tr class="input-row">
//                         <td>
//                             <select name="ingredient" class="p-1">
//                                 <option value="" disabled selected>Select an ingredient</option>
//                                 <?php if (isset($ingredients)) : ?>
//                                 <?php foreach ($ingredients as $ingredient) : ?>
//                                 <option value="<?= $ingredient->item_id ?>">
//                                     <?= $ingredient->item_name ?>
//                                 </option>
//                                 <?php endforeach; ?>
//                                 <?php endif; ?>
//                             </select>
//                         </td>
//                         <td>
//                             <input class="p-1" type="number" placeholder="Quantity" name="quantity" min="0.001" step="0.001"
//                                    oninput="validity.valid||(value='');" required>
//                         </td>
//                         <td>
//                             <select name="unit" class="p-1">
//                                 <option value="" disabled selected>Select a unit</option>
//                                 <?php if (isset($units)) : ?>
//                                 <?php foreach ($units as $unit) : ?>
//                                 <option value="<?= $unit->unit_id ?>">
//                                     <?= $unit->unit_name ?>
//                                 </option>
//                                 <?php endforeach; ?>
//                                 <?php endif; ?>
//                             </select>
//                         </td>
//                         <td><i class="fa fa-check-circle tick-icon edit-options"></i></td>
//                         <td><i class="fa fa-times-circle cross-icon edit-options"></i></td>
//                         <td>
//                             <button class="add-new-row">Add</button>
//                         </td>
//                         <td><i class="fa-solid fa-circle-xmark"></i></td>
//
//                     </tr>
//                     <tr class="dummy-row" data-ingredient="0" data-unit="0" data-quantity="0">
//                         <td></td>
//                         <td></td>
//                         <td></td>
//                         <td><i class="fa fa-pencil-square-o edit-icon"></i></td>
//                         <td><i class="fa fa-trash trash-icon edit-icon"></i></td>
//                     </tr>
//                     </tbody>
//                 </table>
//             </div>
//         </div>
//     </div>
//
// </div>
// </div>
// </body>
// </html>