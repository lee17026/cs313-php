<?php
session_start();
if(isset($_POST['reset'])){ 
  session_unset(); 
} 

$minerals = array("Black_Tourmaline", "Blue_Agate", "Fluorspar", "Muscovite", "Olivine", "Topaz");

// removes items from the cart
foreach ($minerals as $value) {
  if (isset($_POST[$value])) {
    unset($_SESSION[$value]);
  }
}

?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Cart</title>
    <meta charset="UTF-8"/>
    <meta name="description" content="Cart">      
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
          <a class="nav-link" href="#">Cart</a>
        </li>
      </ul>
    </nav>
    
    <!-- Display -->
    <div class="cart">
      <h2>Items in Cart</h2>
      <?php
      if (!empty($_SESSION)) {
        foreach ($_SESSION as $key => $value) {
          echo $key;
          echo "<form action='cart.php' method='post'><input type='submit' value='Remove $key from Cart' name='$key' class='btn btn-warning'></form>";
          echo "<br />";
        }
      } else { // there is nothing in the cart
        echo "The cart is currently empty. Please fill it with rocks!";
      }
      ?>
    </div>
    
    <div class="controls">
      <a class="btn btn-primary" href="prove03store.php" role="button">Continue Browsing Store</a> 
      <br />
      <br />
      <form action="cart.php" method="post">
        <input type="submit" value="Clear Cart" name="reset" class="btn btn-primary">
      </form>
      <br />
      <form action="checkout.php" method="post">
        <input type="submit" value="Checkout" class="btn btn-primary">
      </form>
    </div>
    
    
    
    </body>
</html>