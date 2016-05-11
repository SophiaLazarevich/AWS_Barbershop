<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Парикнахер ИТИТЬ</title>
	<style>
		html, body {
			margin: 0;
			padding: 0;
			font-family: Tahoma;
		}

		table {
			font-size: 14px;
			margin: 20px;
			border: 4px solid grey;
			border-collapse: collapse;
		}

		tr {
			margin: 20px;
		}

		td { 
			padding: 7px 15px;
		}

		td:nth-child(1) {
			text-align: center;
		}

		.form-update {
			position: absolute;
			top: 20px;
			right: 20px;
			border: 4px solid grey;
			padding: 10px;
		}

		.form-update > h2 {
			margin: 5px 0;
		}
	</style>
</head>
<body>
	{{customer}}
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript">
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
	</script>
</body>
</html>