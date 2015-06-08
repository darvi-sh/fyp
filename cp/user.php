<?php
if (!empty($_GET['remove'])) {
	$sth = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
	$sth->execute(array($_GET['remove']));
	header('location: ./?p=users&removed');die();
}

if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		$$key = htmlentities(trim($value));
	}

	$data = array(	':name' => $full_name,
					':email' => $email_addr,
					':username' => $username,
					':admin' => $admin,
					':id' => htmlentities(trim($_GET['id'])));

	if (!empty($_POST['password'])) {
		$pwd = '`password` = MD5(:pwd),';
		$data[':pwd'] = $password;
	} else {
		$pwd = NULL;
	}


	try {
		$sth = $conn->prepare("UPDATE `users` SET
								`name` = :name,
								`email` = :email,
								`username` = :username,
								" . $pwd . "
								`admin` = :admin
								WHERE `id` = :id
								LIMIT 1;");

		print_r($sth);
		$sth->execute($data);

		echo '
		<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
			<strong>Success!</strong> The user has been updated.
		</div>';

		$justInserted = $conn->lastInsertId();

	} catch(PDOException $ex) {
		echo '
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Burp!</strong> There was something wrong with updating the user.' .
			$ex->getMessage() . '
		</div>';
	}
}


$query = $conn->query("SELECT *
						FROM `users`
						WHERE `id` = '" . $_GET['id'] . "';");

$row = $query->fetchAll(PDO::FETCH_ASSOC);

if ($row) {
?>

<form action="./?<?php echo $_SERVER['QUERY_STRING'] ?>" method="post" autocomplete="off">
	<h2>Edit User</h2>
	<hr />
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="full_name">Full Name</label>
				<input type="text" class="form-control" name="full_name" placeholder="Full Name" minlength="2" maxlength="64" title="A name under 2 characters? We don't like it." value="<?php echo $row[0]['name'] ?>" required />
			</div>
			<div class="form-group">
				<label for="email_addr">Email</label>
				<input type="email" class="form-control" name="email_addr" placeholder="Email Address" minlength="5" maxlength="64" title="Ehem.. an email, you know?" value="<?php echo $row[0]['email'] ?>" required />
			</div>
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" placeholder="Username" minlength="4" maxlength="32" pattern="^[A-Za-z0-9_]{4,32}$" title="Alphanumeric, Underscore is allowed, Minimum 4 to Maximum 32 Characters." value="<?php echo $row[0]['username'] ?>" required />
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password" minlength="4" maxlength="32" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Alphanumeric, Special Chararacters, Minimum 8 to Maximum 32 Characters." />
			</div>
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="admin">Type</label>
				<select class="form-control" name="admin">
				<?php
				if ($row[0]['admin'] != 1) {
					$regular	= ' selected';
					$admin		= NULL;
				} else {
					$regular	= NULL;
					$admin		= ' selected';
				}
				?>
					<option value="0"<?php echo $regular ?>>Regular</option>
					<option value="1"<?php echo $admin ?>>Admin</option>
				</select>
			</div><br />
			<button type="submit" class="btn btn-primary pull-left">Update</button>
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