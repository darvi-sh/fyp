<div class="row">
	<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
		<?php
		if (isset($_GET['remove'])) {
			$sth = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
			$sth->execute(array($_SESSION['user']));
			header('location: ./?p=logout');die();
		}

		if (!empty($_POST)) {
			$subsc = NULL;
			foreach ($_POST as $key => $value) {
				if ($key != 'pwd')
					$$key = htmlentities(trim($value));
				if ($key == 'pwd')
					$$key = $value;
			}

			$data = array(':name'		=> $full_name,
										':email'	=> $email_addr,
										':subsc'	=> $subsc,
										':id'			=> $_SESSION['user']);

			if (!empty($_POST['password'])) {
				$pwd = '`password` = MD5(:pwd),';
				$data[':pwd'] = $pwd;
			} else {
				$pwd = NULL;
			}

			if ($subsc == 'on')
				$data[':subsc'] = 1;


			try {
				$sth = $conn->prepare("UPDATE `users`
																	SET `name` = :name,
																			`email` = :email,
																			" . $pwd . "
																			`subscription` = :subsc
																			WHERE `id` = :id;");

				$sth->execute($data);

				echo '
				<div class="alert alert-success" role="alert">
					<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
					<strong>Success!</strong> Your profile has been updated.
				</div>';

			} catch(PDOException $ex) {
				echo '
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<strong>Burp!</strong> There was something wrong with updating the your profile.' .
					$ex->getMessage() . '
				</div>';
			}
		}
		?>
	</div>
</div>

<?php

$query = $conn->query("SELECT * FROM `users` WHERE `id` = '" . $_SESSION['user'] . "';");

$row = $query->fetchAll(PDO::FETCH_ASSOC);

if ($row) {
?>

<div class="row">
	<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 well">
		<form action="./?<?php echo $_SERVER['QUERY_STRING'] ?>" method="post" autocomplete="off">
			<h2>Edit Profile</h2>
			<hr />
					<div class="form-group">
						<label for="full_name">Full Name</label>
						<input type="text" class="form-control" name="full_name" placeholder="Full Name" minlength="2" maxlength="64" title="A name under 2 characters? We don't like it." value="<?php echo $row[0]['name'] ?>" required />
					</div>
					<div class="form-group">
						<label for="email_addr">Email</label>
						<input type="email" class="form-control" name="email_addr" placeholder="Email Address" maxlength="64" title="Ehem.. an email, you know?" value="<?php echo $row[0]['email'] ?>" required />
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="pwd" placeholder="Password" minlength="6" title="Minimum 6 Characters." />
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="subsc"<?php echo ($row[0]['subscription']==1?' checked':'') ?> /> Email Alert Subscription
						</label>
					</div><br />
					<button type="submit" class="btn btn-primary pull-left">Update</button>
					<a id="remover" data-warn="This action cannot be undone and your account will be removed permanently." href="./?p=profile&remove"><span class="label label-default pull-right">remove this account</span></a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php

} else {
	require_once('404.php');
}
?>