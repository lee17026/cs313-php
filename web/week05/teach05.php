<?php
try
{
  $dbUrl = getenv('DATABASE_URL');

  $dbOpts = parse_url($dbUrl);

  $dbHost = $dbOpts["host"];
  $dbPort = $dbOpts["port"];
  $dbUser = $dbOpts["user"];
  $dbPassword = $dbOpts["pass"];
  $dbName = ltrim($dbOpts["path"],'/');

  $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}
?>

<!DOCTYPE html>
<html>
    
  <head>
    <meta charset="utf-8">
    <title>Week 05 Team Activity</title>   
  </head>
  
  <body>
	<h1>For Each example</h1>
	<?php
	foreach ($db->query('SELECT * FROM public.scriptures') as $row)
	{
	  echo 'id: ' . $row['id'];
	  echo ' book: ' . $row['book'];
	  echo ' chapter: ' . $row['chapter'];
	  echo ' verse: ' . $row['verse'];
	  echo ' content: ' . $row['content'];
	  echo '<br/>';
	}
	?>
	<br /><br /><br />
	<h1>PDO example</h1>
	<?php
	$stmt = $db->prepare('SELECT * FROM public.scriptures WHERE id=:id AND book=:book AND chapter=:chapter AND verse=:verse');
	$stmt->execute(array(':id' => $id, ':book' => $book, ':chapter' => $chapter, ':verse' => $verse));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	var_dump($rows);
	?>
  </body>
  
 </html>