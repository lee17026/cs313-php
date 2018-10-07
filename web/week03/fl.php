<?php
session_start();
if(isset($_POST['add'])){ 
  $_SESSION["Fluorspar"] = 2.34;
}    
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
          <a class="nav-link" href="prove03store.php">Main Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Cart</a>
        </li>
      </ul>
    </nav>
    
    <!-- Single Item -->
    <div class="item">
      <div class="row">
        <div class="col-sm-6">
          <img src="fluorspar.png" alt="fluorspar">
        </div>
        <div class="col-sm-6">
          <h3>Fluorspar</h3>
          <hr/>
          <p>Hey hey, it's ya boy calcium fluorite! Hold on, I'm sorry, it's actually calcium fluoride. I guess that's why I failed Geology 101.</p>
          <br/>
          <p><span class="price">Price: </span>$2.34</p>
          <form action="fl.php" method="post">
            <input type="submit" value="Add to Cart" name="add">
          </form>
          <?php
                if(isset($_POST['add'])){ 
                  echo "ADDED TO CART";
}
                ?>
        </div>
      </div> 
    
    </div>
    
    </body>
</html>