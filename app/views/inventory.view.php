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
        tr:nth-child(even) {background-color: #f2f2f2}
        td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<a href="<?= ROOT ?>/admin/inventory/info">Detailed View</a>
<h1>Inventory</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Amount Remaining</th>
            <th>Last Updated</th>
            <th> Max Stock Level</th>
            <th> Buffer Stock Level</th>
            <th> Lead Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $item) : ?>
            <tr>
                <td><?= $item->item_name ?></td>
                <td><?= $item->amount_remaining ?></td>
                <td><?= $item->last_updated ?></td>
                <td><?= $item->max_stock_level ?></td>
                <td><?= $item->buffer_stock_level ?></td>
                <td><?= $item->lead_time ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>

<?php include "partials/dashboard.footer.php" ?>
