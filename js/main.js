$(function() {
	if ($.jGrowl) {
		$.jGrowl.defaults.pool = 3;
		$.jGrowl.defaults.life = 5000;
	}

	$(document).on(
		'click',
		'a',
		function (e) {
			switch ($(this).data('action')) {
				case 'edit':
					$.post(
						'',
						{
							id:     $(this).data('id'),
							action: $(this).data('action')
						}
					)
						.done(function (html) {
							$.jGrowl(html, {sticky: true});
						})
					;

					break;
				case 'delete':
					if (confirm("Удалить запись?")) {
						$.post(
							'',
							{
								id:     $(this).data('id'),
								action: $(this).data('action')
							}
						)
							.done(function (html) {
								$.jGrowl(html, {sticky: true});
							})
						;
					}

					break;
			}

			e.preventDefault();
		}
	)
});