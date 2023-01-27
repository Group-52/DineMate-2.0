<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>viewOrders</title>
</head>

<body>

<?php if (isset($order)): ?>
    <h2>Order #<?= $order->order_id ?></h2>
    <form method="POST">
        <label>Order ID</label> 
        <input type="text" name="order_id" value="<?= $order->order_id ?>" readonly><br>
        <br><label>Guest ID</label> 
        <input type="text" name="reg_customer_id" value="<?= $order->reg_customer_id ?? $guest_id ?? "" ?>"
               readonly><br>
       <br> <label>Request</label> 
        <input type="text" name="request" value="<?= $order->request ?>"><br>
       <br> <label>Quantity</label>
        <input type="number" name="quantity" value="<?= $order->quantity ?>"><br>
        <br><label>Time Placed</label> 
        <input type="datetime-local" name="time_placed" value="<?= $order->time_placed ?>"><br>

        <br><label>Type</label> 
        <?php
        $order_types = ["Dine-In", "Takeaway"];
        ?>
        <select name="type">
            <?php foreach ($order_types as $type): ?>
                <option value="<?= $type ?>" <?= $type == $order->type ? "selected" : "" ?>><?= $type ?></option>
            <?php endforeach; ?>
        </select> <br>

       <br> <label>Status</label>
        <?php
        $statuses = ["Pending", "Accepted", "Cancelled", "Completed"];
        ?>
        <select name="status">
            <?php foreach ($statuses as $status): ?>
                <option value="<?= $status ?>" <?= $status == $order->status ? "selected" : "" ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select> <br>

       <br> <label>Scheduled Time</label> 
        <input type="datetime-local" name="scheduled_time" value="<?= $order->scheduled_time ?>"><br>
       <br> <label>Table ID</label> 
        <input type="text" name="table_id" value="<?= $order->table_id ?>"><br>
        <button>Update</button>
    </form>

<?php else: ?>
    <h1>Order not found</h1>
<?php endif; ?>


</body>
</div>
</html>
<?php include "partials/dashboard.footer.php" ?>

<style>
body {
  font-family: Arial, sans-serif;
}

form {
  width: 500px;
  margin: 0 auto;
  padding: 20px;
  border: none;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
  color: #588c7e;
}

input[type="text"], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #588c7e;
  border-radius: 4px;
}

input[type="number"] {
  width: 30%;
}

input[type="datetime-local"] {
  width: 100%;
}

button {
  width: 50%;
  background-color:#588c7e;
  color: white;
  padding: 15px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
 
}

button:hover {
  background-color: #c0392b;
}



</style>