<?php
$validUser = true;

if (isset($_GET['p'])) {
	$p = $_GET['p'] . '.php';
	if (!file_exists($p) || in_array($_GET['p'], array('header', 'footer'))) $p = '404.php';
} else {
	$p = 'home.php';
}

// Check for valid user


try {
	$conn = new PDO('mysql:host=127.0.0.1;dbname=fyp', 'root', '');
} catch (PDOException $Exception) {
	// Error
	// throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
	// echo "DB connection error eh :/";
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
	<link href="../css/jquery.tablesorter.pager.css" rel="stylesheet" />
	<link href="../css/extras.css" rel="stylesheet" />
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			<?php
			require_once('header.php');
			?>
		</div>
		<div class="row">
			<div class="container">
				<div class="main">
					<?php
					require_once($p);
					?>
				</div>
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
	<script src="../js/jquery.tablesorter.combined.js"></script>
	<script src="../js/widgets/widget-pager.js"></script>
	<script src="../js/widgets/jquery.tablesorter.pager.js"></script>
	<script src="../js/bootbox.min.js"></script>
	<script src="../js/js.js"></script>
</body>
</html>