<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Ingredients
    </title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .row {
            display: flex;
        }

        .col-md-4 {
            flex: 1;
            margin: 10px;
        }

        .dish-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        /* Additional styles for specific elements */
        ul.list-group {
            list-style-type: none;
            padding: 0;
        }

        form.ingredient-form {
            margin-top: 20px;
        }

        .dish-image {
            background-image: url("<?= ASSETS ?>/images/dishes/normaldish.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 5px;
        }

        #ing-form,
        #edit-button {
            display: none;
        }

        #edit-button {
            text-align: center;
            border-radius: 5px;
            margin: 10px;
            padding: 5px;
        }

        /* Style for pencil icon */
        .fa-pencil-square-o {
            display: none;
            cursor: pointer;
            /* Make the icon look clickable */
            color: #3498db;
            /* Change the color of the icon */
        }

        .fa-pencil-square-o:hover {
            color: #2980b9;
            /* Change the color of the icon on hover */
        }

        .fa-pencil-square-o:active {
            transform: scale(0.9);
            /* Scale the icon down slightly */
        }

        /* Style for the trash can icon */
        .fa-trash {
            display: none;
            cursor: pointer;
            /* Make the icon look clickable */
            color: #ff0000;
            /* Change the color of the icon */
        }

        /* Style for the trash can icon when hovered */
        .fa-trash:hover {
            color: #c0392b;
            /* Change the color of the icon on hover */
        }

        /* Style for the trash can icon when clicked */
        .fa-trash:active {
            transform: scale(0.9);
            /* Scale the icon down slightly */
        }

        /* Make extra table columns for edit icons be invisible */
        .edit-icons {
            display: none;
        }
    </style>
</head>

