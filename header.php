<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">AGROMET Data Visualiser</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="./"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['user'])) { ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user[0]['name'] ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
						<li><a href="./cp/"><span class="glyphicon glyphicon-cog"></span> Control Panel</a></li>
						<?php } ?>
						<li><a href="?p=profile"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
						<li><a href="?p=feedback"><span class="glyphicon glyphicon-user"></span> Feedback</a></li>
						<li><a href="?p=logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
					</ul>
				</li>
				<?php } else { ?>
				<li><a href="?p=auth"><span class="glyphicon glyphicon-log-in"></span> Register / Login</a></li>
				<?php } ?>
			</ul>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>
