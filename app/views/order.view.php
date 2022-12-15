<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>viewOrders</title>
</head>

<body>

        <div>
            <input type="text" placeholder="Search..">
            <select placeholder="Filter">
              <option value="Dine-in">Dine-in</option>
              <option value="Take-away">Take-away</option>
              <option value="Bulk">Bulk</option>
            </select>

            <select aria-placeholder="status">
              <option value="complete">completed</option>
              <option value="complete">confirmed</option>
              <option value="pending">pending</option>
            </select>
        </div><br>

        <table >
      
        <tr>
            <th>Order ID</th>
            <th>Customer_id</th>
            <th>Time Placed</th>
            <th>Scheduled Time</th>
            <th>Request</th>
            <th>Qty</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
       

       
        <?php 
        foreach($orderlist as $order){
            echo "<tr>";
            echo "<td>".$order->order_id."</td>";
            echo "<td>".$order->reg_customer_id ?? $order->guest_id."</td>";
            echo "<td>".$order->time_placed."</td>";
            echo "<td>".$order->scheduled_time."</td>";
            echo "<td>".$order->request."</td>";
            echo "<td>".$order->qty."</td>";
            echo "<td>".$order->type."</td>";
            echo "<td>".$order->status."</td>";
            echo "<td><a href='orders/edit/".$order->order_id."'>Edit</a>";
            //echo "<td>" .$row1['status']."<button id='btn' >pending</button></td>";
            // <script src='button.js'></script>
         
            echo "</tr>";
        }
        
        ?>
        
        </table>
        
        
        
           
        
        
</body>
</div>
</html>