{
	"type"  : "div",
	"class" : "form-group",
	"html"  : [
		{
			"type"  : "label",
			"for"   : "b",
			"class" : "col-sm-{{labelWidth}} control-label",
			"html"  : "{{labelName}}"
		},
		{
			"type"  : "div",
			"class" : "col-sm-{{fieldWidth}}",
			"html"  : [
				{
					"type"  : "input",
					"id"    : "{{fieldId}}",
					"name"  : "{{fieldName}}",
					"class" : "form-control",
					"value" : "{{fieldValue}}"
				}
			]
		}
	]
},
