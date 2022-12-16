<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>viewOrders</title>
</head>

<body>

<?php if (isset($order)): ?>
    <h1>Order #<?= $order->order_id ?></h1>
    <form method="POST">
        <label>Order ID</label> <br>
        <input type="text" name="order_id" value="<?= $order->order_id ?>" readonly><br>
        <label>Guest ID</label> <br>
        <input type="text" name="reg_customer_id" value="<?= $order->reg_customer_id ?? $guest_id ?? "" ?>"
               readonly><br>
        <label>Request</label> <br>
        <input type="text" name="request" value="<?= $order->request ?>"><br>
        <label>Quantity</label> <br>
        <input type="number" name="quantity" value="<?= $order->quantity ?>"><br>
        <label>Time Placed</label> <br>
        <input type="datetime-local" name="time_placed" value="<?= $order->time_placed ?>"><br>

        <label>Type</label> <br>
        <?php
        $order_types = ["Dine-In", "Takeaway"];
        ?>
        <select name="type">
            <?php foreach ($order_types as $type): ?>
                <option value="<?= $type ?>" <?= $type == $order->type ? "selected" : "" ?>><?= $type ?></option>
            <?php endforeach; ?>
        </select> <br>

        <label>Status</label> <br>
        <?php
        $statuses = ["Pending", "Accepted", "Cancelled", "Completed"];
        ?>
        <select name="status">
            <?php foreach ($statuses as $status): ?>
                <option value="<?= $status ?>" <?= $status == $order->status ? "selected" : "" ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select> <br>

        <label>Scheduled Time</label> <br>
        <input type="datetime-local" name="scheduled_time" value="<?= $order->scheduled_time ?>"><br>
        <label>Table ID</label> <br>
        <input type="text" name="table_id" value="<?= $order->table_id ?>"><br>
        <button>Update</button>
    </form>

<?php else: ?>
    <h1>Order not found</h1>
<?php endif; ?>


</body>
</div>
</html>

<style>

</style>