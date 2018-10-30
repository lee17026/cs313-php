<?php
// includes the file
require_once "session_functions.php";

// redirect if not logged in
if (!is_loggedin()) {
  header('Location: signin.php');
  die();
}

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
    
    <h1>Welcome Page</h1>
    <p>Hello <?=$_SESSION['username']?>, you made it to the welcome page.</p>
     
  </body>
  
</html>