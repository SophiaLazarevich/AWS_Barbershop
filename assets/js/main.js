(function (window) {

})(window);

$(function() {
	if ($.jGrowl) {
		$.jGrowl.defaults.pool = 3;
		$.jGrowl.defaults.life = 5000;
		$.jGrowl.defaults.closerTemplate = '<div>закрыть всё</div>';
	}

	var getNotification = function(method, tablename, action, id) {
		$
			.ajax({
				type : method,
				url  : '/api/' + tablename + '/' + action + '/' + id + '/'
			})
			.done(function (html) {
				$.jGrowl(html, {sticky: true});
			})
			.fail(function (error) {
				errorText = error.responseText;
				$.jGrowl(errorText, {
					sticky     : true,
					beforeOpen : function(event) {
						$(this)
							.find('.jGrowl-message')
							.removeClass('jGrowl-message')
							.addClass('jGrowl-error')
						;
					}
				})
			})
		;
	}

	$(document).on(
		'click',
		'a[data-action]',
		function (e) {
			switch ($(this).data('action')) {
				case 'edit':
					// getNotification($(this).data('id'), $(this).data('action'));
					break;
				case 'delete':
					if (confirm("Удалить запись?")) {
						getNotification(
							'DELELE',
							$(this).data('table'),
							$(this).data('action'),
							$(this).data('id')
						);
					}
					break;
				default:
					getNotification(
						'GET',
						$(this).data('table'),
						$(this).data('action'),
						$(this).data('id')
					);
					break;
			}

			e.preventDefault();
		}
	)
});