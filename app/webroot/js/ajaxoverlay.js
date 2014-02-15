function ajaxDisplay(result) {
	$('#overlay-content').html(result);
	$('#overlay-bg').fadeIn();
	$('#overlay-content').fadeIn();
};
function hideOverlay(refresh) {
	$('#overlay-bg').fadeOut();
	$('#overlay-content').fadeOut();
	if (refresh) {
		location.reload();
	}
};

$(document).ready( function() {
	$('#overlay-bg').click(function() {
		$('#overlay-bg').fadeOut();
		$('#overlay-content').fadeOut();
	});
	$('a.ajax').click(function() {
		href = $(this).attr('href');
		//alert(href);
		$.ajax({url:href,success:ajaxDisplay});
		return false;
	});
});
