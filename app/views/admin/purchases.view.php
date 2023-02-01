<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use models\Purchase;

    include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/purchases.css">

</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">

                <h1 class="display-3 active">Purchases</h1>
            </div>
            <table id="purchase-table">
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Item Name</th>
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
                                <td><?= $purchase->purchase_id ?></td>
                                <td><?= $purchase->item_name ?></td>
                                <td><?= $purchase->purchase_date ?></td>
                                <td><?= $purchase->vendor_name ?></td>
                                <td><?= $purchase->quantity ?></td>
                                <td><?= $purchase->brand ?></td>
                                <td><?= $purchase->expiry_date ?></td>
                                <td><?= $purchase->cost ?></td>
                                <td><?= $purchase->discount ?></td>
                                <td><?= $purchase->final_price ?></td>
                                <td><?= $purchase->tax ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <button class="btn btn-primary" id="add-purchase-button">Add Purchase</button>


            <div id="Addform">

                <form action="<?= ROOT ?>/admin/purchases/addPurchase" method="POST" onsubmit="return false">
                    <div class="form-group">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="date" name="purchase_date" id="purchase_date" placeholder="Purchase Date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <select name="vendor" id="vendor" class="form-control">
                            <?php foreach ($vendors as $vendor) { ?>
                                <option value="<?php echo $vendor->vendor_id; ?>"><?php echo $vendor->vendor_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="item">Item</label>
                        <select name="item" id="item" class="form-control">
                            <?php foreach ($items as $item) { ?>
                                <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step="0.01" name="quantity" id="quantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="number" step="0.01" name="cost" id="cost" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" step="0.01" name="discount" id="discount" placeholder="0-100%" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="final_price">Final Price</label>
                        <input type="number" step="0.01" name="final_price" id="final_price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tax">Tax</label>
                        <input type="number" step="0.01" name="tax" id="tax" placeholder="Tax" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Submit</button>
                    <button type="button" name="cancel" class="btn btn-danger" id="cancel-button">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // get all the elements
        const addButton = document.querySelector('#add-purchase-button');
        const form = document.querySelector('#Addform');
        const table = document.querySelector('#purchase-table');
        const submitButton = document.querySelector('#submit-button');
        const cancelButton = document.querySelector('#cancel-button');


        // make form visible when add button is clicked
        addButton.addEventListener('click', () => {
            form.style.display = 'block';
            table.style.filter = 'blur(5px)';

            // focus on first input
            document.querySelector('#purchase_date').focus();

            // make add button invisible
            addButton.style.display = 'none';
        });

        // make form invisible when submit button is clicked
        submitButton.addEventListener('click', () => {
            form.style.display = 'none';
            table.style.filter = 'blur(0)';

            // make add button visible
            addButton.style.display = 'block';
        });

        // make form invisible when cancel button is clicked
        cancelButton.addEventListener('click', () => {
            form.style.display = 'none';
            table.style.filter = 'blur(0)';
            addButton.style.display = 'block';
        });
    });
</script>

</html>