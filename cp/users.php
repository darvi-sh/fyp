<?php
$justInserted = 0;
if (isset($_GET['removed'])) {
	echo '
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
		<strong>Success!</strong> The user has been removed.
	</div>';
}
if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		$$key = htmlentities(trim($value));
	}
	$sth = $conn->prepare("INSERT INTO `users` (
							`name`,
							`email`,
							`username`,
							`password`,
							`admin`)
							VALUES (?,?,?,?,?);");
	$data = array($full_name, $email_addr, $username, $password, $admin);
	if ($sth->execute($data)) {
		echo '
		<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
			<strong>Success!</strong> The user has been added.
		</div>';
		$justInserted = $conn->lastInsertId();
	} else {
		echo '
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Burp!</strong> Couldn\'t fit this guy into our database :/
		</div>';
	}
}
?>

<form action="./?p=users" method="post" autocomplete="off">
	<h2>Add a New User</h2>
	<hr />
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="full_name">Full Name</label>
				<input type="text" class="form-control" name="full_name" placeholder="Full Name" minlength="2" maxlength="64" title="A name under 2 characters? We don't like it." required />
			</div>
			<div class="form-group">
				<label for="email_addr">Email</label>
				<input type="email" class="form-control" name="email_addr" placeholder="Email Address" minlength="5" maxlength="64" title="Ehem.. an email, you know?" required />
			</div>
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" placeholder="Username" minlength="4" maxlength="32" pattern="^[A-Za-z0-9_]{4,32}$" title="Alphanumeric, Underscore is allowed, Minimum 4 to Maximum 32 Characters." required />
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password" minlength="4" maxlength="32" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Alphanumeric, Special Chararacters, Minimum 8 to Maximum 32 Characters." required />
			</div>
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label for="admin">Type</label>
				<select class="form-control" name="admin">
					<option value="0" selected>Regular</option>
					<option value="1">Admin</option>
				</select>
			</div><br />
			<button type="submit" class="btn btn-primary">Add a New User</button>
		</div>
	</div>
</form>

<br />
<br />
<h2>List of Users</h2>
<hr />

<?php
$query = $conn->query("SELECT `id`, `created_on`, `name`, `email`, `username`, `admin` FROM `users`;");


$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-responsive table-hover table-striped" id="usersTable">
	<thead>
		<tr>
			<th>Full Name</th>
			<th>Email Address</th>
			<th>Username</th>
			<th>Created On</th>
			<th>Admin</th>
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
		<tr<?php echo ($value['id'] == $justInserted)?' class="success"':''?>>
			<td><a href="?p=user&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
			<td><?php echo $value['email'] ?></td>
			<td><?php echo $value['username'] ?></td>
			<td><?php echo $value['created_on'] ?></td>
			<td><?php echo (empty($value['admin'])?'Regular':'Admin') ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>


