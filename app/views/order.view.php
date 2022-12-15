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
              <option value="pending">pending</option>
            </select>
        </div><br>

        <table >
      
        <tr>
            <th >Order ID</th>
            <th >Customer_id</th>
            <th >Date</th>
            <th >Time</th>
            <th >Dish</th>
            <th >Type</th>
            <th >Status</th>
        </tr>
       

       
        <?php 
        foreach($orderlist as $order){
            echo "<tr>";
            echo "<td>".$order->order_id."</td>";
            echo "<td>".$order->customer_id."</td>";
            echo "<td>".$order->timePlaced."</td>";
            echo "<td>".$order->scheduledTime."</td>";
            echo "<td>".$order->request."</td>";
            echo "<td>".$order->type."</td>";
            echo "<td>".$order->status."</td>";
            //echo "<td>" .$row1['status']."<button id='btn' >pending</button></td>";
            // <script src='button.js'></script>
         
            echo "</tr>";
        }
        
        ?>
        
        </table>
        
        
        
           
        
        
</body>
</div>
</html>