<?php
// includes the file
//   sets up $filename
require_once "session_functions.php";

// redirect if not signed in
if (!is_loggedin()) {
  header('Location: plantbbeepin.php');
  die();
}

// connect
$db = get_db();
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Sugar Batches</title>
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
      <h1 class="text-center">View Available and Update Sugar Batches</h1>
      <p class="text-center">See available sugar batches (empty batches are not shown). Or add a new batch of sugar.</p>
    </div>
    <br />
    
    <!-- Available Sugar Table -->
    <div class="container">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Batch Code</th>
          <th>Amount of Sugar Available (lbs)</th>
          <th>Silo Number</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($db->query("SELECT batch_code, amount, location FROM public.sugar_shipment WHERE amount > 0 ORDER BY id") as $row): ?>
        <tr>
          <td><?=$row['batch_code']?></td>
          <td><?=number_format($row['amount'], 0, '', ',')?></td>
          <td>1<?=$row['location']?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
	
	<br/><br/>
    
    <!-- Enter New Shipment -->
    <form class="form-horizontal" action="<?=$filename?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2" for="code">New Batch Code:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="code" id="code" maxlength="6" placeholder="Example: 824184">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-5" for="amount">Amount of Sugar (lbs):</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="amount" id="amount" min="0" max = "50000" step="1" placeholder="Example: 49500">
        </div>
      </div>
      <label class="radio-inline col-sm-1">
        <input type="radio" name="siloNumber" value="1">Silo 11
      </label>
      <label class="radio-inline col-sm-1">
        <input type="radio" name="siloNumber" value="2">Silo 12
      </label>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Add New Batch of Sugar</button>
        </div>
      </div>
    </form>
    
    <!-- Add New Shipment -->
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // strip data
      $newBatchCode = htmlspecialchars($_POST['code']);
      $newAmount = htmlspecialchars($_POST['amount']);
      $newSiloNumber = (int)htmlspecialchars($_POST['siloNumber']);
	  $newOperatorID = $_SESSION['operator_id'];
      
      echo "Prepping batch $newBatchCode to go into silo 1$newSiloNumber with ". number_format($newAmount, 0, '', ',') . " lbs of sugar.<br/>";
      
      // first make sure the silo can hold the whole shipment
      $siloPDO = $db->query("SELECT id, silo_number, amount FROM sugar_silo WHERE id = $newSiloNumber");
	  $silo = $siloPDO->fetch();
      $amountInTargetSilo = $silo["amount"];
	  //echo "There is currently $amountInTargetSilo lbs in silo 1$newSiloNumber.<br/>";
	  
	  // only add the batch into the silo if there is space for the whole shipment
      if ($newAmount + $amountInTargetSilo <= 100000) {
        // proceed to insert this new row
		$statement = $db->prepare('INSERT INTO sugar_shipment (batch_code, amount, location, created_by, last_updated_by) VALUES (:newBatchCode, :newAmount, :newSiloNumber, :newOperatorID, :newOperatorID)');
	    $statement->bindValue(':newBatchCode', $newBatchCode);
	    $statement->bindValue(':newAmount', $newAmount);
	    $statement->bindValue(':newSiloNumber', $newSiloNumber);
	    $statement->bindValue(':newOperatorID', $newOperatorID);
	    $statement->execute();
        //$db->query("INSERT INTO sugar_shipment (batch_code, amount, location, created_by, last_updated_by) VALUES ('$newBatchCode', $newAmount, $newSiloNumber, 1, 1);");
        echo "Inserting new sugar batch.  .  .  .  .  .  Done!<br/>";
        
        // update silo by adding more sugar
		$statement = $db->prepare('UPDATE sugar_silo SET amount = amount + :newAmount, last_updated_by = :newOperatorID WHERE id = :newSiloNumber');
	    $statement->bindValue(':newAmount', $newAmount);
	    $statement->bindValue(':newSiloNumber', $newSiloNumber);
	    $statement->bindValue(':newOperatorID', $newOperatorID);
	    $statement->execute();
        //$db->query("UPDATE sugar_silo SET amount = amount + $newAmount WHERE id = $newSiloNumber");
        echo "Updating silo.  .  .  .  .  .  Done!<br/>";
      } else {
        // TOO MUCH SUGAR MAN!
        echo '
        <div class="alert alert-danger">
          <strong>Danger!</strong> Maximum silo capacity reached. Do not proceed.
        </div>
        ';
      }
    }
    ?>

  </body>
  
</html>