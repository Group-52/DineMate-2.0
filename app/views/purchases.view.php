<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color: #588c7e;
            color: white;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .editable {
            border: 2px solid green;
        }

        /* Style for the trash can icon */
        .fa-trash {
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

        #Addform {
            width : 30%;
            padding: 10px;
            margin: 10px;
            display: none;
        }

        .form-control {
            width: 100%;
        }
    </style>
</head>

<body>
    <table>
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

    <button class="btn btn-primary" id="add-button">Add Purchase</button>


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
                <input type="number" step="0.01" name="cost" id="cost"  class="form-control">
            </div>
            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="number" step="0.01" name="discount" id="discount" placeholder="0-100%" class="form-control">
            </div>
            <div class="form-group">
                <label for="final_price">Final Price</label>
                <input type="number" step="0.01" name="final_price" id="final_price"  class="form-control">
            </div>
            <div class="form-group">
                <label for="tax">Tax</label>
                <input type="number" step="0.01" name="tax" id="tax" placeholder="Tax" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-primary" id="submit-button" >Submit</button>
        </form>

    </div>

</body>
<?php include 'partials/dashboard.footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // make form visible when add button is clicked
        const addButton = document.querySelector('#add-button');
        addButton.addEventListener('click', () => {
            const formdiv = document.querySelector('#Addform');
            formdiv.style.display = 'block';
        });  
    });


</script>

</html>
