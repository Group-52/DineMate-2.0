<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/orders.css">
    <script src="<?= ASSETS ?>/js/admin/orders.js"></script>
    <title>payments</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3 active">Payments</h1>
                <a class="btn btn-primary text-uppercase fw-bold"  href="<?php echo ROOT ?>/admin/payments/addOrder" id="add-order-button">+ Create Order</a>
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

                        <?php if (isset($order_list)) : ?>
                            <?php foreach ($order_list as $order) : ?>
                                <?php  if ($order->status == "completed") : ?>
                                <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>" >
                                    <td class="order-id-field"><?= $order->order_id ?></td>
                                    <td><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                    <td><?= $order->time_placed ?></td>
                                    <td><?= $order->scheduled_time ?>
                                        <?php if ($order->scheduled_time == null || $order->scheduled_time == "") :
                                            echo "-";
                                        endif; ?>

                                    </td>
                                    <td><?= substr($order->request, 0, 30);
                                        if (strlen($order->request) > 30) : echo "...";
                                        endif; ?></td>
                                    <td>
                                        <?php
                                        if ($order->type == "dine-in")
                                            echo "<img src='" . ASSETS . "/favicons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                                        else if ($order->type == "takeaway")
                                            echo "<img src='" . ASSETS . "/favicons/fastcart.png' alt='take-away' width='30' height='30'>";
                                        else if ($order->type == "bulk")
                                            echo "<img src='" . ASSETS . "/favicons/bulk.svg' alt='bulk' width='30' height='30'>";
                                        
                                            echo "<td><a class='edit-icon-link' href='".ROOT."/admin/payments/id/" . $order->order_id . "'><i class='fa fa-credit-card' aria-hidden='true' style='color: #dc3529;'  ></i></a></td>";
                                        ?>
                                    </td>       
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <!-- <a  class="btn btn-primary" id="paid-history-button" href="<?php echo ROOT ?>/admin/payments/paidHistory">view history</a>                               -->
            
           


            
            <div class="popup">
                
                <div class="popup-button-div">
                    <button class="btn btn-success" id="confirm">Yes</button>
                    <button class="btn btn-danger" id="cancel">No</button>
                </div>
            </div>
        </div>
</body>
</html>