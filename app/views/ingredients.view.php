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
                    <img src="<?= ASSETS ?> . /images/dishes/ . <?= $dish->image_url ?>">
                </div>
                <div class="dish-info">
                    <h4 class="dish-name"></h4>
                    <p class="dish-description"></p>
                </div>
                <ul class="ingredients-list">

                </ul>
            </div>




            <div class="col-md-4">
                <h3>Add ingredient</h3>
                <form class="ingredient-form">
                    <div class="form-group">
                        <label for="ingredient">Ingredient</label>
                        <select id="ingredient" class="form-control">
                            <?php foreach ($ingredients as $ingredient) : ?>
                                <option value="<?= $ingredient->item_id ?>">
                                    <?= $ingredient->item_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" id="quantity" class="form-control" />
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

                    <button type="submit" class="btn btn-primary">Add ingredient</button>
                </form>
            </div>
        </div>
    </div>


</body>

<script>
    var dishes = <?php echo json_encode($dishes); ?>;
    var ingredientlist = <?php echo json_encode($ingredientlist); ?>;

    const dishLinks = document.querySelectorAll('.dish-link');
    const dishImage = document.querySelector('.dish-image');
    const dishName = document.querySelector('.dish-name');
    const dishIngredients = document.querySelector('.ingredients-list');

    const baseUrl = "<?= ASSETS ?>/images/dishes/";

    dishLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const id = link.getAttribute('data-id');
            const imgname = link.getAttribute('data-imgurl');
            const imageUrl = baseUrl + imgname;
            dishImage.style.backgroundImage = `url(${imageUrl})`;
            dishName.textContent = dishes[id].dish_name;

            myingredients = ingredientlist[id];

            // add all the ingredients to the list
            if (myingredients){

                dishIngredients.innerHTML = '';
                myingredients.forEach(ingredient => {
                    const li = document.createElement('li');
                    li.textContent = ingredient.item_name;
                    dishIngredients.appendChild(li);
                });
            }
                
        });
    });



    // // construct a map of dishes with their ids as keys
    // var dishesMap = new Map(dishes.map(dish => [dish.dish_id, dish]));

    // dishLinks.forEach(link => {
    //     link.addEventListener('click', e => {
    //         e.preventDefault();
    //         var id = link.getAttribute('data-id');
    //         var selectedDish = dishesMap.get(id);
    //         dishName.textContent = selectedDish.dish_name;
    //     });
    // });
</script>



</html>

<?php include "partials/dashboard.footer.php" ?>