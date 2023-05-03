<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/payments.addOrder.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/payments.addOrder.js"></script>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">New Orders</h1>
            <div class="dashboard-buttons">
                <a href="#" class="btn btn-primary text-uppercase fw-bold" id="confirm-order-button">Confirm Order</a>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div id="customer-data" class="w-50">
                    <span class="d-inline-flex w-75 justify-content-space-between">
                        <div class="form-group d-inline w-45">
                            <label class="label" for="fname">First Name</label>
                            <input class="form-control" type="text" name="fname" id="fname">
                        </div>
                        <div class="form-group d-inline w-45">
                            <label class="label" for="lname">Last Name</label>
                            <input class="form-control" type="text" name="lname" id="lname">
                        </div>
                    </span>
                    <span class="d-inline-flex w-75 justify-content-space-between">
                        <div class="form-group d-inline w-45">
                            <label class="label" for="contact_no">Contact No</label>
                            <input class="form-control" type="text" name="contact_no" id="contact_no">
                        </div>
                        <div class="form-group d-inline w-45">
                            <label class="label" for="email">Email</label>
                            <input class="form-control" name="email" id="email">
                        </div>
                    </span>
                    <span class="d-inline-flex w-75 justify-content-space-between">
                        <div class="form-group d-inline w-45">
                            <label class="label" for="type">Type</label>
                            <select class="form-control" name="type" id="order-type">
                                <option value="dine-in">Dine In</option>
                                <option value="takeaway">Take Away</option>
                                <option value="bulk">Bulk</option>
                            </select>
                        </div>
                        <div class="form-group d-inline w-45">
                            <label class="label" for="sctime">Scheduled Time</label>
                            <span class="d-inline-block">
                            <input type="checkbox" id="timecheck" name="timecheck" class="d-inline">
                            <input style="width:200px;" class="form-control d-inline fs-6" type="datetime-local" name="sctime" id="sctime">
                            </span>
                        </div>


                    </span>

                </div>
                <div class="fieldset-container d-flex justify-content-space-between w-50">
                    <fieldset class="w-100">
                        <legend>Dishes</legend>
                        <label for="item1">Dishes: &nbsp&nbsp&nbsp&nbsp</label>
                        <select id="item1" name="item1" class="form-control d-inline w-75">
                            <option value=""></option>
                            <?php foreach ($dishes as $dish) : ?>
                                <option value="<?= $dish->dish_name ?>" data-dishid="<?= $dish->dish_id ?>"
                                        data-price="<?= $dish->selling_price ?>"><?= $dish->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <label for="quantity1">Quantity: &nbsp</label>
                        <input type="number" id="quantity1" name="quantity1" min="1" max="100" value="1"
                               class="d-inline w-25 form-control mb-3">
                        <br>
                        <a href class="btn btn-primary text-uppercase fw-bold py-2 px-4 my-3" id="add-dish-button">+</a>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <h2>Current Order:</h2>
                    <ul id="order-list">
                    </ul>
                </div>
                <div class="col-5">
                    <h2>Order Summary:</h2>
                    <div class="p-2">Sub Total:
                        <span id="subtotal">0</span> LKR
                    </div>
                    <div class="p-2">Discount:
                        <span id="discount">0</span> LKR
                    </div>
                    <div class="p-2">Service-Charge:
                        <span id="sv-charge">0</span> LKR
                    </div>
                    <div class="p-2">Net Total:
                        <span id="nettotal">0</span> LKR
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>

</html>