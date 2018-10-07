<?php
session_start();
if(isset($_POST['add'])){ 
  $_SESSION["Topaz"] = 4.48;
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
          <a class="nav-link" href="../index.php">Home</a>
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
          <img src="topaz.png" alt="topaz">
        </div>
        <div class="col-sm-6">
          <h3>Topaz</h3>
          <hr/>
          <p>Many claim the mysterious topaz has ancient healing properties. The same people would believe the alignment of the planets affects their daily fate, so we can safely discard those thoughts. Buy my rock or I'll starve.</p>
          <br/>
          <p><span class="price">Price: </span>$4.48</p>
          <form action="to.php" method="post">
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