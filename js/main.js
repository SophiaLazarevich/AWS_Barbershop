(function (window) {

})(window);

$(function() {
	if ($.jGrowl) {
		$.jGrowl.defaults.pool = 3;
		$.jGrowl.defaults.life = 5000;
		$.jGrowl.defaults.closerTemplate = '<div>закрыть всё</div>';
	}

	var getNotification = function(id, action) {
		$
			.post('', {'id': id, 'action': action})
			.done(function (html) {
				$.jGrowl(html, {sticky: true});
			})
			.fail(function (html) {
				$.jGrowl(html, {
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
						getNotification($(this).data('id'), $(this).data('action'));
					}
					break;
				default:
					getNotification($(this).data('id'), $(this).data('action'));
					break;
			}

			e.preventDefault();
		}
	)
});