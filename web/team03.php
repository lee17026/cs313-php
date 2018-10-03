<html>
<body>

<form>
Username: <?php echo $_POST["name"] ?><br>
E-mail: <?php echo "mailto:" . $_POST["email"] ?><br>
Major: 
<?php if (isset($_POST['major'])) {
  echo $_POST['major'];
}
?><br>
Comments: <br>
<?php if (isset($_POST['comments'])) {
  echo $_POST['comments'];
}
?><br>
Continents: <br>
<?php
	$map = array("North America", "South America", "Europe", "Asia", "Australia", "Africa", "Antartica");
	if (!empty($_POST["continent"])) {
		foreach ($_POST["continent"] as $cont) {
			echo $map[$cont];
			echo "<br>";
			
			
		}
	}
?>


</form>

</body>
</html>
