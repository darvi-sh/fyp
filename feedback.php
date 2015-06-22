<div class="row">
	<?php
	if (isset($_SESSION['user']) && isset($_POST['feedback']) && !empty($_POST['feedback'])) {
		$data = array(':user_id'	=> $_SESSION['user'],
					  ':feedback'	=> $_POST['feedback']);
		$query = $conn->prepare("INSERT INTO `feedbacks` (`user_id`,`feedback`) VALUES (:user_id, :feedback);");

		if ($query->execute($data)) {
			echo '<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
							<div class="alert alert-success" role="alert">
								<span class="glyphicon glyphicon-success" aria-hidden="true"></span>
								<strong>Done!</strong> Your feedback has been successfully submitted.
							</div>
						</div>';
		} else {
			echo '<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
								<strong>Achoo!</strong> Something\'s wrong with the system :/' .
								$email_addr .
							'</div>
						</div>';
		}
	}
	?>
	<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 well">
		<form method="post" autocomplete="off" id="feedback_form">
			<h2>Feedback</h2>
			<textarea class="form-control" rows="5" name="feedback" placeholder="Feedback.." minlength="10" required></textarea><br />
			<button type="submit" class="btn btn-primary pull-right">Submit</button>
		</form>
	</div>
</div>