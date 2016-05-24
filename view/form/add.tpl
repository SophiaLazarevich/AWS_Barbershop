{
	"type"  : "div",
	"class" : "fade",
	"html"  : [
		{
			"type"  : "div",
			"class" : "modal-dialog",
			"html"  : [
				{
					"type"  : "div",
					"class" : "modal-content",
					"html"  : [
						{
							"type"  : "div",
							"class" : "modal-header",
							"html"  : [
								{
									"type"         : "button",
									"class"        : "close",
									"data-dismiss" : "modal",
									"area-label"   : "Закрыть",
									"html"         : [
										{
											"type"        : "span",
											"aria-hidden" : "true",
											"html"        : "×"
										}
									]
								},
								{
									"type"  : "h4",
									"class" : "modal-title",
									"html"  : "{{title}}"
								}
							]
						},
						{
							"type"  : "div",
							"class" : "modal-body",
							"html"  : [
								{
									"type"   : "form",
									"class"  : "form-horizontal",
									"action" : "{{action}}",
									"method" : "{{method}}",
									"html"   : [{{fields}}]
								}
							]
						},
						{
							"type"  : "div",
							"class" : "modal-footer",
							"html"  : [
								{
									"type"         : "button",
									"class"        : "btn btn-success",
									"html"         : "<i class=\"glyphicon glyphicon-ok\"></i> Сохранить"
								},
								{
									"type"         : "button",
									"class"        : "btn btn-danger",
									"data-dismiss" : "modal",
									"html"         : "<i class=\"glyphicon glyphicon-remove\"></i> Отмена"
								}
							]
						}
					]
				}
			]
		}
	]
}