<div class="row">
<?php

if (!empty($_POST)) {
	$subsc = NULL;
	foreach ($_POST as $key => $value) {
		if ($key != 'pwd')
			$$key = htmlentities(trim($value));
		if ($key == 'pwd')
			$$key = $value;
	}

	if ($a == 'login') {
		$data = array(':email'	=> $email_addr,
									':pwd'		=> $pwd);
		$query = $conn->prepare("SELECT `id`, `admin` FROM `users` WHERE `email` = :email AND `password` = MD5(:pwd) LIMIT 1;");
		$query->execute(array(':email' => $email_addr, ':pwd' => $pwd));
		$row = $query->fetchAll(PDO::FETCH_ASSOC);

		if ($row) {
			$_SESSION['user']		= $row[0]['id'];
			$_SESSION['admin']	= $row[0]['admin'];
			header('location: ./?p=profile'); die();
		} else {
			echo '<div class="col-md-4 col-md-offset-6 col-sm-4 col-sm-offset-6">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
								<strong>Na-ah!</strong> Not correct, try again.
							</div>
						</div>';
		}
	}

	if ($a == 'register') {
		if ($password == $re_password) {
			$data = array(':name'		=> $full_name,
										':email'	=> $email_addr,
										':pwd'		=> $password,
										':subsc'	=> $subsc);

			$query = $conn->prepare("INSERT INTO `users` (`name`,`email`,`password`,`subscription`) VALUES (:name,:email,MD5(:pwd),:subsc);");

			if ($query->execute($data)) {
				echo '<div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1">
								<div class="alert alert-success" role="alert">
									<span class="glyphicon glyphicon-success" aria-hidden="true"></span>
									<strong>Well done!</strong> You can login now.
								</div>
							</div>';
			} else {
				echo '<div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1">
								<div class="alert alert-danger" role="alert">
									<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
									<strong>An error has occured.</strong><br /> - This account already exists.<br /> - ' .
									$email_addr .
								'</div>
							</div>';
			}
		} else {
			echo '<div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
								<strong>Password Mismatch!</strong><br /> - Make sure passwords are matched.
							</div>
						</div>';
		}
	}
}
?>
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 well">
		<form method="post" autocomplete="off" id="registration_form">
			<h3>Registration</h3>
			<br />
			<div class="form-group">
				<input type="text" class="form-control" name="full_name" placeholder="Full Name" minlength="2" maxlength="64" title="A name under 2 characters? We don't like it." required />
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email_addr" placeholder="Email Address" maxlength="64" title="Ehem.. an email, you know?" required />
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password" minlength="6" title="Minimum 6 Characters." required />
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="re_password" placeholder="Repeat Password" minlength="6" title="Minimum 6 Characters. Passwords must match." required />
			</div>
			<div class="form-group" id="pwd_match_err" style="display: none">
				<div class="alert alert-warning" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<strong>Make sure</strong> that passwords match.
				</div>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="subsc" /> Email alert subscription
				</label>
			</div>
			<br />
			<input type="hidden" name="a" value="register" />
			<button type="submit" class="btn btn-primary pull-right">Sign up</button>
			<br clear="all" />
		</form>
	</div>
	<div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 well">
		<form method="post" autocomplete="off">
			<h3>Login</h3>
			<br />
			<div class="form-group">
				<input type="email" class="form-control" name="email_addr" placeholder="Email Address" maxlength="64" title="Ehem.. an email, you know?" required />
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password" minlength="6" title="Hmm.. that's weird! Our rules clearly says minimum 6 characters for passwords, how did you choose something less than 6?" required />
			</div><br />
			<input type="hidden" name="a" value="login" />
			<button type="submit" class="btn btn-primary pull-right">Sign in</button>
			<br clear="all" />
		</form>
	</div>
</div>

