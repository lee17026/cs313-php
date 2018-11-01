<?php
// just log out by destroying the session
session_start();
session_destroy();
header('Location: plantbbeepin.php');
die();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Plant B Log Out</title>
    <meta charset="UTF-8"/>
  </head>
  
  <body>
    <h1>Logout Page</h1>
    <p>Logged out.</p>
  </body>
  
</html>