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
			<button type="submit" class="btn btn-primary pull-left">Update</button>
			<button type="submit" class="btn btn-default btn-xs pull-right">Remove this station</button>
		</div>
	</div>
</form>

<br />
<hr />
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
	<tfoot>
		<tr>
			<th colspan="5" class="ts-pager form-horizontal">
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
