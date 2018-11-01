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
        <li class="nav-item">
          <a class="nav-link" href="logoutb.php">Log Out</a>
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
          <input type="text" class="form-control" name="code" id="code" maxlength="6" placeholder="Example: 660002">
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
	
	$db = get_db();
	
	// get the sugar amount and name for the specified recipe code
	$statement = $db->prepare('SELECT sugar_amount, recipe_name FROM public.recipe WHERE recipe_code = :recipe_code');
	$statement->bindValue(':recipe_code', $recipe_code);
	$statement->execute();
	$query = $statement->fetch(PDO::FETCH_ASSOC);
	$sugarAmount = $query['sugar_amount'];
	$recipeName = $query['recipe_name'];

	// get the sum
	$sum = 0;
	foreach ($db->query("SELECT amount FROM public.sugar_silo") as $row)
	{
		$sum += $row['amount'];
	}

    ?>
    <div class="container">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Total Amount of Available Sugar (lbs)</th>
          <th>Amount of Sugar Required per Batch of <?=$recipe_code?> - <?=$recipeName?> (lbs)</th>
          <th>Number of Mixable Batches of <?=$recipe_code?> - <?=$recipeName?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=number_format($sum, 0, '', ',')?></td>
          <td><?=number_format($sugarAmount, 0, '', ',')?></td>
          <td><?=(int)($sum / $sugarAmount)?></td>
        </tr>
      </tbody>
      </table>
    </div>
    <?php endif; ?>

  </body>
  
</html>