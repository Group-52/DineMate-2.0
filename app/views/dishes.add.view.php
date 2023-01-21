<html <!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <style>
        input {
            padding: 15px;
            margin: 10px;
            display: block;
        }

        form {
            margin: 50px;
            padding: 50px;
        }

        h1 {
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
<h1>
    Add a Dish
</h1>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name">
    <input type="number" name="preptime" placeholder="Preparation Time">
    <input type="number" name="netprice" placeholder="Net Price">
    <input type="number" name="sellprice" placeholder="Selling Price">
    <input type="text" name="description" placeholder="Description">

    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">

    <input type="submit" name="submit" value="Save">
</form>

</body>
</html>


</body>
</html>