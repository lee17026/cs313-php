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
	<h1>Scripture Resources</h1>
        <ul>
        <?php foreach ($db->query("SELECT * FROM public.scriptures") as $row): ?>
            <li>
                <strong>
                    <?php echo($row["book"]); ?>
                    <?php echo($row["chapter"]); ?>:<?php echo($row["verse"]); ?>
                </strong>
                &ndash;
                &ldquo;<?php echo($row["content"]); ?>&rdquo;
            </li>
        <?php endforeach; ?>
        </ul>
        <hr />
        <!--
            ################################################################################################################
            # LOOK AT THIS
            ################################################################################################################
        --> 
        <form method="POST">
            Book: <input type="text" name="book" />
            <br />
			Chapter: <input type="number" name="chapter" min="1" step="1" />
            <br />
			Verse: <input type="number" name="verse" min="1" step="1" />
            <br />
			Content: <textarea name="content" rows="10" cols="20"></textarea>
			<br />
            <input type="submit" value="Submit" formaction="#" />
        </form>
  </body>
  
 </html>