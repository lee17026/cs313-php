<!DOCTYPE html>
<html>
    
  <head>
    <meta charset="utf-8">
    <title>Tim Lee's CS 313 Homepage</title>
    <meta name="description" content="The main hub for CS 313 assignments.">      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
  </head>
    
  <body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="assignments.php">Assignments</a>
      </ul>
    </nav>
      
    <!-- Jumbo! -->
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1>Lobsters</h1>
      </div>
    </div>
    
    <div>
      <p>Please use <kbd>ctrl + f</kbd> to find your favorite lobster.</p>
        
 <div id="accordion">

  <div class="card">
    <div class="card-header">
      <a class="card-link" data-toggle="collapse" href="#collapseOne">
        Blue Lobsters
      </a>
    </div>
    <div id="collapseOne" class="collapse" data-parent="#accordion">
      <div class="card-body">
         <img src="blue.jpg" class="img-rounded" alt="Blue Lobster"> 
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
        Magic Lobsters
      </a>
    </div>
    <div id="collapseTwo" class="collapse" data-parent="#accordion">
      <div class="card-body">
         <img src="magic.jpg" class="img-rounded" alt="Magic Lobster"> 
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
        Advanced Lobsters
      </a>
    </div>
    <div id="collapseThree" class="collapse" data-parent="#accordion">
      <div class="card-body">
         <img src="advanced.jpg" class="img-rounded" alt="Advanced Lobster"> 
      </div>
    </div>
  </div>

</div> 
<br>
    <p class="end_note">
<?php
echo "Today is " . date("Y/m/d") . "<br>";

// calculate days until lobster day
$date = strtotime("June 15, 2019 2:00 PM");
$remaining = $date - time();
$days_remaining = floor($remaining / 86400);
echo "There are $days_remaining days until Lobster Day on June 15.<br>";
?> 
    </p>
        
    </div>

  </body>
</html>
