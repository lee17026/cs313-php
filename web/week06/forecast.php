<?php
// set up $filename
$filename=$_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Forecast Mixable Batches</title>
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
      <h1 class="text-center">Forecast Mixable Batches</h1>
      <p class="text-center">Please enter a 6 character recipe code to see how many batches can be mixed with currently available sugar.</p>
    </div>
    <br />
    
    <!-- Form -->
    <form class="form-horizontal" action="<?=$filename?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2" for="code">Recipe Code:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="code" id="code" placeholder="Example: 660002">
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Forecast</button>
        </div>
      </div>
    </form>
    
    <!-- Table -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <?php
	$recipe_code = htmlspecialchars($_POST['code']);
	
	require("dbConnect.php");
	$db = get_db();
	
	// get the sum
	$sum = 0;
	foreach ($db->query("SELECT amount FROM public.sugar_silo") as $row)
	{
		$sum += $row['amount'];
	}
	/* dummy data for testing
    $sum = 123456;
    $query = array
      (
      array("sugar_amount" => 5550)
      );
    $numMixable = (int)($sum / $query[0]["sugar_amount"]);
	*/
    ?>
    <div class="container">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Total Amount of Available Sugar (lbs)</th>
          <th>Amount of Sugar Required per Batch of <?=$recipe_code?> (lbs)</th>
          <th>Number of Mixable Batches of <?=$recipe_code?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($db->query("SELECT sugar_amount FROM public.recipe WHERE recipe_code = '$recipe_code'") as $row): ?>
        <tr>
          <td><?=$sum?></td>
          <td><?=$row['sugar_amount']?></td>
          <td><?=(int)($sum / $row['sugar_amount'])?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
    <?php endif; ?>

  </body>
  
</html>