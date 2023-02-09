<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin</title>
  <script src="<?= ASSETS ?>/js/admin/dashboard.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <?php include VIEWS . "/partials/admin/head.partial.php" ?>
  <style>
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 400px;
      height: 270px;
      margin: 10px;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .container {
      padding: 2px 16px;
    }

    .card img {
      object-fit: cover;
      width: 100%;
      height: 200px;
      border-radius: 10px;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: left;
      max-width: 1200px;
    }

    .table-in-card {
      margin: 10px;
      padding: 0 10px 10px 10px;
    }
    .card-title{
      padding: 5px;
    }

    .card h3 {
      text-align: center;
    }
    .btn {
      /* make left margin 10px and bottom negative 5 */
      margin: 10px 0 0 10px;
    }

  </style>
</head>

<body class="dashboard">
  <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
  <div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
      <div class="dashboard-header">

        <h1 class="display-3 active">Dashboard</h1>
      </div>
      <div class="card-container">


        <div class="card">
        <h3 class="card-title">Order Frequency</h3>
          <canvas id="myBarChart" width="1600" height="900"></canvas>
        </div>
        <div class="card">
          <h3 class="card-title">Customers</h3>
          <canvas id="myLineChart" width="1600" height="900"></canvas>
        </div>
        <div class="card">
        <h3 class="card-title">Best Selling Dishes</h3>
          <canvas id="myPieChart" width="1600" height="900"></canvas>
        </div>

        <div class="card">
        <h3 class="card-title">Finances</h3>
          <canvas id="myStackedLineChart" width="1600" height="900"></canvas>
        </div>

        <div class="card">
        <h3 class="card-title">Expiry Risk</h3>
          <div class="table-in-card">
            <table class="table">
              <thead>
                <tr>
                  <th>Item Name</th>
                  <th>Amount Remaining</th>
                  <th>Expiry Date</th>
                </tr>
              </thead>
              <tbody id="expiry-risk-items">
                <?php foreach ($data['expiringitems'] as $item) : ?>
                  <tr>
                    <td><?= $item->item_name ?></td>
                    <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                    <td><?= $item->expiry_date ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <a href="<?= ROOT ?>/admin/inventory/info" class="btn btn-primary">View More</a>
        </div>

        <div class="card">
        <h3 class="card-title">Low Stock</h3>
          <div class="table-in-card">
            <table class="table">
              <thead>
                <tr>
                  <th>Item Name</th>
                  <th>Amount Remaining</th>
                </tr>
              </thead>
              <tbody id="low-stock-items">
                <?php foreach ($data['lowstockitems'] as $item) : ?>
                  <tr>
                    <td><?= $item->item_name ?></td>
                    <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <a href="<?= ROOT ?>/admin/inventory" class="btn btn-primary">View More</a>
      </div>
    </div>
  </div>



</body>


</html>