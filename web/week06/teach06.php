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
    <title>Week 06 Team Activity</title> 
<script type="application/javascript">
function sendScriptures() {
	/*
	// get the DOM form elements
	let txtBook = document.getElementsByName('book')[0];
	let txtChapter = document.getElementsByName('chapter')[0];
	let txtVerse = document.getElementsByName('verse')[0];
	let txtContent = document.getElementsByName('content')[0];
	let chkTopics = document.getElementsByName('topics[]');
	let chkNewTopicCheck = document.getElementsByName('newTopicCheck')[0];
	let txtNewTopicText = document.getElementsByName('newTopicText')[0];

	// get the values in the elements
	let book = txtBook.value;
	let chapter = txtChapter.value;
	let verse = txtVerse.value;
	let content = txtContent.value;
	let newTopicCheck = chkNewTopicCheck.value;
	let newTopicText = txtNewTopicText.value;

	// get the topics checkboxes' values
	let topics = '';
	for (let checkbox of chkTopics) {
		topics += `${checkbox.value},`;
	}

	var formData = new FormData();
	formData.append("book", book);
	formData.append("chapter", chapter);
	formData.append("verse", verse);
	formData.append("content", content);
	formData.append("newTopicCheck", newTopicCheck);
	formData.append("newTopicText", newTopicText);
	formData.append("topics", topics);
	*/
	var formData = new FormData(document.forms.namedItem("scriptureForm"));
	
	let xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var list1 = document.getElementById("list1");
			list1.innerHTML = this.response;
		}
	};
	
	// change the HTTP method and filename as needed
	xhr.open("POST", "teach06p3.php", true);
	xhr.send(formData);
}
</script>	
  </head>
  
  <body>
	<h1>Scripture Resources</h1>
        <ul id="list1">
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
        <hr />
        <form method="POST" name="scriptureForm">
            Book: <input type="text" name="book" />
            <br />
			Chapter: <input type="number" name="chapter" min="1" step="1" />
            <br />
			Verse: <input type="number" name="verse" min="1" step="1" />
            <br />
			Content: <textarea name="content" rows="10" cols="20"></textarea>
			<br />
			<?php foreach ($db->query("SELECT * FROM public.topic") as $row): ?>
				<input type="checkbox" name="topics[]" value="<?=$row['id']?>"> <?=$row['name']?><br>
			<?php endforeach; ?>
			<br />
			<input type="checkbox" name="newTopicCheck" value="isNewTopicCheck" />
			New Topic: <input type="text" name="newTopicText" />
			<input type="button" value="Submit" onclick="sendScriptures();" />
            <!-- <input type="submit" value="Submit" formaction="teach06p2.php" /> Stretch 1 and 2 -->
        </form>
  </body>
  
 </html>