<?php
/*
* Dummy data generator to test alerting system
* This file actually is supposed to be a data acquisition tool
* The data will be automatically collected using
* MS Task Scheduler / *nix CRON Jobs / OS X Automator
*/

// Minimum and Maximum values that are safe
$lim['temperature']	= [20,	36];
$lim['humidity']		= [50,	100];
$lim['soilMoist']		= [10,	1000];
$lim['phMeter']			= [5,		10];
$lim['wetLeaf']			= [100,	1000];
$lim['windSpeed']		= [0,		100]; // km/s
$lim['rainMeter']		= [0,		1000];
$lim['solarRad']		= [0,		1000]; // Wm^(-2)

if (!empty($_POST)) {
	$params = NULL;
	foreach ($_POST as $key => $value) {
		$data[$key] = htmlentities(trim($value));
		if ($key != 'station_id' && $key != 'windDir' && ($value < $lim[$key][0] || $value > $lim[$key][1])) {
			$params .= '- ' . $key . ": " . $value . "\n";
		}
	}

	$sth = $conn->prepare("INSERT INTO `station_data` (
								`station_id`,
								`temperature`,
								`humidity`,
								`soilMoist`,
								`phMeter`,
								`wetLeaf`,
								`windSpeed`,
								`windDir`,
								`rainMeter`,
								`solarRad`)
								VALUES (
								:station_id,
								:temperature,
								:humidity,
								:soilMoist,
								:phMeter,
								:wetLeaf,
								:windSpeed,
								:windDir,
								:rainMeter,
								:solarRad);");
	if ($sth->execute($data)) {
		echo 'The data has been recorded.<br />';
	}

	if (!is_null($params)) {
		// PHP mail(); You can easily get this going by using
		// local mail server, Fakemail or Test Mail Server Tool
		// foreach user
		$msg = "A new out of range data has been recorded.\n\n";
		$msg .= 'Station ID #' . $data['station_id'] . "\n" . $params;
		$msg .= "\nYou are receiving this email because you have subscribed for alerts."
					. "\nYou can turn them off in your profile settings.\n";
		$query = $conn->query("SELECT `email` FROM `users` WHERE `subscription` = 1;");
		$row = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($row as $value) {
			if (@!mail($value['email'], "AGROMET ALERT!", $msg)) {
				echo 'An error has occured.<br />
							- Test Mail Server Tool is not running<br />
							- Something else.';
			}
		}
		echo 'Alerting emails have been sent to subscribed users.';
	}
}

?>

<div class="row well">
	<form action="./?p=data" method="post" autocomplete="off">
		<h2>Add New Data For A Station</h2>
		<br />
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
					<input type="text" class="form-control" name="station_id" placeholder="Station ID" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="temperature" placeholder="Temperature" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="humidity" placeholder="Humidity" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="soilMoist" placeholder="Soil Moisture" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="phMeter" placeholder="pH Meter" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="wetLeaf" placeholder="Wet Leaf" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="windSpeed" placeholder="Wind Speed" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="windDir" placeholder="Wind Direction (N, NE, E, SE, S, SW, W, NW)" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="rainMeter" placeholder="Rain Meter" required />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="solarRad" placeholder="Solar Radiation (UV)" required />
				</div>
				<button type="submit" class="btn btn-primary">Add the Data</button>
			</div>
		</div>
	</form>
</div>
