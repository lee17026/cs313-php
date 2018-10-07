<?php
session_start();
if(isset($_POST['add'])){ 
  $_SESSION["Olivine"] = 13.48;
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
          <img src="olivine.png" alt="olivine">
        </div>
        <div class="col-sm-6">
          <h3>Olivine</h3>
          <hr/>
          <p>This magnesium iron silicate comes from deep within the planet. It is one of the first minerals to form, requiring sustained heat and slow cooling. We bring it to you at a bargain. If we were to lower our price by a cent, the very earth would open up and swallow us whole.</p>
          <br/>
          <p><span class="price">Price: </span>$13.48</p>
          <form action="ol.php" method="post">
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