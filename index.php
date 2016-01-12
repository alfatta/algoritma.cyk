<?php
	error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<title>CYK</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<form method="post">
		<h1>Input CNF</h1>
		<div id="cnf">
		<?php
			for ($i=0; $i < 10; $i++) { 
				echo "
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][0]."'>&#8594;
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][1]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][2]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][3]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][4]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][5]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][6]."'>|
					<input type='text' name='cnf[$i][]' value='".$_POST['cnf'][$i][7]."'><br>";
			}
		?>
		</div>
		<h1>Input String</h1>
		<?php
			for ($i=0; $i < 5; $i++) { 
				echo "<input type='text' name='str[]' value='".$_POST['str'][$i]."'>";
			}
		?>
		<br>
		<input type="submit" value="submit">
	</form>

<?php
	include 'brain.php';
?>
</body>
</html>
