<?php
// includes the file
//   sets up $filename
require_once "session_functions.php";

// redirect if not signed in
if (!is_loggedin()) {
  header('Location: plantbbeepin.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Track Sugar Batches</title>
    <meta charset="UTF-8"/>
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
          <a class="nav-link" href="plantbcontrolroom.php">Control Panel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logoutb.php">Log Out</a>
        </li>
      </ul>
    </nav>
    
    <!-- Welcome and Instructions -->
    <div class="container">
      <h1 class="text-center">Track Sugar Batches</h1>
      <p class="text-center">Please enter a 6 character sugar batch code to track.</p>
    </div>
    <br />
    
    <!-- Form -->
    <form class="form-horizontal" action="<?=$filename?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-8" for="code">Batch Code:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="code" id="code" maxlength="6" placeholder="Example: 824184" autofocus>
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Track</button>
        </div>
      </div>
    </form>
    
    <!-- Table -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <?php
    $sugar_batch = htmlspecialchars($_POST['code']);
	$role = $_SESSION['role'];
	$isSupervisor = false;
	if ($role == 'Supervisor') {
		$isSupervisor = true;
	}
	
	$db = get_db();
	
	// prepare the query based on the sugar batch code
	$statement = $db->prepare('SELECT b.id, r.recipe_name, r.recipe_code, b.creation_date, o.first_name, o.last_name, o.role FROM batch b INNER JOIN recipe r ON b.recipe = r.id INNER JOIN sugar_shipment s ON b.sugar_batch = s.id JOIN operator o ON (o.id = b.last_updated_by) WHERE s.batch_code = :sugar_batch');
	$statement->bindValue(':sugar_batch', $sugar_batch);
	$statement->execute();
    ?>
    <div class="container">
      <h1>All Batches Mixed with Batch Code <?=$sugar_batch?></h1>
      <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Recipe Name</th>
          <th>Recipe Code</th>
          <th>Date Mixed</th>
		  <?php if ($isSupervisor): ?>
          <th>Mixed By</th>
		  <? endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
          <td><?=$row['id']?></td>
          <td><?=$row['recipe_name']?></td>
          <td><?=$row['recipe_code']?></td>
          <td><?=$row['creation_date']?></td>
		  <?php if ($isSupervisor): ?>
          <td><?=$row['role'] . " - " . $row['first_name'] . " " . $row['last_name']?></td>
		  <? endif; ?>
        </tr>
        <?php endwhile; ?>
      </tbody>
      </table>
    </div>
    <?php endif; ?>
    
  </body>
  
</html>