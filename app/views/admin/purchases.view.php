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
                <h1 class="display-3 active">Purchases</h1>
                <div class="dashboard-buttons">
                    <a class="btn btn-primary text-uppercase fw-bold" id="add-purchase-button">Add Purchase</a>
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
                                <td data-field-name="quantity" data-unit="<?=$purchase->abbreviation?>"><?= $purchase->quantity ?> <?= $purchase->abbreviation ?></td>
                                <td data-field-name="brand"><?= $purchase->brand ?></td>
                                <td data-field-name="expiry_date"><?= $purchase->expiry_date ?></td>
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
            <!-- Pagination row -->

            <div class="d-flex justify-content-center pagination">
                <nav>
                    <div>

                        <!--                    Previous button-->

                        <?php if ($currentPage != 1) : ?>
                            <span class="page-item">
                                <a class="page-link page-move" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </span>
                        <?php endif; ?>
                        <!--                    Page numbers-->
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <span class="page-item <?php if ($currentPage == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </span>
                        <?php endfor; ?>
                        <!--                    Next button-->
                        <?php if ($currentPage != $totalPages) : ?>
                            <span class="page-item">
                          <a class="page-link page-move" href="?page=<?php echo $currentPage + 1; ?>"> Next </a>
                        </span>
                        <?php endif; ?>

                    </div>
                </nav>
            </div>

            <div id="Addform" class="overlay">

                <form action="<?= ROOT ?>/admin/purchases/add" method="POST">
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
                        <input type="number" step="0.01" name="cost" id="cost" placeholder="---- LKR" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" step="1" name="discount" id="discount" placeholder="---- LKR" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="final_price">Final Price</label>
                        <input type="number" step="1" name="final_price" id="final_price" placeholder="---- LKR" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tax">Tax</label>
                        <input type="number" step="1" name="tax" id="tax" placeholder="---- LKR" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Submit</button>
                    <button type="button" name="cancel" class="btn btn-danger" id="cancel-button">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>