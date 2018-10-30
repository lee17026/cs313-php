<?php
// just log out by destroying the session
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>CS 313 Team Activity Week 07</title>
    <meta charset="UTF-8"/>
  </head>
  
  <body>
    <div>
      <a href="signup.php">Go to Sign Up Page</a>
      <br />
      <a href="signin.php">Go to Sign In Page</a>
      <br />
      <a href="welcome.php">Go to Welcome Page</a>
      <br />
      <a href="logout.php">Logout</a>
    </div>
    
    <h1>Logout Page</h1>
    <p>Logged out.</p>
     
  </body>
  
</html>