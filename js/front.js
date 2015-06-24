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





	$('#temperature').highcharts({

		chart: {
			type: 'gauge',
			plotBackgroundColor: null,
			plotBackgroundImage: null,
			plotBorderWidth: 0,
			plotShadow: false
		},

		title: {
			text: 'Speedometer'
		},

		pane: {
			startAngle: -150,
			endAngle: 150,
			background: [{
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#FFF'],
						[1, '#333']
					]
				},
				borderWidth: 0,
				outerRadius: '109%'
			}, {
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#333'],
						[1, '#FFF']
					]
				},
				borderWidth: 1,
				outerRadius: '107%'
			}, {
				// default background
			}, {
				backgroundColor: '#DDD',
				borderWidth: 0,
				outerRadius: '105%',
				innerRadius: '103%'
			}]
		},

		// the value axis
		yAxis: {
			min: 10,
			max: 50,

			minorTickInterval: 'auto',
			minorTickWidth: 1,
			minorTickLength: 5,
			minorTickPosition: 'inside',
			minorTickColor: '#666',

			tickPixelInterval: 10,
			tickWidth: 2,
			tickPosition: 'inside',
			tickLength: 10,
			tickColor: '#666',
			labels: {
				step: 2,
				rotation: 'auto'
			},
			title: {
				text: 'Temperature (°C)'
			},
			plotBands: [{
				from: 10,
				to: 16,
				color: '#DF5353' // yellow
			}, {
				from: 16,
				to: 24,
				color: '#DDDF0D' // yellow
			}, {
				from: 24,
				to: 34,
				color: '#55BF3B' // green
			}, {
				from: 34,
				to: 38,
				color: '#DDDF0D' // yellow
			}, {
				from: 38,
				to: 50,
				color: '#DF5353' // red
			}]
		},

		series: [{
			name: 'Temperature',
			data: [30],
			tooltip: {
				valueSuffix: '(°C)'
			}
		}]

	},
			// Add some life
	function (chart) {
		if (!chart.renderer.forExport) {
			setInterval(function () {
				var point = chart.series[0].points[0],
						newVal,
						inc = Math.round((Math.random() - 0.5) * 2);

				newVal = point.y + inc;
				if (newVal < 10 || newVal > 50) {
						newVal = point.y - inc;
				}

				point.update(newVal);

			}, 3000);
		}
	});
});