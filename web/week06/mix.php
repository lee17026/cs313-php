<?php
// set up $filename
$filename=$_SERVER["PHP_SELF"];
// connect
require 'dbConnect.php';
$db = get_db();
// set up recipes and silo arrays for our dropdown selection menu
$recipes = array();
foreach ($db->query("SELECT id, recipe_code, recipe_name, sugar_amount FROM recipe ORDER BY recipe_code") as $row) {
	$recipes[] = $row;
}
$silo = array();
foreach ($db->query("SELECT id, silo_number, amount FROM sugar_silo ORDER BY id") as $row) {
	$silo[] = $row;
}
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
            <option value="<?=$row['id']?>"><?="Silo " . $row['silo_number'] . ' - ' . number_format($row['amount'], 0, '', ',') . " lbs of sugar"?></option>
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
    
    <!-- Form Handling -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <?php
	// get the id of the recipe
    $recipeID = (int)$_POST['recipe_code'];
	
	// get the silo id and silo number
    $siloID = (int)$_POST['silo_code'];
    $siloNumber = "1" . (string)$siloID;
    
	// hunt for the required amount and available amount
    $requiredAmount = 0;
	$huntIndex = 0;
	foreach ($recipes as $row) {
		if ($recipeID == $row['id']) {
			$requiredAmount = (int)$row['sugar_amount'];
			break;
		}
		$huntIndex++;
	}
	$requiredAmountCONST = $requiredAmount;
	
	// get available amount in silo
    $availableAmountInSilo = 0;
	foreach ($silo as $row) {
		if ($siloID == $row['id']) {
			$availableAmountInSilo = (int)$row['amount'];
			break;
		}
	}
	
    // first make sure there is enough sugar in that silo
    if ($availableAmountInSilo >= $requiredAmount) {
      echo number_format($availableAmountInSilo, 0, '', ',') . " lbs in the silo and we need " . number_format($requiredAmount, 0, '', ',') . " lbs.<br/>";
      
      // find out which batch code we will be using by slecting the oldest 
      //    batch id and amount where silo ID matches and amount is positive
	  $shipments = array();
	  $statement = $db->prepare('SELECT id, batch_code, amount FROM sugar_shipment WHERE amount > 0 AND location = :siloID ORDER BY creation_date ASC');
	  $statement->bindValue(':siloID', $siloID);
	  $statement->execute();
	  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		  $shipments[] = $row;
	  }
      $batchID = $shipments[0]["id"];
      $availableAmountInBatch = $shipments[0]["amount"];
      $sugarBatchCode = $shipments[0]["batch_code"];
      
      // make sure there's enough sugar in this batch code
      if ($availableAmountInBatch < $requiredAmount) {
		// this means we are going to deplete a batch of sugar, so start 
		//    tracking the next one too
        $batchID2 = $shipments[1]["id"];
        $availableAmountInBatch2 = $shipments[1]["amount"];
        $sugarBatchCode2 = $shipments[1]["batch_code"];
        echo "There wasn't enough sugar in batch $sugarBatchCode so we're going to use the next one too, which is batch $sugarBatchCode2.<br/>";
        
        // deplete the sugar in the first batch, $requiredAmount now equals the amount still needed
        $requiredAmount -= $availableAmountInBatch;
		$statement = $db->prepare('UPDATE sugar_shipment SET amount = 0 WHERE id = :batchID');
		$statement->bindValue(':batchID', $batchID);
		$statement->execute();
        //$db->query("UPDATE sugar_shipment SET amount = 0 WHERE id = $batchID");
        
        // set this new sugar batch as the one we want to use
        $batchID = $batchID2;
        $availableAmountInBatch = $availableAmountInBatch2;
        $sugarBatchCode = $sugarBatchCode2;
      } // end of not enough sugar in this one batch
      
      // update the main sugar batch code
      $statement = $db->prepare('UPDATE sugar_shipment SET amount = amount - :requiredAmount WHERE id = :batchID');
	  $statement->bindValue(':requiredAmount', $requiredAmount);
	  $statement->bindValue(':batchID', $batchID);
	  $statement->execute();
	  //$db->query("UPDATE sugar_shipment SET amount = amount - $requiredAmount WHERE id = $batchID");
      echo "Subtracting sugar from batch $sugarBatchCode.  .  .  .  .  .  Done!<br/>";
      
      // mix this batch
	  $statement = $db->prepare('INSERT INTO batch (recipe, sugar_batch, created_by, last_updated_by) VALUES (:recipeID, :batchID, 1, 1)');
	  $statement->bindValue(':recipeID', $recipeID);
	  $statement->bindValue(':batchID', $batchID);
	  $statement->execute();
      //$db->query("INSERT INTO batch (recipe, sugar_batch, created_by, last_updated_by) VALUES ($recipeID, $batchID, 1, 1)");
      // KEEP THE ID
	  $newlyMixedBatchID = $db->lastInsertId('batch_id_seq');
      echo "Mixing this batch.  .  .  .  .  .  Done!<br/>";
      
      // update the silo
	  $statement = $db->prepare('UPDATE sugar_silo SET amount = amount - :requiredAmountCONST WHERE id = :siloID');
	  $statement->bindValue(':requiredAmountCONST', $requiredAmountCONST);
	  $statement->bindValue(':siloID', $siloID);
	  $statement->execute();
      //$db->query("UPDATE sugar_silo SET amount = amount - $requiredAmountCONST WHERE id = $siloID");
      echo "Updating silo $siloNumber.  .  .  .  .  .  Done!<br/>";
      
      echo "The batch was succesfully mixed! It has an id of $newlyMixedBatchID and uses sugar batch $sugarBatchCode. You can mix more batches or return to the Control Room.<br/>";
    } else {
      // there is not enough sugar in this silo!
      echo "Not enough sugar in silo $siloNumber! Try using a different silo. And if there's not enough in both silos, try yelling at Vincent.<br/>";
    }
    ?>
    <?php endif; ?>
    
  </body>
  
</html>