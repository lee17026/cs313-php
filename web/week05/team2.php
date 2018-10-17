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
        <h1>Search Results</h1>
        
        <?php
            $book = htmlspecialchars($_POST["book"]);
            foreach ($db->query("SELECT * FROM public.scriptures WHERE book='$book'") as $row):
        ?>
            <form method="POST">
            <li>
                <strong>
                    <label for="book"><?php echo($row["book"]); ?></label>
                    <label for="chapter"><?php echo($row["chapter"]); ?></label>
                    :
                    <label for="verse"><?php echo($row["verse"]); ?></label>
                </strong>
                <input type="text" name="id" value="<?php echo($row["id"]); ?>" style="display: none;" />
                <input type="submit" value="Details" formaction="team3.php" />
            </li>
            </form>
        <?php endforeach; ?>
        
    </body>
</html>