<?php
try {
	$conn = new PDO('mysql:host=127.0.0.1;dbname=fyp', 'root', '');
} catch (PDOException $Exception) {
	// throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
}

$query = $conn->prepare("SELECT
											 AVG(`temperature`) AS `temperature`,
											 AVG(`humidity`) AS `humidity`,
											 AVG(`soilMoist`) AS `soilMoist`,
											 AVG(`phMeter`) AS `phMeter`,
											 AVG(`wetLeaf`) AS `wetLeaf`,
											 AVG(`windSpeed`) AS `windSpeed`,
											 AVG(`rainMeter`) AS `rainMeter`,
											 AVG(`solarRad`) AS `solarRad`
											 FROM `station_data`
											 WHERE (`station_id`, `datetime`)
											 IN (SELECT`station_id`, MAX(`datetime`) AS `datetime`
											 FROM `station_data`
											 WHERE `station_id`
											 IN (" . implode(',', array_fill(0, count($_POST['stations']), '?')) . ")
											 GROUP BY `station_id`)
											 ORDER BY `station_id`;");
$query->execute($_POST['stations']);

$row = $query->fetchAll(PDO::FETCH_ASSOC);
$data[0] = array("Label", "Value");

$i = 1;
foreach ($row[0] as $key => $value) {
	$data[$i] = array($key, round($value, 2));
	$i++;
}

die(json_encode($data));
?>
[
	["Label", "Value"],
	["Temperature", 30],
	["Solar Radiation", 28],
	["Humidity", 84],
	["Rainmeter", 2],
	["Wet Leaf", 3],
	["Soil Moisture", 7],
	["pH Meter", 7],
	["Wind Speed", 56]
]