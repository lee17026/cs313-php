<?php
// includes the file
require_once "session_functions.php";

// redirect if already signed in
if (is_loggedin()) {
  header('Location: welcome.php');
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
    
    <h1>Sign Up Page</h1>
     <form action="<?=$filename?>" method="post">
       User name:<br />
       <input type="text" name="username"><br>
       Password:<br />
       <input type="password" name="password">
       <br /><br />
       <input type="submit" value="Sign Up">
       <input type="reset">
     </form> 
    
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // strip and prepare variables
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      
      // hash the password
      $password = password_hash($password, PASSWORD_DEFAULT);
      
      // connect to our db
      $db = get_db();
      
      // check if the username already exists
      //$stmt_check_username = $db->prepare('');
      
      // create this new row
      $stmt_insert_user = $db->prepare('INSERT INTO teach07_user (username, password) VALUES (:username, :password)');
      $stmt_insert_user->bindValue(':username', $username);
      $stmt_insert_user->bindValue(':password', $password);
      $stmt_insert_user->execute();
      
      // redirect to signin page
      header('Location: signin.php');
      die();
    }
    ?>
  </body>
  
</html>