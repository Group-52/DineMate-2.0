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
        <div class="row">

            <div class="col-7">
                <div class="col">
                    <div id="customer-parent" class="row">
                    <span>
                        Customer Details
                        <i class="fas fa-chevron-down" id="customer-dropdown"></i>
                        </span>
                        <br><br><br>
                        <div id="customer-data-formdiv" class="w-100">
                    <span class="d-inline-flex w-75 justify-content-space-between">
                        <div class="form-group d-inline w-45">
                            <label class="label" for="fname">Name</label>
                            <input class="form-control" type="text" name="fname" id="fname">
                        </div>
                        <div class="form-group d-inline">
                            <label class="label" for="contact_no">Contact No</label>
                            <input class="form-control" type="text" name="contact_no" id="contact_no">
                        </div>
                    </span>
                        </div>
                    </div>
                    <div class="row">
                            <span class="d-inline-flex w-75 justify-content-space-between">
                                    <div class="form-group d-inline w-50">
                            <label class="label" for="type">Type</label>
                            <select class="form-control" name="type" id="order-type" style="width:60%">
                                <option value="dine-in">Dine In</option>
                                <option value="takeaway">Take Away</option>
                                <option value="bulk">Bulk</option>
                            </select>
                        </div>
                            <div class="form-group d-inline">
                            <label class="label" for="sctime">Scheduled Time</label>
                            <span class="d-inline-block">
                            <input type="checkbox" id="timecheck" name="timecheck" class="d-inline">
                            <input style="width:180px;" class="form-control d-inline fs-6" type="datetime-local"
                                   name="sctime" id="sctime" disabled>
                            </span>
                        </div>
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="fieldset-container d-flex justify-content-space-between w-50">
                        <fieldset class="w-100">
                            <legend>Dishes</legend>
                            <label for="item1">Dishes: &nbsp&nbsp&nbsp&nbsp</label>
                            <select id="item1" name="item1" class="form-control d-inline w-75">
                                <option value="" selected>Select Dish</option>
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
                            <a href class="btn btn-primary text-uppercase fw-bold py-2 px-4 my-3"
                               id="add-dish-button">+</a>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="col-5 p-2 h" id="sidebar-order">
                <div id="customer-data" class="p-2 m-2">
                    Name : <span id="customer-name">--</span>
                    <br>
                    Contact No: <span id="customer-contact">--</span>
                </div>
                <div id="dishes" class="p-2 mb-5">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Dish Id</th>
                            <th>Dish Name</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div id="cost-view" class="p-2 col">
                    <div class="row justify-content-space-between p-1"> <span class="d-inline-block">Subtotal : </span><span><span id="subtotal-view">0</span> &nbspLKR</span></div>
                    <div class="row justify-content-space-between p-1"> <span class="d-inline-block">Promotion : </span><span><span id="promotion-view">0</span> &nbspLKR</span></div>
                    <div class="row justify-content-space-between p-1"> <span class="d-inline-block">Service Charge : </span><span><span id="service-charge-view">0</span> &nbspLKR</span></div>
                    <hr>
                    <div class="row justify-content-space-between p-1"> <span class="d-inline-block"><b>Net Total : </span><span><span id="net-total-view">0</span> &nbspLKR</b></span></div>
                </div>
                <div id="pay-btn-view" class="m-5 row justify-content-center">
                    <a href="#" class="d-block w-75 btn btn-success text-center">Create Order</a>
                </div>
            </div>

        </div>

    </div>
</body>

</html>