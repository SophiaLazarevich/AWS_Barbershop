{
	"type"  : "div",
	"class" : "form-group",
	"html"  : [
		{
			"type"  : "label",
			"for"   : "a",
			"class" : "col-sm-{{labelWidth}} control-label",
			"html"  : "{{labelName}}"
		},
		{
			"type"  : "div",
			"class" : "col-sm-{{fieldWidth}}",
			"html"  : [
				{
					"type"  : "number",
					"id"    : "{{fieldId}}",
					"name"  : "{{fieldName}}",
					"class" : "form-control",
					"value" : "{{fieldValue}}"
				}
			]
		}
	]
}