<body>


    <?php
    ?>
    <!-- Show all the dishes in a list -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Dishes</h3>
                <ul class="list-group">
                    <?php foreach ($dishes as $dish) : ?>
                        <li class="list-group-item">
                            <a href="#" data-id="<?= $dish->dish_id ?>" data-imgurl="<?= $dish->image_url ?>" class="dish-link">
                                <?= $dish->dish_name ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Dish details</h3>
                <div class="dish-image">
                    <img src="">
                </div>
                <div class="dish-info">
                    <h4 class="dish-name">
                        Select a dish to add ingredients
                    </h4>
                    <p class="dish-description"></p>
                </div>
                <!-- create a table for ingredients of dish -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="edit-icons"></th>
                            <th scope="col">Ingredient</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit</th>
                            <th scope="col" class="edit-icons"></th>
                        </tr>
                    </thead>
                    <tbody class="ingredients-list">
                    </tbody>
                </table>

                <a href=# class="btn btn-primary" id="edit-button">Edit Ingredients</a>
            </div>


            <div class="col-md-4" id="ing-form">
                <h3>Add ingredient</h3>
                <form class="ingredient-form">
                    <div class="form-group">
                        <label for="ingredient">Ingredient</label>
                        <select id="ingredient" class="form-control">
                            <option value="" disabled selected>Select an ingredient</option>
                            <?php foreach ($ingredients as $ingredient) : ?>
                                <option value="<?= $ingredient->item_id ?>">
                                    <?= $ingredient->item_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step=0.001 id="quantity" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select id="unit" class="form-control">
                            <option value="" disabled selected>Select a unit</option>
                            <?php foreach ($units as $unit) : ?>
                                <option value="<?= $unit->unit_id ?>">
                                    <?= $unit->unit_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" id="add-button">Add ingredient</button>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    var dishes = <?php echo json_encode($dishes); ?>;
    var ingredientlist = <?php echo json_encode($ingredientlist); ?>;
    var ingredients = <?php echo json_encode($ingredients); ?>;
    var ingredientNames = {};
    ingredients.forEach(ingredient => {
        ingredientNames[ingredient.item_id] = ingredient
    });

    console.log("ingredientNames")
    console.log(ingredientNames);
    var units = <?php echo json_encode($units); ?>;
    var unitNames = {};
    units.forEach(unit => {
        unitNames[unit.unit_id] = unit
    });


    const dishLinks = document.querySelectorAll('.dish-link');
    const dishImage = document.querySelector('.dish-image');
    const dishName = document.querySelector('.dish-name');
    const dishIngredients = document.querySelector('.ingredients-list');

    const baseUrl = "<?= ASSETS ?>/images/dishes/";

    // Add event listeners to all the dish links to show the dish details and change the image
    dishLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();

            // make the form and edit button visible
            document.getElementById("ing-form").style.display = "block";
            document.getElementById("edit-button").style.display = "block";

            const id = link.getAttribute('data-id');
            document.querySelector('.ingredient-form').setAttribute('data-dish-id', id);
            const imgname = link.getAttribute('data-imgurl');
            const imageUrl = baseUrl + imgname;
            dishImage.style.backgroundImage = `url(${imageUrl})`;
            dishName.textContent = dishes[id].dish_name;

            // get the ingredients of the dish
            myingredients = ingredientlist[id];
            console.log(myingredients);

            // display all the ingredients of the dish below the image in the table
            dishIngredients.innerHTML = "";
            myingredients.forEach(ingredient => {
                // console.log(ingredient);
                dishIngredients.innerHTML += `
                    <tr>
                        <td <i class = "fa fa-pencil-square-o" aria-hidden="true"></i></td>
                        <td data-ing-id = "${ingredient.item_id}" >${ingredient.item_name}</td>
                        <td>${ingredient.quantity}</td>
                        <td>${unitNames[ingredient.unit].unit_name}</td>
                        <td> <i class="fa fa-trash trash-icon"></i> </td>
                    </tr>
                `;
            });

            DeleteOnTrashClick();
        });
    });


    function DeleteOnTrashClick() {
        // Add event listener to the trash icon to delete the ingredient
        let tcicons = document.querySelectorAll(".trash-icon")
        tcicons.forEach(tcicon => {

            tcicon.addEventListener("click", function(event) {
                event.preventDefault();
                // get the ingredient id and dish id
                var ingredient = event.target.parentElement.parentElement.children[1].getAttribute("data-ing-id");
                var dish = document.querySelector(".ingredient-form").getAttribute("data-dish-id");
                ingredient = ingredientNames[ingredient].item_id;
                var data = {
                    dish: dish,
                    ingredient: ingredient
                };

                // send the data to the server to delete the ingredient from the dish
                fetch("<?= ROOT ?>/admin/ingredients/delete", {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });

                // remove the ingredient from the table
                event.target.parentElement.parentElement.remove();
            })
        });
    }


    // Add event listener to the form to add a new ingredient to the dish
    document.querySelector(".ingredient-form").addEventListener("submit", function(event) {
        event.preventDefault();

        var dish = document.querySelector(".ingredient-form").getAttribute("data-dish-id");
        var ingredient = document.getElementById("ingredient").value;
        var quantity = document.getElementById("quantity").value;
        var unit = document.getElementById("unit").value;

        var data = {
            dish: dish,
            ingredient: ingredient,
            quantity: quantity,
            unit: unit
        };
        console.log(data);

        fetch("<?= ROOT ?>/admin/ingredients/add", {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error("Error:", error);
            });


        // add the ingredient to the table below the image
        const tbody = document.querySelector(".ingredients-list");
        let ingid = document.getElementById("ingredient").value;
        let unitid = document.getElementById("unit").value;
        const tr = document.createElement("tr");

        const ingredientCell = document.createElement("td");
        ingredientCell.textContent = ingredientNames[ingid].item_name;
        tr.appendChild(ingredientCell);

        const quantityCell = document.createElement("td");
        quantityCell.textContent = quantity;
        tr.appendChild(quantityCell);

        const unitCell = document.createElement("td");
        unitCell.textContent = unitNames[unitid].unit_name;
        tr.appendChild(unitCell);

        tbody.appendChild(tr);
        tr.setAttribute('data-ingredient-id', data.ingredient_id);
        tr.setAttribute('data-ingredient-name', ingredientNames[ingid].item_name);
        tr.setAttribute('data-ingredient-quantity', quantity);
        tr.setAttribute('data-ingredient-unit', unitNames[unitid].unit_name);

    });


    // Add event listener to the edit button to make the ingredients editable
    document.getElementById("edit-button").addEventListener("click", function(event) {
        event.preventDefault();
        // Make the table headers with class edit-icons visible
        const editIcons = document.querySelectorAll('.edit-icons');
        editIcons.forEach(editIcon => {
            editIcon.style.display = "block";
        });

        // make trash icon visible
        const trashIcons = document.querySelectorAll('.ingredients-list .trash-icon');
        trashIcons.forEach(trashIcon => {
            trashIcon.style.display = "block";
        });

        // make the pencil icon visible
        const pencilIcons = document.querySelectorAll('.ingredients-list .fa-pencil-square-o');
        pencilIcons.forEach(pencilIcon => {
            pencilIcon.style.display = "block";
        });

        // make the edit button invisible
        document.getElementById("edit-button").style.display = "none";

        // make the add ingredient button say save
        document.getElementById("add-button").textContent = "Save";


    });

    // Add event listener to the add button to make the ingredients non editable
    document.getElementById("add-button").addEventListener("click", function(event) {
        event.preventDefault();

        // Make the table headers with class edit-icons invisible
        const editIcons = document.querySelectorAll('.edit-icons');
        editIcons.forEach(editIcon => {
            editIcon.style.display = "none";
        });

        // make trash icon invisible
        const trashIcons = document.querySelectorAll('.ingredients-list .trash-icon');
        trashIcons.forEach(trashIcon => {
            trashIcon.style.display = "none";
        });

        // make the pencil icon invisible
        const pencilIcons = document.querySelectorAll('.ingredients-list .fa-pencil-square-o');
        pencilIcons.forEach(pencilIcon => {
            pencilIcon.style.display = "none";
        });

        // make the edit button visible
        document.getElementById("edit-button").style.display = "block";

        // make the add ingredient button say add
        document.getElementById("add-button").textContent = "Add";

    });
</script>



</html>

<?php include "partials/dashboard.footer.php" ?>