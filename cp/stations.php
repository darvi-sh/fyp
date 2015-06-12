<?php
$justInserted = 0;
if (isset($_GET['removed'])) {
	echo '
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
		<strong>Success!</strong> The station has been removed.
	</div>';
}
if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		$$key = htmlentities(trim($value));
	}
	$sth = $conn->prepare("INSERT INTO `stations` (
							`mac`,
							`location_id`,
							`latlong`,
							`temperature`,
							`humidity`,
							`soilMoist`,
							`phMeter`,
							`wetLeaf`,
							`windSpeed`,
							`windDir`,
							`rainMeter`,
							`solarRad`)
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?);");
	$data = array($mac_addr,$loc_id,$latlong,
					((isset($temperature)	&&	$temperature == 'on')	? 1 : NULL),
					((isset($humidity)		&&	$humidity == 'on')		? 1 : NULL),
					((isset($soilMoist)		&&	$soilMoist == 'on')		? 1 : NULL),
					((isset($phMeter)		&&	$phMeter == 'on')		? 1 : NULL),
					((isset($wetLeaf)		&&	$wetLeaf == 'on')		? 1 : NULL),
					((isset($windSpeed)		&&	$windSpeed == 'on')		? 1 : NULL),
					((isset($windDir)		&&	$windDir == 'on')		? 1 : NULL),
					((isset($rainMeter)		&&	$rainMeter == 'on')		? 1 : NULL),
					((isset($solarRad)		&&	$solarRad == 'on')		? 1 : NULL)
				);
	if ($sth->execute($data)) {
		echo '
		<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
			<strong>Success!</strong> The station has been added.
		</div>';
		$justInserted = $conn->lastInsertId();
	} else {
		echo '
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Error!</strong> Probably a duplicated MAC Address?
		</div>';
	}
}
?>

<div class="row well">
	<form action="./?p=stations" method="post" autocomplete="off">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="mac_addr">MAC Address <small>(16 characters)</small></label>
					<input type="text" class="form-control" name="mac_addr" placeholder="MAC Address" minlength="16" maxlength="16" title="16 Characters" required />
				</div>
				<div class="form-group">
					<label for="loc_id">Location Name</label>
					<select class="form-control" name="loc_id">
					<?php
					$loc_names = $conn->query("SELECT * FROM `locations` ORDER BY `name`;");

					$loc_names = $loc_names->fetchAll(PDO::FETCH_ASSOC);

					foreach ($loc_names as $value) {
						echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
					}
					?>
						
					</select>
				</div>
				<div class="form-group">
					<label for="latlong">Latitude, Longitude <small>(comma separated, no spaces)</small></label>
					<input type="text" class="form-control" name="latlong" placeholder="Latitude, Longitude" minlength="3" maxlength="36" pattern="-?\d{1,3}\.\d+[,]-?\d{1,3}\.\d+" title="Comma separated, No spaces" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="temperature" checked /> Temperature
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="humidity" checked /> Humidity
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="soilMoist" checked /> Soil Moisture
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="phMeter" checked /> pH Meter
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="wetLeaf" checked /> Wet Leaf
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="windSpeed" checked /> Wind Speed
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="windDir" checked /> Wind Direction
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="rainMeter" checked /> Rain Meter
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="solarRad" checked /> Solar Radiation
					</label>
				</div>
				<button type="submit" class="btn btn-primary">Add a New Station</button>
			</div>
		</div>
	</form>
</div>

<br />
<br />
<h2>List of Stations</h2>
<hr />

<?php
$query = $conn->query("SELECT
						`stations`.`id`,
						`stations`.`mac`,
						`locations`.`name` AS `location_name`,
						CONCAT(
							IF (`stations`.`temperature`	= 1, 'Temperature, ',		''),
							IF (`stations`.`humidity`		= 1, 'Humidity, ',			''),
							IF (`stations`.`soilMoist`		= 1, 'Soil Moisture, ',		''),
							IF (`stations`.`phMeter`		= 1, 'pH Meter, ',			''),
							IF (`stations`.`wetLeaf`		= 1, 'Wet Leaf, ',			''),
							IF (`stations`.`windSpeed`		= 1, 'Wind Speed, ',		''),
							IF (`stations`.`windDir`		= 1, 'Wind Direction, ',	''),
							IF (`stations`.`rainMeter`		= 1, 'Rain Meter, ',		''),
							IF (`stations`.`solarRad`		= 1, 'Solar Radiation',		'')
						) AS `sensors`
						FROM `stations`
							INNER JOIN `locations`
								ON `stations`.`location_id` = `locations`.`id`;");


$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-responsive table-hover table-striped" id="stationsTable">
	<thead>
		<tr>
			<th>MAC Address</th>
			<th>Location</th>
			<th width="40%">Sensors</th>
			<th>Last Update</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th colspan="4" class="ts-pager form-horizontal">
				<button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
				<button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
				<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
				<button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
				<button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
				<select class="pagesize input-mini" title="Select page size">
				  <option selected="selected" value="10">10</option>
				  <option value="25">25</option>
				  <option value="50">50</option>
				</select>
				<select class="pagenum input-mini" title="Select page number"></select>
			</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		foreach ($row as $value) {
		?>
		<tr<?php echo ($value['id'] == $justInserted)?' class="success"':''?>>
			<td><a href="?p=station&id=<?php echo $value['id']; ?>"><?php echo $value['mac']; ?></a></td>
			<td><?php echo $value['location_name']; ?></td>
			<td>
			<?php
			$sensors = explode(',', $value['sensors']);
			foreach ($sensors as $val) {
				echo '<span class="label label-default">' . trim($val) . '</span> ';
			}
			$last_update = $conn->query("SELECT DATE_FORMAT(`datetime`, '%a, %b %D %Y, %T') AS `datetime`
											FROM `station_data`
											WHERE `station_id` = " . $value['id'] . "
											ORDER BY `datetime` DESC LIMIT 1;");

			$last_update = $last_update->fetchAll(PDO::FETCH_ASSOC);
			?>
			</td>
			<td><?php echo (empty($last_update[0]['datetime'])?'':$last_update[0]['datetime']); ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>


