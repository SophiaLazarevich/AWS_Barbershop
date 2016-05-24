$(function() {
	if ($.jGrowl) {
		$.jGrowl.defaults.pool = 3;
		$.jGrowl.defaults.life = 5000;
		$.jGrowl.defaults.closerTemplate = '<div>закрыть всё</div>';
	}

	if ($.dform) {
		$.dform.options.prefix = null;
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
				case 'add':
					// $
					// 	.ajax({
					// 		url      : '/api/' + $(this).data('table') + '/add/form/',
					// 		type     : 'GET',
					// 		dataType : 'JSON',
					// 	})
					// 	.done(function (html) {
					// 		$('#modalAdd').dform(html).modal('show');
					// 	})
					// ;
					$('#modalAdd')
						.html('')
						.dform('/api/' + $(this).data('table') + '/add/form/')
						.modal('show')
					;
					// $(document).on('show.bs.modal', function (e) {
					// 	if (!data) return;
					// 		console.log(e);
					// 	e.preventDefault()
					// })
					break;
				case 'edit':
					// getNotification($(this).data('id'), $(this).data('action'));
					break;
				case 'delete':
					if (confirm("Удалить запись?")) {
						getNotification(
							'DELETE',
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