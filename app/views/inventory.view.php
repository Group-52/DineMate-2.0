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

        .shrink {
            transition: height 2s ease-out;
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
            <th>Reorder Level</th>
            <th> Lead Time</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $item) : ?>
            <tr data-item-id="<?=$item->item_id?>">
                <td data-field-name="item_name"><?= $item->item_name ?></td>
                <td data-field-name="amount_remaining"><?= $item->amount_remaining ?></td>
                <td data-field-name="last_updated"><?= $item->last_updated ?></td>
                <td data-field-name="max_stock_level"><?= $item->max_stock_level ?></td>
                <td data-field-name="buffer_stock_level"><?= $item->buffer_stock_level ?></td>
                <td data-field-name="reorder_level"><?= $item->reorder_level ?></td>
                <td data-field-name="lead_time"><?= $item->lead_time ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="#" onclick="makeEditable()">Edit</a>
<a href="#" onclick="updateInventory()">Update</a>
</body>
</html>

<?php include "partials/dashboard.footer.php" ?>


<script>
    function makeEditable() {
        var cells = document.querySelectorAll("td[data-field-name='max_stock_level'], td[data-field-name='buffer_stock_level'], td[data-field-name='reorder_level'], td[data-field-name='lead_time']");
        for (var i = 0; i < cells.length; i++) {
            cells[i].setAttribute("contenteditable", "true");
            cells[i].classList.add("editable");
            cells[i].addEventListener("input", function() {
                this.setAttribute("data-changed", true);
            })
        }
        cells[0].focus();
    }

    function makeUneditable() {
        var cells = document.querySelectorAll("td[data-field-name='max_stock_level'], td[data-field-name='buffer_stock_level'], td[data-field-name='reorder_level'], td[data-field-name='lead_time']");
        for (var i = 0; i < cells.length; i++) {
            cells[i].setAttribute("contenteditable", "false");
            cells[i].classList.remove("editable");
        }
    }

    function updateInventory() {
        // Collect data from editable cells
        var cells = document.querySelectorAll(".editable");
        var data = [];
        for (var i = 0; i < cells.length; i++) {
            var row = cells[i].parentNode;
            var itemid = row.getAttribute("data-item-id");
            var fieldName = cells[i].getAttribute("data-field-name");
            var newValue = cells[i].innerHTML;
            if (cells[i].hasAttribute('data-changed')) {
                data.push({
                    itemid: itemid,
                    fieldName: fieldName,
                    newValue: newValue
                });
            }
        }

        makeUneditable();


        // Send data to server

        let fetchRes = fetch(
            "<?= ROOT ?>/admin/inventory/updateMain", {
                method: "POST",
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            });

        fetchRes.then(res => res.json())
            .catch(err => {
                console.log(err)
            })

    }

</script>