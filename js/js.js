$(document).ready(function(){
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

	$(function(){
  		$.tablesorter.themes.bootstrap = {
			// these classes are added to the table. To see other table classes available,
			// look here: http://getbootstrap.com/css/#tables
			table        : 'table table-bordered',
			caption      : 'caption',
			// header class names
			header       : 'bootstrap-header', // give the header a gradient background (theme.bootstrap_2.css)
			sortNone     : '',
			sortAsc      : '',
			sortDesc     : '',
			active       : '', // applied when column is sorted
			hover        : '', // custom css required - a defined bootstrap style may not override other classes
			// icon class names
			icons        : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
			iconSortNone : 'glyphicon glyphicon-unsorted', // class name added to icon when column is not sorted
			iconSortAsc  : 'glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
			iconSortDesc : 'glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
			filterRow    : '', // filter row class; use widgetOptions.filter_cssFilter for the input/select element
			footerRow    : '',
			footerCells  : '',
			even         : '', // even row zebra striping
			odd          : ''  // odd row zebra striping
		}

		$("table").tablesorter({
			theme : "bootstrap",
			widthFixed: true,
			headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
			// widget code contained in the jquery.tablesorter.widgets.js file
			// use the zebra stripe widget if you plan on hiding any rows (filter widget)
			widgets : [ "uitheme", "filter", "zebra" ],
			widgetOptions : {
				// using the default zebra striping class name, so it actually isn't included in the theme variable above
				// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
				zebra : ["even", "odd"],
				// reset filters button
				filter_reset : ".reset",
				// extra css class name (string or array) added to the filter element (input or select)
				filter_cssFilter: "form-control",
				// set the uitheme widget to use the bootstrap theme class names
				// this is no longer required, if theme is set
				// ,uitheme : "bootstrap"
			}
		})
		.tablesorterPager({
			container: $(".ts-pager"),
			cssGoto: '.pagenum',
			removeRows: false,
			output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
		});
		$('#stationsTable').trigger('sorton', [ [[4,1]] ]);
		$('#stationData').trigger('sorton', [ [[0,1]] ]);
		$('#usersTable').trigger('sorton', [ [[3,1]] ]);
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
});