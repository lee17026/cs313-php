<?php
// includes the file
//   sets up $filename
require_once "session_functions.php";

// redirect if not signed in
if (!is_loggedin()) {
  header('Location: plantbbeepin.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Plant B Control Room</title>
    <meta charset="UTF-8"/>
    <meta name="description" content="Main control interface for Plant B.">      
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
          <a class="nav-link" href="#">Control Panel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logoutb.php">Log Out</a>
        </li>
      </ul>
    </nav>
    
    <!-- Welcome and Instructions -->
    <div class="container">
      <h1 class="text-center">Welcome to the Plant B Control Room!</h1>
      <p class="text-center">Please select one of the options below.</p>
    </div>
    <br />
    <div id="controls">
      <a href="mix.php" class="btn btn-primary btn-lg">Mix Batch</a> <br /><br />
      <a href="available.php" class="btn btn-primary btn-lg">View Available and Update Sugar Batches</a> <br /><br />
      <a href="status.php" class="btn btn-primary btn-lg">Sugar Silo Status</a> <br /><br />
      <a href="forecast.php" class="btn btn-primary btn-lg">Forecast Mixable Batches</a> <br /><br />
      <a href="track.php" class="btn btn-primary btn-lg">Track Sugar Batch</a>
    </div>
    
  </body>
  
</html>