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
    <h1>Inventory</h1>
    <button onclick="makeEditable()">Update Inventory</button>
    <table>
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Name</th>
                <th>Amount Remaining</th>
                <th> Expiry Risk</th>
                <th> Special Notes</th>
                <th>Last Used</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($inventory2)) : ?>
                <?php foreach ($inventory2 as $item) : ?>
                    <tr data-item-id="<?= $item->item_id ?>" data-purchase-id="<?= $item->pid ?>">
                        <td data-field-name="pid"><?= $item->pid ?></td>
                        <td data-field-name="item_name"><?= $item->item_name ?></td>
                        <td data-field-name="amount_remaining"><?= $item->amount_remaining ?></td>
                        <td data-field-name="expiryrisk"><?= $item->expiryrisk ?></td>
                        <td data-field-name="special_notes"><?= $item->special_notes ?></td>
                        <td data-field-name="last_used"><?= $item->last_used ?></td>
                        <td><i class="fa fa-trash" aria-hidden="true"></i></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <button id="update-button" onclick="updateInventory()">Update</button>
</body>
<a href="<?= ROOT ?>/admin/inventory">Back</a>

</html>

<?php include "partials/dashboard.footer.php" ?>



<script>
    function makeEditable() {
        var cells = document.querySelectorAll("td[data-field-name='amount_remaining'], td[data-field-name='special_notes'], td[data-field-name='expiryrisk']");
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
        var cells = document.querySelectorAll("td[data-field-name='amount_remaining'], td[data-field-name='special_notes'], td[data-field-name='expiryrisk']");
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
            var pid = row.getAttribute("data-purchase-id");
            var fieldName = cells[i].getAttribute("data-field-name");
            var newValue = cells[i].innerHTML;
            if (cells[i].hasAttribute('data-changed')) {
                data.push({
                    pid: pid,
                    fieldName: fieldName,
                    newValue: newValue
                });
            }
        }

        makeUneditable();


        // Send data to server

        let fetchRes = fetch(
            "<?= ROOT ?>/admin/inventory/updateInventory", {
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


    // Select all trash can icons
    const trashIcons = document.querySelectorAll(".fa-trash");

    // Attach click event listener to each trash can icon
    trashIcons.forEach(function(trashIcon) {
        trashIcon.addEventListener("click", function(event) {
            // Get the purchase ID from the parent tr element
            const purchaseId = this.parentNode.parentNode.getAttribute("data-purchase-id")

            // Use the fetch API to send a DELETE request to the server
            let fetchRes2 = fetch("<?= ROOT ?>/admin/inventory/deleteInventory", {
                method: 'POST',
                credentials: 'same-origin',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    purchaseId: purchaseId
                })
            })

            fetchRes2
                .then(res => res.json())
                .then(() => {
                    var tableRow = event.target.parentNode.parentNode;
                    tableRow.style.height = "0";
                    tableRow.classList.add("shrink");

                    setTimeout(function() {
                        tableRow.remove();
                    }, 300);
                })
                .catch(err => {
                    console.log(err)
                })
        });
    });
</script>