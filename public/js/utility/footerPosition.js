$( window ).load(function() {
		if (($(document).height()-$("#footer").height()) > $("#footer").position().top)
		{
			toper =($(document).height()-$("#footer").height())-5;
			$('#footer').css("top",toper);
		}
});