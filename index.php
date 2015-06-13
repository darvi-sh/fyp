<?php
session_start();
session_regenerate_id();

if (isset($_GET['p'])) {
	if ($_GET['p'] == 'auth') {
		if (isset($_SESSION['user'])) {
			header('location: ./'); die();
		}
	}
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



if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
	$query = $conn->prepare("SELECT `name` FROM `users` WHERE `id` = ? LIMIT 1;");
	$query->execute(array($_SESSION['user']));
	$user = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AGROMET | Weather and Soil Data Visualisation System</title>
	<link href="./css/bootstrap.united.min.css" rel="stylesheet" />
	<link href="./css/jquery.tablesorter.pager.css" rel="stylesheet" />
	<link href="./css/extras.css" rel="stylesheet" />
	<script src="./js/jquery-2.1.4.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/bootbox.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-more.js"></script>
	<script src="http://code.highcharts.com/modules/data.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
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


	<script src="./js/front.js"></script>
</body>
</html>
