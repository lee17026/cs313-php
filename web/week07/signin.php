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
    
    <h1>Sign In Page</h1>
     <form action="<?=$filename?>" method="post">
       User name:<br />
       <input type="text" name="username"><br>
       Password:<br />
       <input type="password" name="password">
       <br /><br />
       <input type="submit" value="Sign In">
       <input type="reset">
     </form> 
         
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // strip and prepare variables
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      
      // connect to our db
      $db = get_db();
      
      // query this user
      $stmt_check_user = $db->prepare('SELECT password FROM teach07_user WHERE username = :username');
      $stmt_check_user->bindValue(':username', $username);
      $stmt_check_user->execute();
      
      // prepare the returned query
      $returned = array();
      while ($row = $stmt_check_user->fetch(PDO::FETCH_ASSOC)) {
        $returned[] = $row;
      }
      
      // abort now if the username was not found
      if (!isset($returned[0]['password'])) {
        // redirect to signin page
        header('Location: signin.php');
        die();
      }
      
      // get the hashed password for that user
      $stored_hash = $returned[0]['password'];
      
      // verify the password
      if (password_verify($password, $stored_hash)) { // log in success!
        // store info in session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        // redirect to welcome page
        header('Location: welcome.php');
        die();
      } else { // password did not match
        // redirect 
        header('Location: signin.php');
        die();
      }
    }
    ?>
  </body>
  
</html>