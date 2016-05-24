{
	"type"  : "div",
	"class" : "form-group",
	"html"  : [
		{
			"type"  : "label",
			"for"   : "{{id}}",
			"class" : "col-sm-{{labelWidth}} control-label",
			"html"  : "{{labelName}}"
		},
		{
			"type"  : "div",
			"class" : "col-sm-{{fieldWidth}}",
			"html"  : [
				{
					"type"  : "span",
					"id"    : "{{id}}",
					"class" : "form-text",
					"html"  : "Присваивается автоматически"
				}
			]
		}
	]
},
