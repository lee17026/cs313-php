<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Week 05 Team</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <?php
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
        ?>
        <h1>Scripture Details</h1>
        
        <?php
            $id = htmlspecialchars($_POST["id"]);
			echo "$id";
            $row = $db->query("SELECT * FROM public.scriptures WHERE id='$id'");
            $book = $row["book"];
			echo "$book";
            $chapter = $row["chapter"];
            $verse = $row["verse"];
            $content = $row["content"];
            echo("$book $chapter:$verse &ldquo;$content&rdquo;");
        ?>
    </body>
</html>