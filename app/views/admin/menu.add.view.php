<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Menu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<h1>
    Menus> New Menu
</h1>
<input type="submit" name="submit" value="Save">

<form action="" method="POST">
    <div class="row">
        <div class="col">
            <label for="name"><b>Name</b></label><br>
            <input type="text" name="name" placeholder="Name" required>
        </div>

        <div class="col">
            <label for="description"><b>Description</b></label><br>
            <input type="text" name="description" placeholder="Description" required>
        </div>

        <div class="col">
            <label for="fromtime"><b>From Time</b></label><br>
            <input type="time" name="fromtime" placeholder="From Time">
        </div>

        <div class="col">
            <label for="totime"><b>To Time</b></label><br>
            <input type="time" name="totime" placeholder="To Time">
        </div>

        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">

    </div>
</form>
</body>
</html>