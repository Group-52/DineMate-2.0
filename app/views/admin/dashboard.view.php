<!DOCTYPE html>
<html lang="en">

<head>
  <title>World population</title>
  <script src="<?= ASSETS ?>/js/admin/dashboard.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <?php include VIEWS . "/partials/admin/head.partial.php" ?>
  <style>
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 400px;
      height: 250px;
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
  </style>
</head>

<body class="dashboard">
  <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
  <div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5 card-container">

      <div class="card">

        <canvas id="myBarChart" width="1600" height="900"></canvas>
      </div>
      <div class="card">

        <canvas id="myLineChart" width="1600" height="900"></canvas>
      </div>
      <div class="card">
        <canvas id="myPieChart" width="1600" height="900"></canvas>
      </div>


    </div>
  </div>


</body>


</html>