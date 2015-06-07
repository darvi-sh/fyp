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
});