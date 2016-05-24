$(function() {
	$(document).on(
		'click',
		'a',
		function (e) {
			switch ($(this).data('action')) {
				case 'edit': break;
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
								$(document.body).append(html);
							})
						;
					}

					break;
			}

			e.preventDefault();
		}
	)
});