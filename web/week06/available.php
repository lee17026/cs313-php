<?php
/* dummy data for testing
$query = array
  (
  array("batch_code" => "824123", "amount" => 25000, "location" => 1),
  array("batch_code" => "824124", "amount" => 48000, "location" => 2)
  );
*/
require("dbConnect.php");
$db = get_db();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Sugar Batches</title>
    <meta charset="UTF-8"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css" />
  </head>
  
  <body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="plantbcontrolroom.php">Control Panel</a>
        </li>
      </ul>
    </nav>
    
    <!-- Welcome and Instructions -->
    <div class="container">
      <h1 class="text-center">Available Sugar Batches</h1>
      <p class="text-center"></p>
    </div>
    <br />
    
    <!-- Available Sugar Table -->
    <div class="container">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Batch Code</th>
          <th>Amount of Sugar Available (lbs)</th>
          <th>Silo Number</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($db->query("SELECT batch_code, amount, location FROM public.sugar_shipment") as $row): ?>
        <tr>
          <td><?=$row['batch_code']?></td>
          <td><?=$row['amount']?></td>
          <td>1<?=$row['location']?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>

    
  </body>
  
</html>