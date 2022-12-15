<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>viewOrders</title>
</head>

<body>
   
    <form method="POST">
    <?php show($order) ?>
        <input type="text" value="<?= $order->order_id ?>">
        <input type="text" value="<?= $order->reg_customer_id ?? $guest_id ?? "" ?>">
        <input type="text" value="<?= $order->request ?>">
        <input type="text" value="<?= $order->Qty ?>">
        <input type="date" value="<?= $order->time_placed ?>">
        <input type="text" value="<?= $order->type ?>">
        <input type="text" value="<?= $order->status ?>">
        <input type="date" value="<?= $order->scheduled_time ?>">
        <input type="text" value="<?= $order->table_id ?>">
        

        <select name="status">
            <option value="complete">completed</option>
            <option value="complete">confirmed</option>
            <option value="pending">pending</option>
        </select>
    </form>  
        
        
</body>
</div>
</html>