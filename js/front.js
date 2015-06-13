$(function(){
	var query = location.search.substring(1);
	if (query.trim()) {
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if(pair[0] == 'p') {
				$('li a[href$="' + pair[1] + '"]').parent('li').addClass('active');
			}
		}
	} else {
		$('li a span.glyphicon-home').parent('a').parent('li').addClass('active');
	}

	$('form#registration_form').on('submit', function(e){
		if ($('#registration_form input[name="password"]').val() == $('#registration_form input[name="re_password"]').val()) {
			$('#registration_form #pwd_match_err').fadeOut();
			$('form#registration_form').submit();
		} else {
			e.preventDefault();
			$('#registration_form #pwd_match_err').fadeIn();
		}
	});
	$("form").on('click', '#remover', function(e) {
		e.preventDefault();
		var href = $(this).attr('href');
		var warn = '<br /><br />' + $(this).data('warn');

		bootbox.confirm("<strong>Are you sure?</strong>" + warn, function(result) {
			if (result) {
				location = href;
			}
		});
	});



	// Parse the data from an inline table using the Highcharts Data plugin
	$('#wind').highcharts({
			data: {
					table: 'freq',
					startRow: 1,
					endRow: 9,
					endColumn: 7
			},

			chart: {
					polar: true,
					type: 'column'
			},

			title: {
					text: 'Wind Direction and Wind Speed'
			},

			subtitle: {
					text: 'Averaged Data of all time'
			},

			pane: {
					size: '90%'
			},

			legend: {
					align: 'right',
					verticalAlign: 'top',
					y: 100,
					layout: 'vertical'
			},

			xAxis: {
					tickmarkPlacement: 'on'
			},

			yAxis: {
					min: 0,
					endOnTick: false,
					showLastLabel: true,
					title: {
							text: 'Frequency (%)'
					},
					labels: {
							formatter: function () {
									return this.value + '%';
							}
					},
					reversedStacks: false
			},

			tooltip: {
					valueSuffix: '%'
			},

			plotOptions: {
					series: {
							stacking: 'normal',
							shadow: false,
							groupPadding: 0,
							pointPlacement: 'on'
					}
			}
	});
});