<!DOCTYPE html>


<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/orders.css">
    <script src="<?= ASSETS ?>/js/admin/orders.js"></script>
    <title>payment</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">
                <h1 class="display-3 active">Payment</h1>
            </div>
            <div>
            <div class="filter">
                    <div>
                        <select name="type" id="type" class="form-control">
                            <option value="all">Type</option>
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
                            <!-- <th>Status</th> -->
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
            echo "<td><a class='edit-icon-link' href='".ROOT."/admin/payments/id/" . $order->order_id . "'><i class='fa fa-cash-register money-icon' aria-hidden='true'></i></a></td>";
            echo "</tr>";
             }
         }
        }
    ?>
              </tr>
              
                         
         </tbody>

     </table>
 </div> 
      



  







    <script>
//    function filterOptions(value) {
//     // Get the select element
//     let select = document.getElementById("type");
//     // Remove all current options
//     select.innerHTML = "";
//     // Add the desired options back
//     switch (value) {
//       case "Dine-in":
//         select.innerHTML += '<option name="Dine-in" value="Dine-in">Dine-in</option>';
//         break;
//       case "Take-away":
//         select.innerHTML += '<option name="Take-away" value="Take-away">Take-away</option>';
//         break;
//       case "Bulk":
//         select.innerHTML += '<option  name="Bulk" value="Bulk">Bulk</option>';
//         break;
//     }
// }




//   let orders = [
//   { type: "Dine-in", name: "type" },
//   { type: "Take-away", name:  "type" },
//   { type: "Bulk", name:  "type" },
//   { type: "Dine-in", name:  "type" }
// ];

// function filterOptions(value) {
//   // Get the select element
//   let select = document.getElementById("type");
//   // Remove all current options
//   select.innerHTML = "";
//   // Filter the data based on the passed in value
//   let filteredOrders = orders.filter(order => order.type === value);
//   // Add the filtered data to the select element
//   filteredOrders.forEach(order => {
//     select.innerHTML += `<option value="${order.name}">${order.name}</option>`;
//   });
// }

// </script>
