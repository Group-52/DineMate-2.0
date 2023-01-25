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

        .shrink {
            transition: height 2s ease-out;
        }

        #Addform {
            padding: 10px;
            margin: 10px;
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

    <div id="Addform">

        <form action="<?= ROOT ?>/admin/purchases/addPurchase" method="POST">
            <input type="date" name="purchase_date" id="purchase_date" placeholder="Purchase Date">

            <select name="vendor" id="vendor">
                <?php foreach ($vendors as $vendor) { ?>
                    <option value="<?php echo $vendor->vendor_id; ?>"><?php echo $vendor->vendor_name; ?></option>
                <?php } ?>
            </select>


            <select name="item" id="item">
                <?php foreach ($items as $item) { ?>
                    <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                <?php } ?>
            </select>


            <input type="number" step="0.01" name="quantity" id="quantity" placeholder="Quantity">
            <input type="text" name="brand" id="brand" placeholder="Brand">
            <input type="date" name="expiry_date" id="expiry_date" placeholder="Expiry Date">
            <input type="decimal" name="cost" id="cost" placeholder="Cost">
            <input type="number" step="0.01" name="discount" id="discount" placeholder="Discount">
            <input type="number" step="0.01" name="final_price" id="final_price" placeholder="Final Price">
            <input type="number" step="0.01" name="tax" id="tax" placeholder="Tax">
            <button type="submit" name="submit">Submit</button>
        </form>

    </div>

</body>

</html>