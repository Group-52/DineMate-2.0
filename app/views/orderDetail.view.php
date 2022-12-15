<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orderDetail</title>
</head>
<body>
    <div >

    <h1>Order>Order Details</h1></label><br>
   <label>Order ID: # <?php quary('SELECT order_id FROM orders') ?>
    

        <img height="200" width="200" src=""><br>
        
        <h1><?php ?></h1>
        <p>
            Type: <?php echo ($row1['type'])?><br>
            prep time: <?php echo ($row2['prep_time']) ?><br>
            pieces: <?php echo ($row1['dish_count'])?>
        </p>

        <button name="accept" style="background-color: green;" >Accept</button>
        <button name="cancel" style="background-color: red;" >Cancel</button>

        
        




    </div>
    
</body>
</html>