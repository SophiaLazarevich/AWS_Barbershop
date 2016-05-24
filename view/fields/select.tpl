{
	"type"  : "div",
	"class" : "form-group",
	"html"  : [
		{
			"type"  : "label",
			"for"   : "t",
			"class" : "col-sm-{{labelWidth}} control-label",
			"html"  : "{{labelName}}"
		},
		{
			"type"  : "div",
			"class" : "col-sm-{{fieldWidth}}",
			"html"  : [
				{
					"type"    : "select",
					"id"      : "{{fieldId}}",
					"name"    : "{{fieldName}}",
					"class"   : "form-control",
					"options" : {
						"0" : "Выбрать",
						"1" : "короткие",
						"2" : "средняя длина",
						"3" : "длинные"
					}
				}
			]
		}
	]
},
