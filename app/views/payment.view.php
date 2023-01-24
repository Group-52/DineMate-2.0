<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
<div class="container">
    <h1>Payment</h1>
    
    <h3>Order ID: #<?=  $order->order_id  ?></h3>
<h3>Customer ID: #<?= $order->reg_customer_id ?? $order->guest_id ?></h3>

    <h2>order Details</h2>

   
    <table>

    <tr>
        <th>Orders  </th>    
        <th>Quantity  </th>
        <th>Unit Price  </th>
        <th>Total  </th>
    </tr>


    <?php
    if (isset($dishes) && isset($order_list)){
      foreach ($dishes as $d1) {
        foreach ($order_list as $order) {
          echo "<tr>
                  <td>$d1->dish_name</td>
                  <td>$order->quantity</td>
                  <td>$d1->selling_price</td>
                  <td>$d1->selling_price * $order->quantity</td>
                </tr>";
        }
      }
    }
  ?>


</table>
                  
                </div>
             
            </form>
        </div>

<form action="" method="post">
  <h3>card payment</h3>
  <label>Card Number: <input type="text" id="credit_card_number" name="credit_card_number" placeholder="Enter card number"></label><br>
  <label>Expiration Date: <input type="text" id="expiration_date" name="expiration_date" placeholder="Enter expiration date"></label><br>
  <label>CVV: <input type="text" id="cvv" name="cvv" placeholder="Enter CVV"></label><br>
  <label>Amount: <input type="number" id="amount" name="amount" placeholder="Enter amount"></label><br>
  <button type="submit">Pay</button>

  <h3>cash payment</h3>
  <label>Total Amount: <input type="text" id="credit_card_number" name="credit_card_number" placeholder="Enter card number"></label><br>
  <label>Cash: <input type="text" id="expiration_date" name="expiration_date" placeholder="Enter expiration date"></label><br>
  <label>Change: <input type="text" id="cvv" name="cvv" placeholder="Enter CVV"></label><br>
  <button type="submit">Pay</button>
</form>       

</body>
</html>