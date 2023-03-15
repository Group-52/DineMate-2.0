<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/orders.css">
    <script src="<?= ASSETS ?>/js/admin/orders.js"></script>
    
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">Payment</h1>
                <a class="btn btn-primary text-uppercase fw-bold" href="payments/addOrder" id="add-order-button">+ Create Order</a>
            </div>
            <div>
            <div class="filter">
                    <div>
                        <select name="type" id="type" class="form-control">
                            <option value="all">All</option>
                            <option value="dine-in">Dine-in</option>
                            <option value="takeaway">Take-away</option>
                            <option value="bulk">Bulk</option>
                        </select>
                    </div>
</div>

  

                </div>
            <br>
            <div id="order-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Id</th>
                            <th>Time Placed</th>
                            <th>Scheduled Time</th>
                            <th>Request</th>
                            <th>Type</th>
                            
                        </tr>
                    </thead>
                    <tbody>

         <?php
         if (isset($order_list)) {
         foreach ($order_list as $order) {
             if ($order->status == "completed") {

             echo "<tr>";
             echo "<td>" . $order->order_id . "</td>";
             echo "<td>" . $order->reg_customer_id ?? $order->guest_id . "</td>";
             echo "<td>" . $order->time_placed . "</td>";
             echo "<td>" . $order->scheduled_time . "</td>";
             echo "<td>" . $order->request . "</td>";
             echo "<td>";
              if ($order->type == "dine-in") {
                echo "<img src='" . ASSETS . "/favicons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
              } else if ($order->type == "takeaway") {
                echo "<img src='" . ASSETS . "/favicons/fastcart.png' alt='take-away' width='30' height='30'>";
              } else if ($order->type == "bulk") {
                echo "<img src='" . ASSETS . "/favicons/bulk.svg' alt='bulk' width='30' height='30'>";
              }
            echo "</td>";
            echo "<td><a class='edit-icon-link' href='".ROOT."/admin/payments/id/" . $order->order_id . "'><i class='fa fa-credit-card' aria-hidden='true' style='color: #dc3529;'  ></i></a></td>";
           echo "<td></td>";
            echo "</tr>";
             }
         }
        }
    ?>
              </tr>      
         </tbody>
     </table>
 </div> 
 <a class="btn btn-primary" id="paid-history-button" href="<?php echo ROOT ?>/admin/payments/paidHistory">view history</a>
            <div id="dish-add-form" class="overlay">
 
<script class="payment">


 let typeFilter = document.getElementById("type");
  let rows = document.querySelectorAll("tbody tr");

  typeFilter.addEventListener("change", function () {

    let typeValue = this.value.toLowerCase();

    for (let i = 0; i < rows.length; i++) {
      let orderType = rows[i].getAttribute("data-order-type");
      console.log(`orderType: ${orderType}, typeValue: ${typeValue}`)
      if (typeValue === "all") {
        rows[i].style.display = "";
      } else if (orderType !== typeValue) {
        rows[i].style.display = "none";
      } else {
        rows[i].style.display = "";
      }
    }
  });



</script>



<div id="order-form" class="overlay">
        <form action="<?= ROOT ?>/admin/orders/addOrder" method="POST">
            
            <div class="form-group">
                <label class="label" for="name">id</label>
                <input class="form-control" type="text" name="order_id" id="order_id" required>
            </div>
            <div class="form-group">
                <label class="label" for="address">Address</label>
                <input class="form-control" type="text" name="guest_id" id="guest_id" required>
            </div>
            <div class="form-group">
                <label class="label" for="company">Company</label>
                <input class="form-control" type="text" name="Type" id="Type" required>
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" type="number" name="status" id="status" required>
            </div>
            <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save Vendor</button>
            <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
        </form>
    </div>