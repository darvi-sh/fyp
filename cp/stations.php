<form action="">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="mac_addr">MAC Address <small>(16 characters)</small></label>
				<input type="text" class="form-control" name="mac_addr" placeholder="MAC Address" value="" />
			</div>
			<div class="form-group">
				<label for="loc_name">Location Name</label>
				<input type="text" class="form-control" name="loc_name" placeholder="Location Name" value="" />
			</div>
			<div class="form-group">
				<label for="latlong">Latitude, Longitude <small>(comma separated)</small></label>
				<input type="text" class="form-control" name="latlong" placeholder="Latitude, Longitude" value="" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Temperature
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Humidity
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Soil Moisture
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> pH Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Wet Leaf
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Wind Speed
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Wind Direction
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Rain Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" checked /> Solar Radiation
				</label>
			</div>
			<button type="submit" class="btn btn-primary">Add a New Station</button>
		</div>
	</div>
</form>

<br />
<hr />
<br />

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

<table class="table table-bordered table-responsive table-hover" id="stationsTable">
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
		<tr>
			<td><a href="?p=station&mac=<?php echo $value['mac']; ?>"><?php echo $value['mac']; ?></a></td>
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


