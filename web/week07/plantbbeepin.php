<?php
// includes the file
require_once "session_functions.php";

// redirect if already signed in
if (is_loggedin()) {
  header('Location: plantbcontrolroom.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Plant B Beep In</title>
    <meta charset="UTF-8"/>
    <meta name="description" content="Main control interface for Plant B.">      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css" />
  </head>
  
  <body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../assignments.php">Assignments</a>
        </li>
      </ul>
    </nav>
    
    <!-- Welcome and Instructions -->
    <div class="container">
      <h1 class="text-center">Welcome to the Plant B Control Room!</h1>
      <p class="text-center">Please beep in.</p>
    </div>
    <br />
	
	<!-- Form -->
	<form class="form-horizontal" action="<?=$filename?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-8" for="username">Username:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="username" id="username" maxlength="64" autofocus>
        </div>
      </div>
	  <div class="form-group">
        <label class="control-label col-sm-8" for="password">Password:</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="password" id="password" maxlength="64">
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Log In</button>
        </div>
      </div>
    </form>
	
	<!-- Form Action -->
	<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // strip and prepare variables
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      
      // connect to our db
      $db = get_db();
      
      // query this user
      $stmt_check_user = $db->prepare('SELECT * FROM operator WHERE username = :username');
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
        header('Location: plantbbeepin.php');
        die();
      }
      
      // get the hashed password for that user
      $stored_hash = $returned[0]['password'];
      
      // verify the password
      if (password_verify($password, $stored_hash)) { // log in success!
        // store info in session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['operator_id'] = $returned[0]['id'];
        $_SESSION['first_name'] = $returned[0]['first_name'];
        $_SESSION['last_name'] = $returned[0]['last_name'];
        $_SESSION['role'] = $returned[0]['role'];
        
        // redirect to main page
        header('Location: plantbcontrolroom.php');
        die();
      } else { // password did not match
        // redirect 
        header('Location: plantbbeepin.php');
        die();
      }
    }
    ?>
    
  </body>
  
</html>