<?php
// set up $filename
$filename=$_SERVER["PHP_SELF"];
// connect
require 'dbConnect.php';
$db = get_db();
// set up recipes and silo arrays
$recipes = array();
foreach ($db->query("SELECT id, recipe_code, recipe_name, sugar_amount FROM recipe ORDER BY recipe_code") as $row) {
	$recipes[] = $row;
}
$silo = array();
foreach ($db->query("SELECT id, silo_number, amount FROM sugar_silo") as $row) {
	$silo[] = $row;
}
var_dump($recipes);
echo "<br/>";
var_dump($silo);
echo "<br/>";
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Mix Batches</title>
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
      <h1 class="text-center">Mix Batches</h1>
      <p class="text-center">Please select a recipe code and silo number to mix.</p>
    </div>
    <br />
    
    <!-- Form -->
    <form class="form-horizontal" action="<?=$filename?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2" for="recipe_code">Select Recipe:</label>
        <div class="form-group">
          <select class="form-control" id="recipe_code" name="recipe_code">
            <?php foreach ($recipes as $row): ?>
            <option value="<?=$row['id']?>"><?=$row['recipe_code'] . ' - ' . $row['recipe_name']?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="silo_code">Select Silo:</label>
        <div class="form-group">
          <select class="form-control" id="silo_code" name="silo_code">
            <?php foreach ($silo as $row): ?>
            <option value="<?=$row['id']?>"><?="Silo " . $row['silo_number'] . ' - ' . $row['amount'] . "lbs of sugar"?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Mix</button>
        </div>
      </div>
    </form>
    
    

  </body>
  
</html>