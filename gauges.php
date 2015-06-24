<?php
//die(print_r($_POST));
//SELECT * FROM `station_data` WHERE (`station_id`, `datetime`) IN (SELECT`station_id`, MAX(`datetime`) AS `datetime` FROM `station_data` WHERE `station_id` IN (1,2) GROUP BY `station_id`) ORDER BY `station_id`
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