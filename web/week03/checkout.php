<?php
session_start();
$checkout = false;
if(isset($_POST['checkout'])){ 
  $checkout = true;
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
          <a class="nav-link" href="cart.php">Cart</a>
        </li>
      </ul>
    </nav>
    
    <!-- Checkout -->
    <div class="checkout">
      <?php
      if (!$checkout) {
        echo '
      <h2>Checkout</h2>
      <form action="checkout.php" method="post">
        Name: 
        <input type="text" name="name">
        <br/>
        Address:
        <input type="text" name="address">
        <br/>
        City:
        <input type="text" name="city">
        <br/>
        State:
        <input type="text" name="state">
        <br/>
        <input type="submit" name="checkout" value="Complete Purchase" class="btn btn-primary">
      </form>
      ';
        echo '<br/><br/> <a class="btn btn-primary" href="prove03store.php" role="button">Continue Browsing Store</a>';
        echo '<br/><br/> <a class="btn btn-primary" href="cart.php" role="button">Return to Cart</a>';
      } else {
        echo '<h3>Final Order Confirmation</h3>';
        $total = 0;
        foreach ($_SESSION as $key => $value) {
          echo "$key";
          echo "<br/>";
          $total += $value;
        }
        echo '<h3>Grand Total</h3>';
        echo "$ $total";
        echo "<h3>Ship To</h3>";
        $name = htmlspecialchars($_POST["name"]);
        $address = htmlspecialchars($_POST["address"]);
        $city = htmlspecialchars($_POST["city"]);
        $state = htmlspecialchars($_POST["state"]);
        echo $name . "<br/>" . $address . ", " . $city . " " . $state;
        session_unset(); 
      }
      
      ?>
    
    </div>
    </body>
</html>