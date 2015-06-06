<?php

if (isset($_GET['p'])) {
	$p = $_GET['p'] . '.php';
	if (!file_exists($p) || in_array($_GET['p'], array('header', 'footer'))) $p = '404';
} else {
	$p = 'home.php';
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AGROMET Control Panel</title>
	<link href="../css/bootstrap.united.min.css" rel="stylesheet" />
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			<?php
			require_once('header.php');
			?>
		</div>
		<div class="row">
			<div class="main">
				<?php
				require_once($p);
				for ($i=0; $i < 50; $i++) { 
					echo "<br />\n";
				}
				?>
			</div>
		</div>
		<div class="row">
			<?php
			require_once('footer.php');
			?>
		</div>
	</div>

	<script src="../js/jquery-1.11.3.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>