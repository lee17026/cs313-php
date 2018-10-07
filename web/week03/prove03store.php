<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Rock Store</title>
    <meta charset="UTF-8"/>
    <meta name="description" content="Main storefront for rocks!">      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="prove03store.css">
  </head>
  
  <body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Main Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Cart</a>
        </li>
      </ul>
    </nav>
    
    <!-- Store Header -->
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1>Rocks</h1>
        <p>Minerals fresh from the belly of our planet, delivered straight to your doorstep! Our prices are as low as the dirt we found these gems in. Rocks, minerals, gems, whatever you call them, they are the perfect gift for the aspiring geologist or novice witch!</p>
      </div>
    </div>
    
    <!-- Items -->
    <div class="mainStore">
     <div class="row">
        <div class="col-sm-6">
          <a href="bt.php"><img src="blacktourmaline.png" class="img-rounded" alt="black tourmaline"></a>
          <h3 class="bottom-left">Black Tourmaline</h3>
        </div>
        <div class="col-sm-6">
          <a href="ba.php"><img src="blueagate.png" class="img-rounded" alt="blue agate"></a>
          <h3 class="bottom-left">Blue Agate</h3>
        </div>
      </div> 
     <div class="row">
       
        <div class="col-sm-6">
          <a href="fl.php"><img src="fluorspar.png" class="img-rounded" alt="fluorspar"></a>
          <h3 class="bottom-left">Fluorspar</h3>
        </div>
        <div class="col-sm-6">
          <a href="mu.php"><img src="muscovite.png" class="img-rounded" alt="muscovite"></a>
          <h3 class="bottom-left">Muscovite</h3>
        </div>
     </div> 
     <div class="row">
       
        <div class="col-sm-6">
          <a href="ol.php"><img src="olivine.png" class="img-rounded" alt="olivine"></a>
          <h3 class="bottom-left">Olivine</h3>
        </div>
        <div class="col-sm-6">
          <a href="to.php"><img src="topaz.png" class="img-rounded" alt="topaz"></a>
          <h3 class="bottom-left">Topaz</h3>
        </div>
     </div> 
    </div>
    <br/>
    <div class="note">
      This isn't a real store.
    </div>
    
  </body>
  
</html>