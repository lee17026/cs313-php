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

// strip and prepare variables
$book = htmlspecialchars($_POST['book']);
$chapter = htmlspecialchars($_POST['chapter']);
$verse = htmlspecialchars($_POST['verse']);
$content = htmlspecialchars($_POST['content']);
$topics = $_POST['topics'];

$db->query("INSERT INTO scriptures (book, chapter, verse, content) VALUES ('$book', $chapter, $verse, '$content')");
$newId = $db->lastInsertId('scriptures_id_seq');
foreach ($topics as $row) {
	$db->query("INESRT INTO scripture_topic (scripture_id, topic_id) VALUES ($newId, $row['value'])");
}


// prepare insert statement
//$stmt = db->prepare('INSERT INTO scriptures (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');

//$stmt->execute(array(':book' => $book, ':chapter' => $chapter, ':verse' => $verse, ':content' => $content));
?>

<!DOCTYPE html>
<html>
    
  <head>
    <meta charset="utf-8">
    <title>Week 06 Team Activity</title>   
  </head>
  
  <body>
	<h1>Scripture Resources</h1>
        <ul>
        <?php foreach ($db->query("SELECT s.book, s.chapter, s.verse, s.content, string_agg(t.name, ', ') FROM scriptures s JOIN scripture_topic st ON s.id = st.scripture_id JOIN topic t ON st.topic_id = t.id GROUP BY s.id") as $row): ?>
            <li>
                <strong>
                    <?php echo($row["book"]); ?>
                    <?php echo($row["chapter"]); ?>:<?php echo($row["verse"]); ?>
                </strong>
                &ndash;
                &ldquo;<?php echo($row["content"]); ?>&rdquo;
				 Topics: <?=$row["string_agg"]?>
            </li>
        <?php endforeach; ?>
        </ul>
        
  </body>
  
 </html>