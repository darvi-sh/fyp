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

	$data = array(':name' => $full_name,
								':email' => $email_addr,
								':admin' => $admin,
								':id' => htmlentities(trim($_GET['id'])));

	if (!empty($_POST['password'])) {
		$pwd = '`password` = MD5(:pwd),';
		$data[':pwd'] = $password;
	} else {
		$pwd = NULL;
	}


	try {
		$sth = $conn->prepare("UPDATE `users`
															SET `name` = :name,
																	`email` = :email,
																	" . $pwd . "
																	`admin` = :admin
																	WHERE `id` = :id
																	LIMIT 1;");

		$sth->execute($data);

		echo '
		<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
			<strong>Success!</strong> The user has been updated.
		</div>';

	} catch(PDOException $ex) {
		echo '
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Burp!</strong> There was something wrong with updating the user.' .
			$ex->getMessage() . '
		</div>';
	}
}


$query = $conn->query("SELECT * FROM `users` WHERE `id` = '" . $_GET['id'] . "';");

$row = $query->fetchAll(PDO::FETCH_ASSOC);

if ($row) {
?>

<div class="row well">
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
					<input type="email" class="form-control" name="email_addr" placeholder="Email Address" maxlength="64" title="Ehem.. an email, you know?" value="<?php echo $row[0]['email'] ?>" required />
				</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Password" minlength="6" title="Minimum 6 Characters." />
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
				<a id="remover" data-warn="This action cannot be undone and will remove this user permanently." href="./?p=user&remove=<?php echo htmlentities(trim($_GET['id'])) ?>"><span class="label label-default pull-right">remove this user</span></a>
			</div>
		</div>
	</form>
</div>

<?php

} else {
	require_once('404.php');
}
?>