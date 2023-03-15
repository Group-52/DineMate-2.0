<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/payment.addOrder.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/payments.js"></script>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">New Orders</h1>
                <a class="btn btn-primary text-uppercase fw-bold" href="payments/create" id="add-order-button">+ Add Customer</a>
            </div>
            

           
            
	<label for="customerName">customer Name:</label>
	<input type="text" id="username" name="username" onkeydown="if(event.keyCode==13) {submitForm(); return false;}"><br>

    <!-- <label for="customerName">Customer Id:</label>
	<input type="text" id="username" name="username"><br> -->
    
	<br>
     <?php if (isset($Guest)){
        foreach($Guest as $Guests){
            if($Guests->first_name . $Guests->last_name == $_POST['username'])
            echo "<label for='customerName'>Customer Id:".$Guests->guest_id."</label>";
        }
     } ?>


	
	<fieldset>
		<legend>Indian</legend>
		<label for="item1">search food</label>
		<select id="item1" name="item1">
			<option value=""></option>
                                <?php foreach ($dishes as $dish) : ?>
                                    <option value="<?= $dish->dish_name ?>"><?= $dish->dish_name ?></option>
                                <?php endforeach; ?>
		</select>
		<br><br>
		<label for="quantity1">Quantity:</label>
		<input type="number" id="quantity1" name="quantity1" min="1" max="100" value="1">
		<br><br>
	</fieldset>
	
	<fieldset>
		<legend>European</legend>
		<label for="item2">search food</label>
		<select id="item2" name="item2">
        <option value=""></option>
        <?php foreach ($dishes as $dish) : ?>
                                    <option value="<?= $dish->dish_name ?>"><?= $dish->dish_name ?></option>
                                <?php endforeach; ?>
		</select>
		<br><br>
		<label for="quantity2">Quantity:</label>
		<input type="number" id="quantity2" name="quantity2" min="1" max="100" value="1">
		<br><br>
	</fieldset>
	
	<fieldset>
		<legend>Beverages</legend>
		<label for="item3">Search Beverage:</label>
		<select id="item3" name="item3">
        <option value=""></option>
        <?php foreach ($dishes as $dish) : ?>
                                    <option value="<?= $dish->dish_name ?>"><?= $dish->dish_name ?></option>
                                <?php endforeach; ?>
		</select>
		<br><br>
		<label for="quantity3">Quantity:</label>
		<input type="number" id="quantity3" name="quantity3" min="1" max="100" value="1">
		<br><br>
	</fieldset>
	
	<input class="btn btn-primary text-uppercase fw-bold" type="button" value="Add to Order" onclick="addItem()">
	<br><br>
	<h2>Current Order:</h2>
	<ul id="order-list">
	</ul>
	
	<script>
    function addItem() {
        var item1 = document.getElementById("item1").value;
        var quantity1 = document.getElementById("quantity1").value;
        var item2 = document.getElementById("item2").value;
        var quantity2 = document.getElementById("quantity2").value;
        var item3 = document.getElementById("item3").value;
        var quantity3 = document.getElementById("quantity3").value;

        if (item1 !== "" || item2 !== "" || item3 !== "") {
            var orderList = document.getElementById("order-list");

            if (item1 !== "") {
                var newItem1 = document.createElement("li");
                newItem1.appendChild(document.createTextNode(quantity1 + "x " + item1));

                var deleteButton1 = document.createElement("button");
                deleteButton1.innerHTML = "Delete";
                deleteButton1.onclick = function() {
                    newItem1.parentNode.removeChild(newItem1);
                };
                newItem1.appendChild(deleteButton1);

                orderList.appendChild(newItem1);
            }

            if (item2 !== "") {
                var newItem2 = document.createElement("li");
                newItem2.appendChild(document.createTextNode(quantity2 + "x " + item2));

                var deleteButton2 = document.createElement("button");
                deleteButton2.innerHTML = "Delete";
                deleteButton2.onclick = function() {
                    newItem2.parentNode.removeChild(newItem2);
                };
                newItem2.appendChild(deleteButton2);

                orderList.appendChild(newItem2);
            }

            if (item3 !== "") {
                var newItem3 = document.createElement("li");
                newItem3.appendChild(document.createTextNode(quantity3 + "x " + item3));

                var deleteButton3 = document.createElement("button");
                deleteButton3.innerHTML = "Delete";
                deleteButton3.onclick = function() {
                    newItem3.parentNode.removeChild(newItem3);
                };
                newItem3.appendChild(deleteButton3);

                orderList.appendChild(newItem3);
            }
        }
    }
</script>


            
            <div id="addOrder-form" class="overlay">
                <form action="<?= ROOT ?>/admin/payments/create" method="POST">

                    <div class="form-group">
                        <label class="label" for="name">User Name</label>
                        <input class="form-control" type="text" name="user_name" id="user_name">
                    </div>
                    <div class="form-group">
                        <label class="label" for="brand">Contact No</label>
                        <input class="form-control" type="number" name="contact_no" id="contact_no">
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Email</label>
                        <input class="form-control" name="email" id="email">
                    </div>
                    
                   

                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="submit-button">Add Customer</button>
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>

                </form>
            </div>
        </div>
</body>

</html>