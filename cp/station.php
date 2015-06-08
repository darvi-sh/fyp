<?php
$query = $conn->query("SELECT `stations`.*, `locations`.`name` AS `loc_name`
								FROM `stations`
									INNER JOIN `locations`
										ON `stations`.`location_id` = `locations`.`id`
								WHERE `mac` = '" . $_GET['mac'] . "';");

$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="mac_addr">MAC Address <small>(16 characters)</small></label>
				<input type="text" class="form-control" name="mac_addr" placeholder="MAC Address" value="<?php echo $row[0]['mac'] ?>" />
			</div>
			<div class="form-group">
				<label for="loc_name">Location Name</label>
				<input type="text" class="form-control" name="loc_name" placeholder="Location Name" value="<?php echo $row[0]['loc_name'] ?>" />
			</div>
			<div class="form-group">
				<label for="latlong">Latitude, Longitude <small>(comma separated)</small></label>
				<input type="text" class="form-control" name="latlong" placeholder="Latitude, Longitude" value="<?php echo $row[0]['latlong'] ?>" />
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</div>
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['temperature']?'checked':'' ?> /> Temperature
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['humidity']?'checked':'' ?> /> Humidity
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['soilMoist']?'checked':'' ?> /> Soil Moisture
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['phMeter']?'checked':'' ?> /> pH Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['wetLeaf']?'checked':'' ?> /> Wet Leaf
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['windSpeed']?'checked':'' ?> /> Wind Speed
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['windDir']?'checked':'' ?> /> Wind Direction
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['rainMeter']?'checked':'' ?> /> Rain Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?php echo $row[0]['solarRad']?'checked':'' ?> /> Solar Radiation
				</label>
			</div>
		</div>
	</div>
</form>

<br />

<?php
$query = $conn->query("SELECT * FROM `station_data` WHERE `station_id` = " . $row[0]['id'] . " LIMIT 100;");

$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-responsive table-hover" id="stationData">
	<thead>
		<tr>
			<th>Date & Time</th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th>Soil Moisture</th>
			<th>pH Meter</th>
			<th>Wet Leaf</th>
			<th>Wind Speed</th>
			<th>Wind Direction</th>
			<th>Rain Meter</th>
			<th>Solar Radiation</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($row as $value) {
		?>
		<tr>
			<td><?php echo $value['datetime']; ?></td>
			<td><?php echo $value['temperature']; ?></td>
			<td><?php echo $value['humidity']; ?></td>
			<td><?php echo $value['soilMoist']; ?></td>
			<td><?php echo $value['phMeter']; ?></td>
			<td><?php echo $value['wetLeaf']; ?></td>
			<td><?php echo $value['windSpeed']; ?></td>
			<td><?php echo $value['windDir']; ?></td>
			<td><?php echo $value['rainMeter']; ?></td>
			<td><?php echo $value['solarRad']; ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
