<div class="row">
	<h2>Data for station #<?php echo $_GET['id'] ?></h2>
	<div class="col-md-10 col-sm-10">
		<div id="dow_chart" style="width:100%; height:350px;"></div>
	</div>
	<div class="col-md-2 col-sm-2">
		<input type=checkbox id=0 onClick="change(this)" checked>
		<label for="0"> Temperature</label><br />

		<input type=checkbox id=1 onClick="change(this)">
		<label for="1"> Solar Radiation</label><br />

		<input type=checkbox id=2 onClick="change(this)" checked>
		<label for="2"> Humidity</label><br />

		<input type=checkbox id=3 onClick="change(this)">
		<label for="3"> Rain Meter</label><br />

		<input type=checkbox id=4 onClick="change(this)">
		<label for="4"> Wet Leaf</label><br />

		<input type=checkbox id=5 onClick="change(this)">
		<label for="5"> Soil Moisture</label><br />

		<input type=checkbox id=6 onClick="change(this)">
		<label for="6"> pH Meter</label><br />

		<input type=checkbox id=7 onClick="change(this)">
		<label for="7"> Wind Speed</label><br />

		<hr />

		<small>
			- You can zoom by dragging on any part of the chart, horizontally or vertically.<br />
			- Double click to reset the zoom.
		</small>
	</div>
</div>

<br />
<hr />

<div class="row">
	<h2>User Comments</h2>
</div>

<?php
if (isset($_SESSION['user'])) {
?>
<div class="row">
	<form method="post">
		<div class="form-group">
			<textarea class="form-control" name="comment" placeholder="Comment.." cols="100" rows="5"></textarea>
		</div>
		<button type="submit" class="btn btn-primary pull-right">Send</button>
	</form>
</div>
<?php
}
?>


<script type="text/javascript" src="./js/dygraph-combined.js"></script>


<script type="text/javascript">
	agrometChart = new Dygraph(
		document.getElementById('dow_chart'),
		"station_data.php?id=<?php echo $_GET['id'] ?>",
		{
			showRoller: true,
			labelsKMB: true,
			rollPeriod: 7,
			visibility: [true, false, true, false, false, false, false, false],
			showRangeSelector: true
		}
	);

	function change(el) {
		agrometChart.setVisibility(el.id, el.checked);
	}

	$(document).ready(function(){
		agrometChart.setVisibility(el.id, el.checked);
	});

</script>

