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
                <a class="btn btn-primary text-uppercase fw-bold" href="payments/paiments.addOrder/create" id="add-order-button">+ Add Customer</a>
            </div>
            

        

    <form method="post" action="">          
            <label for="username">customer Name:</label>
          <input type="text" id="username" name="username" onkeydown="if(event.keyCode==13) {submitForm(); return false;}"><br>
          <!-- <input type="submit" name="submit" value="Submit"> -->
            </form>                                                              
          <br>
          
          <?php                 
          if (isset($_POST['submit'])) {
             $username = $_POST['username'];
         if (isset($RegUser)){
           foreach($RegUser as $RegUsers){
            if($RegUsers->first_name === $username){
        // // //   if($RegUsers->first_name . $RegUsers->last_name == $_POST['username']){
            // echo "<label for='customerName'>Customer Id:".$RegUsers->user_id."</label>";
          echo "User ID: ".$RegUsers->user_id;
          }else
          echo "result not found";                                                                                  
       }}}
       ?>
 
  
  
    <br><br><br>

	<dev class="fieldset-container">
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
        <option value="<?= $dish->dish_name ?>"><?= $dish->dish_name  ?></option>
        <?php endforeach; ?>
		</select>
		<br><br>
		<label for="quantity3">Quantity:</label>
		<input type="number" id="quantity3" name="quantity3" min="1" max="100" value="1">
		<br><br>
	</fieldset>
    </dev>
    <style>
.fieldset-container {
  display: flex;
  justify-content: space-between; 
}
</style>
	
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

            var deleteIcon1 = document.createElement("i");
            deleteIcon1.classList.add("fas", "fa-trash-alt", "ml-2", "text-danger", "pointer");
            deleteIcon1.onclick = function() {
                newItem1.parentNode.removeChild(newItem1);
            };
            newItem1.appendChild(deleteIcon1);

            orderList.appendChild(newItem1);
        }

        if (item2 !== "") {
            var newItem2 = document.createElement("li");
            newItem2.appendChild(document.createTextNode(quantity2 + "x " + item2));

            var deleteIcon2 = document.createElement("i");
            deleteIcon2.classList.add("fas", "fa-trash-alt", "ml-2", "text-danger", "pointer");
            deleteIcon2.onclick = function() {
                newItem2.parentNode.removeChild(newItem2);
            };
            newItem2.appendChild(deleteIcon2);

            orderList.appendChild(newItem2);
        }

        if (item3 !== "") {
            var newItem3 = document.createElement("li");
            newItem3.appendChild(document.createTextNode(quantity3 + "x " + item3));

            var deleteIcon3 = document.createElement("i");
            deleteIcon3.classList.add("fas", "fa-trash-alt", "ml-2", "text-danger", "pointer");
            deleteIcon3.onclick = function() {
                newItem3.parentNode.removeChild(newItem3);
            };
            newItem3.appendChild(deleteIcon3);

            orderList.appendChild(newItem3);
        }
    }
}
</script>
<button class="btn btn-primary" id="add-dish-button" style="float: right">conform order</button>



            
            <div id="addOrder-form" class="overlay">
                <form action="<?= ROOT ?>/admin/payments/addOrder" method="POST">

                    <div class="form-group">
                        <label class="label" for="fname">First Name</label>
                        <input class="form-control" type="text" name="fname" id="fname">
                    </div>
                    <div class="form-group">
                        <label class="label" for="lname">Last Name</label>
                        <input class="form-control" type="text" name="lname" id="lname">
                    </div>
                    <div class="form-group">
                        <label class="label" for="contact_no">Contact No</label>
                        <input class="form-control" type="number" name="contact_no" id="contact_no">
                    </div>
                    <div class="form-group">
                        <label class="label" for="email">Email</label>
                        <input class="form-control" name="email" id="email">
                    </div>
                    
                   

                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="submit-button">Add Customer</button>
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>

                </form>
            </div>
        </div>
</body>

</html>

<style>
    legend{
        font-weight: 500;
    }
</style>