<?php
// must start the session to check session variables
session_start();

// set up $filename to point to itself
$filename=$_SERVER["PHP_SELF"];

function is_loggedin() {
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    return true;
  } else {
    return false;
  }
}

// connects to a heroku db and returns a PDO object
function get_db() {
	$db = NULL;
	
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
	
	return $db;
}

?>