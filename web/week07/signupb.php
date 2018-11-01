<?php
// includes the file
require_once "session_functions.php";
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>CS 313 Team Activity Week 07</title>
    <meta charset="UTF-8"/>
  </head>
  
  <body>
    
    <h1>Sign Up Page</h1>
     <form action="<?=$filename?>" method="post">
       User name:<br />
       <input type="text" name="username"><br />
       Password:<br />
       <input type="password" name="password"><br />
       First name:<br />
       <input type="text" name="first_name"><br />
       Last name:<br />
       <input type="text" name="last_name"><br />
       Role:<br />
       <input type="text" name="role"><br />
       <br /><br />
       <input type="submit" value="Sign Up">
       <input type="reset">
     </form> 
    
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // strip and prepare variables
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      $first_name = htmlspecialchars($_POST['first_name']);
      $last_name = htmlspecialchars($_POST['last_name']);
      $role = htmlspecialchars($_POST['role']);
      
      // hash the password
      $password = password_hash($password, PASSWORD_DEFAULT);
      
      // connect to our db
      $db = get_db();
      
      // check if the username already exists
      //$stmt_check_username = $db->prepare('');
      
      // create this new row
      $stmt_insert_user = $db->prepare('INSERT INTO operator (username, password, first_name, last_name, role) VALUES (:username, :password, :first_name, :last_name, :role)');
      $stmt_insert_user->bindValue(':username', $username);
      $stmt_insert_user->bindValue(':password', $password);
      $stmt_insert_user->bindValue(':first_name', $first_name);
      $stmt_insert_user->bindValue(':last_name', $last_name);
      $stmt_insert_user->bindValue(':role', $role);
      $stmt_insert_user->execute();
      
      // announce success
	  echo "Added $first_name $last_name as a $role under the username $username <br/>";
    }
    ?>
  </body>
  
</html>