Timestamp,Temperature,Solar Radiation,Humidity,Rain Meter,Wet Leaf,Soil Moisture,pH Meter,Wind Speed
<?php
/*$conn = new PDO('mysql:host=127.0.0.1;dbname=fyp', 'root', '');
$query = $conn->prepare("SELECT * FROM `station_data` WHERE `station_id` = ?;");

$query->execute(array($_GET['id']));

$row = $query->fetchAll(PDO::FETCH_ASSOC);


foreach ($row as $v) {
	echo	$v['datetime'] . "," .
				$v['temperature'] . "," .
				$v['solarRad'] . "," .
				$v['humidity'] . "," .
				$v['rainMeter'] . "," .
				$v['wetLeaf'] . "," .
				$v['soilMoist'] . "," .
				$v['phMeter'] . "," .
				$v['windSpeed'] .
				"\n";
}
*/
for ($i=0; $i < 1461; $i++) {
	echo	date('Y-m-d H:i:s', strtotime('-2 month +' . $i . ' hours', time())) . "," .
				mt_rand(23, 37) . "," .
				mt_rand(500, 600) . "," .
				mt_rand(50, 100) . "," .
				mt_rand(0, 5000) . "," .
				mt_rand(0, 100) . "," .
				mt_rand(0, 100) . "," .
				mt_rand(60, 80) / 10 . "," .
				mt_rand(0, 100) .
				"\n";
}
?>
