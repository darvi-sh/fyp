<?php
if (!empty($_GET['remove'])) {
	$sth = $conn->prepare("DELETE FROM `stations` WHERE `id` = ?");
	$sth->execute(array($_GET['remove']));
	header('location: ./?p=stations&removed');die();
}
if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		$$key = htmlentities(trim($value));
	}
	try {
		$sth = $conn->prepare("UPDATE `stations` SET
								`mac` = ?,
								`location_id` = ?,
								`latlong` = ?,
								`temperature` = ?,
								`humidity` = ?,
								`soilMoist` = ?,
								`phMeter` = ?,
								`wetLeaf` = ?,
								`windSpeed` = ?,
								`windDir` = ?,
								`rainMeter` = ?,
								`solarRad` = ?
								WHERE `id` = ?
								LIMIT 1;");
		$data = array(
					$mac_addr, $loc_id, $latlong,
					((isset($temperature)	&&	$temperature == 'on')	? 1 : NULL),
					((isset($humidity)		&&	$humidity == 'on')		? 1 : NULL),
					((isset($soilMoist)		&&	$soilMoist == 'on')		? 1 : NULL),
					((isset($phMeter)		&&	$phMeter == 'on')		? 1 : NULL),
					((isset($wetLeaf)		&&	$wetLeaf == 'on')		? 1 : NULL),
					((isset($windSpeed)		&&	$windSpeed == 'on')		? 1 : NULL),
					((isset($windDir)		&&	$windDir == 'on')		? 1 : NULL),
					((isset($rainMeter)		&&	$rainMeter == 'on')		? 1 : NULL),
					((isset($solarRad)		&&	$solarRad == 'on')		? 1 : NULL),
					htmlentities(trim($_GET['id']))
				);
		$sth->execute($data);
		echo '
		<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
			<strong>Success!</strong> The station has been updated.
		</div>';
		$justInserted = $conn->lastInsertId();
	} catch(PDOException $ex) {
		echo '
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Error!</strong> There was something wrong with updating the station.' .
			$ex->getMessage() . '
		</div>';
	}
}


$query = $conn->query("SELECT *
						FROM `stations`
						WHERE `id` = '" . $_GET['id'] . "';");

$row = $query->fetchAll(PDO::FETCH_ASSOC);

if ($row) {

?>

<form action="./?<?php echo $_SERVER['QUERY_STRING'] ?>" method="post" autocomplete="off">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="mac_addr">MAC Address <small>(16 characters)</small></label>
				<input type="text" class="form-control" name="mac_addr" placeholder="MAC Address" minlength="16" maxlength="16" title="16 Characters" value="<?php echo $row[0]['mac'] ?>" required />
			</div>
			<div class="form-group">
				<label for="loc_id">Location Name</label>
				<select class="form-control" name="loc_id">
				<?php
				$loc_names = $conn->query("SELECT * FROM `locations` ORDER BY `name`;");

				$loc_names = $loc_names->fetchAll(PDO::FETCH_ASSOC);

				foreach ($loc_names as $value) {
					echo '<option value="' . $value['id'] . '"' . ($row[0]['location_id']==$value['id']?' selected':'') . '>' . $value['name'] . '</option>';
				}
				?>
					
				</select>
			</div>
			<div class="form-group">
				<label for="latlong">Latitude, Longitude <small>(comma separated, no spaces)</small></label>
				<input type="text" class="form-control" name="latlong" placeholder="Latitude, Longitude" minlength="3" maxlength="36" pattern="-?\d{1,3}\.\d+[,]-?\d{1,3}\.\d+" title="Comma separated, No spaces" value="<?php echo $row[0]['latlong'] ?>" required />
			</div>
		</div>
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="temperature" <?php echo $row[0]['temperature']?'checked':'' ?> /> Temperature
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="humidity" <?php echo $row[0]['humidity']?'checked':'' ?> /> Humidity
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="soilMoist" <?php echo $row[0]['soilMoist']?'checked':'' ?> /> Soil Moisture
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="phMeter" <?php echo $row[0]['phMeter']?'checked':'' ?> /> pH Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="wetLeaf" <?php echo $row[0]['wetLeaf']?'checked':'' ?> /> Wet Leaf
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="windSpeed" <?php echo $row[0]['windSpeed']?'checked':'' ?> /> Wind Speed
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="windDir" <?php echo $row[0]['windDir']?'checked':'' ?> /> Wind Direction
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="rainMeter" <?php echo $row[0]['rainMeter']?'checked':'' ?> /> Rain Meter
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="solarRad" <?php echo $row[0]['solarRad']?'checked':'' ?> /> Solar Radiation
				</label>
			</div>
			<button type="submit" class="btn btn-primary pull-left">Update</button>
			<a id="removeStation" href="./?p=station&remove=<?php echo htmlentities(trim($_GET['id'])) ?>"><span class="label label-default pull-right">Remove this station</span></a>
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
			<th colspan="10" class="ts-pager form-horizontal">
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
<?php
} else {
	require_once('404.php');
}
?>