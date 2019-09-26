$(document).foundation();

$('#toggle-navigation').on('touchstart, click', function(e) {
	e.stopPropagation();
	
	if ($('#main-navigation').hasClass('is-opened')) {
		$(this).removeClass('is-opened');

		$('#main-navigation').removeClass('is-opened');

	} else {
		$(this).addClass('is-opened');

		$('#main-navigation').addClass('is-opened');
	}
});


$(document).on('click', '.button-area', function() {
	var url = $(this).attr('data-url');

	console.log(url);

	$.ajax({
		url: url,
	}).done(function(data) {
			
			$('#area-modal').find('.grid-container').html(data);

			$('#area-modal').foundation('open');
	});
});

$('[data-interchange]').on('replaced.zf.interchange', function() {
	$(document).foundation();
});