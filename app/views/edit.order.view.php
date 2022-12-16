<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>viewOrders</title>
</head>

<body>
   
    <form action="edit.order" method="POST">
  
        <label>Order ID</label> <br>
        <input type="text" name="order_id" value="<?=$order[0]->order_id ?>" readonly><br>
        <label>Guest ID</label> <br>
        <input type="text" name="guest_id" value="<?= $order[0]->reg_customer_id ?? $guest_id ?? "" ?>" readonly><br>
        <label>Request</label> <br>
        <input type="text" value="<?= $order[0]->request ?>"><br>
        <label>Qty</label> <br>
        <input type="text" value="<?= $order[0]->qty ?>"><br>
        <label>Time Placed</label> <br>
        <input type="date" value="<?= $order[0]->time_placed ?>"><br>
        <label>Type</label> <br>
        <input type="text" value="<?= $order[0]->type ?>"><br>
        <label>Status</label> <br>
        <input type="text" value="<?= $order[0]->status ?>"><br>
        <label>Scheduled Time</label> <br>
        <input type="date" value="<?= $order[0]->scheduled_time ?>"><br>
        <label>Table ID</label> <br>
        <input type="text" value="<?= $order[0]->table_id ?>">
     
    </form>  
    <!-- <?php
    show($order);
    ?> -->

        
</body>
</div>
</html>

<style>
    
</style>