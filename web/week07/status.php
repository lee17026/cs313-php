<?php
// includes the file
//   sets up $filename
require_once "session_functions.php";

// redirect if not signed in
if (!is_loggedin()) {
  header('Location: plantbbeepin.php');
  die();
}

// connect
$db = get_db();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Sugar Silo Status</title>
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
        <li class="nav-item">
          <a class="nav-link" href="logoutb.php">Log Out</a>
        </li>
      </ul>
    </nav>
    
    <!-- Welcome and Instructions -->
    <div class="container">
      <h1 class="text-center">Sugar Silo Status</h1>
      <p class="text-center"></p>
    </div>
    <br />
    
    <!-- Sugar Silo Table -->
    <div class="container">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Silo Number</th>
          <th>Amount of Sugar (lbs)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($db->query("SELECT silo_number, amount FROM public.sugar_silo ORDER BY id") as $row): ?>
        <tr>
          <td>Silo <?=$row['silo_number']?></td>
          <td><?=number_format($row['amount'], 0, '', ',')?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
    
  </body>
  
</html>