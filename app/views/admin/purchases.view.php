<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use models\Purchase;

    include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/purchases.css">
    <script src="<?= ASSETS ?>/js/admin/purchases.js"></script>

</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2">Purchases</h1>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" id="add-purchase-button">+ Add Purchase</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
            </div>
        </div>
        <table id="purchase-table" class="table">
            <thead>
            <tr>
                <!--                        <th>Purchase ID</th>-->
                <th>Item</th>
                <th>Purchase Date</th>
                <th>Vendor</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Expiry Date</th>
                <th>Cost</th>
                <th>Discount</th>
                <th>Final Price</th>
                <th>Tax</th>
            </tr>
            </thead>
            <tbody>

            <?php if (isset($purchases)) : ?>
                <?php foreach ($purchases as $purchase) : ?>
                    <tr data-purchase-id="<?= $purchase->purchase_id ?>">
                        <td style=display:none> <?= $purchase->purchase_id ?> </td>
                        <td><?= $purchase->item_name ?></td>
                        <td data-field-name="purchase_date"><?= substr($purchase->purchase_date, 0, 10) ?></td>
                        <td data-field-name="vendor"><?= $purchase->vendor_name ?></td>
                        <td data-field-name="quantity"
                            data-unit="<?= $purchase->abbreviation ?>"><?= $purchase->quantity ?> <?= $purchase->abbreviation ?></td>
                        <td data-field-name="brand"><?= $purchase->brand ?></td>
                        <td data-field-name="expiry_date"><?php if($purchase->expiry_date!='0000-00-00') echo $purchase->expiry_date ?></td>
                        <td data-field-name="cost"><?= $purchase->cost ?></td>
                        <td data-field-name="discount"><?= $purchase->discount ?></td>
                        <td data-field-name="final_price"><?= $purchase->final_price ?></td>
                        <td data-field-name="tax"><?= $purchase->tax ?></td>
                        <td><i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i></td>
                        <td><i class="fa fa-trash trash-icon" aria-hidden="true"></i></td>
                        <td><i class="fa fa-check-circle tick-icon edit-options" aria-hidden="true"></i></td>
                        <td><i class="fa fa-times-circle cross-icon edit-options" aria-hidden="true"></i></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <?php include VIEWS . "/partials/admin/paginationbar.partial.php" ?>

        <div id="Addform" class="overlay">

            <form action="<?= ROOT ?>/admin/purchases/add" method="POST">
                <div class="form-group">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="date" name="purchase_date" id="purchase_date" placeholder="Purchase Date"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="vendor">Vendor</label>
                    <select name="vendor" id="vendor" class="form-control">
                        <?php foreach ($vendors as $vendor) { ?>
                            <option
                                value="<?php echo $vendor->vendor_id; ?>"><?php echo $vendor->vendor_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="item">Item</label>
                    <select name="item" id="item" class="form-control" required>
                        <option disabled selected value="">Select Item</option>
                        <?php foreach ($items as $item) { ?>
                            <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <span class="d-block">
                    <input type="number" step="0.01" min="0" name="quantity" id="quantity" class="form-control d-inline w-75 mr-2" required><span id="unitspan"></span>
                    </span>
                </div>
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control">
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <span class="d-block">
                        <input type="number" step="1" name="cost" required id="cost"
                               class="form-control d-inline w-75 mr-1" min="0"> LKR
                        </span>
                </div>
                <div class="form-group">
                    <label for="discount">Discount</label>
                    <span class="d-block">
                        <input type="number" step="1" min="0" name="discount" id="discount" value="0"
                               class="form-control d-inline w-75 mr-2"> LKR
                        </span>
                </div>
                <div class="form-group">
                    <label for="tax">Tax</label>
                    <span class="d-block"> <input type="number" step="1" min="0" name="tax" id="tax" value="0"
                                                   class="form-control d-inline w-75 mr-2"> LKR </span>
                </div>
                <div class="form-group">
                    <label for="final_price">Final Price</label>
                    <span class="d-block">
                        <input type="number" step="1" min="0" required name="final_price" id="final_price"
                               class="form-control d-inline w-75 mr-2">  LKR </span>
                </div>
                <div class="d-flex justify-content-space-between">
                    <button type="button" name="cancel" class="btn btn-secondary text-uppercase" id="cancel-button">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary text-uppercase" id="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

</html>

<script>
    //Update final price
    let cost = document.getElementById('cost');
    let discount = document.getElementById('discount');
    let tax = document.getElementById('tax');
    let final_price = document.getElementById('final_price');
    [cost, discount, tax].forEach(function (element) {
        element.addEventListener('change', function () {
            final_price.value = parseFloat(cost.value) - parseFloat(discount.value) + parseFloat(tax.value);
        });
    });
</script>