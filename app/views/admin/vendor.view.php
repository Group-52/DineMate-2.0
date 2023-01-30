<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vendors Details</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
    <!-- <style>
        .table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #ddd;
        }

        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            color: black;
        }

        button {
            background-color: #FF4546;
            color: white;
            padding: 10px 10px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 10%;
            float: right;
            text-decoration: none;

        }

        img {
            width: 100px;
            height: 100px;
            background: #FF4546;
        }
    </style> -->

</head>

<body>
<h2>Vendors</h2>

<table class="table">
    <thead class="table-dark">
    <tr>
        <th scope="col">VendorID</th>
        <th scope="col">Name</th>
        <th scope="col">Address</th>
        <th scope="col">Company</th>
        <th scope="col">Contact No</th>
    </tr>
    </thead>

    <tbody>
    <?php if (isset($Vendor)) {
        foreach ($Vendor as $v1) {
            echo "<tr>";
            echo "<td>" . $v1->vendor_id . "</td>";
            echo "<td>" . $v1->vendor_name . "</td>";
            echo "<td>" . $v1->address . "</td>";
            echo "<td>" . $v1->company . "</td>";
            echo "<td>" . $v1->contact_no . "</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>
<br>
<button type="submit" name="add"><a href="<?= ROOT ?>/admin/vendors/addVendor">+ NEW VENDOR</a></button>
<br>
<a href="<?= ROOT ?>/admin/auth/logout">Logout</a>
</body>

</html>
