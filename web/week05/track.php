<?php
// set up $filename
$filename=$_SERVER["PHP_SELF"];
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
        <label class="control-label col-sm-2" for="code">Batch Code:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="code" id="code" placeholder="Example: 824184">
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
	
	try {
	$dbUrl = getenv('DATABASE_URL');
	
	$dbOpts = parse_url($dbUrl);
	
	$dbHost = $dbOpts["host"];
	$dbPort = $dbOpts["port"];
	$dbUser = $dbOpts["user"];
	$dbPassword = $dbOpts["pass"];
	$dbName = ltrim($dbOpts["path"],'/');
	
	$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $ex) {
	$msg = $ex->getMessage();
	echo "Error!: $msg";
	die();
	}
	/* dummy data for testing
    $query = array
      (
      array("id" => 2, "recipe_name" => "Hoisin", "recipe_code" => "720001", "creation_date" => "2018-10-19"),
      array("id" => 3, "recipe_name" => "Hoisin", "recipe_code" => "720001", "creation_date" => "2018-10-19"),
      array("id" => 4, "recipe_name" => "Panda OS", "recipe_code" => "660002", "creation_date" => "2018-10-19"),
      array("id" => 5, "recipe_name" => "Hoisin", "recipe_code" => "720001", "creation_date" => "2018-10-19"),
      );
	  */
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($db->query("SELECT b.id, r.recipe_name, r.recipe_code, b.creation_date FROM batch b INNER JOIN recipe r ON b.recipe = r.id INNER JOIN sugar_shipment s ON b.sugar_batch = s.id WHERE s.batch_code = '$sugar_batch'") as $row): ?>
        <tr>
          <td><?=$row['id']?></td>
          <td><?=$row['recipe_name']?></td>
          <td><?=$row['recipe_code']?></td>
          <td><?=$row['creation_date']?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
    <?php endif; ?>
    
  </body>
  
</html>