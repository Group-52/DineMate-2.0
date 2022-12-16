<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
        <title>Add Vendor</title>
    </head>

    <style>
        input[type=text], input[type=number], input[type=date] {
            width: 50%;
            padding: 20px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            height:5%
        }

        button {
            background-color:green;
            color: white;
            padding: 10px 10px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 10%;
            float: right;
            text-decoration: none;

        }
    </style>

    <body>
        <h2>Vendors> New Vendor</h2>
        <form action = "" method = "POST"> 
            <div class="row">
                <div class="col">
                    <label for="name"><b>Name</b></label><br>
                    <input type = "text" name = "name" placeholder = "Name" required>
                </div>

                <div class="col">
                    <label for="address"><b>Address</b></label><br>
                    <input type = "text" name = "address" placeholder = "Address" required>
                </div>

                <div class="col">
                    <label for="company"><b>Company</b></label><br>
                    <input type = "text" name = "company" placeholder = "Company">
                </div>

                <div class="col">
                    <label for="contact_no"><b>Contact No</b></label><br>
                    <input type = "number" name = "contact_no" placeholder = "Contact No">
                </div>

                <button type="submit" name="save"><a class="link" href="<?= ROOT ?>/vendors">Save</a></button>
            </div>
        </form>
    </body>
</html>