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
                <h1 class="display-3">Paid History</h1>
            </div>
            
            <br>
            <div id="order-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Id</th>
                            <th>Request</th>
                            <th>Type</th>
                            <th>Total</th>
                            
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
            echo "<td>".$total = $_SESSION["total"]."</td>";
            echo "</tr>";
             }
         }
        }
    ?>
              </tr>      
         </tbody>
     </table>
 </div> 

 





