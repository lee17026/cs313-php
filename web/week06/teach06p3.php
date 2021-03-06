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

// stretch 1
$newTopicID = 0;
// deal with the new checkbox
if (isset($_POST['newTopicCheck'])) {
	// get the new topic's name
	$newTopicName = htmlspecialchars($_POST['newTopicText']);
	$db->query("INSERT INTO topic (name) VALUES ('$newTopicName')");
	
	// store that new topic's id for later use
	$newTopicID = $db->lastInsertId('topic_id_seq');
}

// actual insert of the scripture
$db->query("INSERT INTO scriptures (book, chapter, verse, content) VALUES ('$book', $chapter, $verse, '$content')");
$newId = $db->lastInsertId('scriptures_id_seq'); // keep the newest scripture's id

// insert each topic link
foreach ($topics as $row) {
	$topicName = $row['value'];
	$db->query("INSERT INTO scripture_topic (scripture_id, topic_id) VALUES ($newId, $topicName)");
}

if (isset($_POST['newTopicCheck'])) {
	$db->query("INSERT INTO scripture_topic (scripture_id, topic_id) VALUES ($newId, $newTopicID)");
}
?>
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