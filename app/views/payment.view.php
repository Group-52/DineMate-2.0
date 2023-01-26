<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Payment</title>
   


    <style type="text/css">
       table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 15px;
            text-align: left;
        }
        th {
            background-color: #588c7e;
            color: white;
            padding: 10px;
            text-align: center;
        }
       
        .pay-cash {
          display: flex;
          background-color: #4CAF50; /* Green */
          color: white;
          padding: 12px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }

        .pay-card {
          display: flex;
          background-color: #4CAF50; /* Green */
          color: white;
          padding: 12px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
         .btn-container{
           position: absolute;
           bottom: 5px;
           right: 5px;
        }
       
    </style>
</head>


<body>
<div class="container">
    <h3  >Order ID: #<?=  $order->order_id  ?></h3>
    <h3  >Customer ID: #<?= $order->reg_customer_id ?? $order->guest_id ?></h3><br>
    <h3>order Details</h3>
</div>

    <table>
   <thead>

    <tr>
        <th>Orders  </th>    
        <th>Quantity  </th>
        <th>Unit Price  </th>
        <th>Total  </th>
       <th></th>

    </tr>
   </thead>


<tbody>

    <?php if (isset($orderDishes)) 
           foreach ($orderDishes as $orderDish) {
                echo '<tr>';
                echo '<td>' . $order_dish->dish_name . '</td>';
                echo '<td>' . $order_dish->quantity . '</td>';
                echo '<td>' . $order_dish->unit_price . '</td>';
                echo '<td>' . $order_dish->quantity * $order_dish->unit_price . '</td>';
                echo '</tr>';
           
           }
          
        ?>
        

       

</tbody>

</table>
                  
                </div>
             
            </form>
        </div>

  
        <div class="btn-container">
<button type="submit" class="pay-cash">Pay with Cach</button>
  <button type="submit" class="pay-card">Pay with Card</button>
        </div>
  


</form>       

</body>
</html>
<?php include "partials/dashboard.footer.php" ?>

