<?php
/**
* 
*/
class UserTemplate {
	public $db              = null;
	public $router          = null;
	public $loader          = null;
	protected $table        = null;
	protected $query        = null;
	protected $view         = null;
	protected $output       = null;
	protected $placeholders = null;

	function __construct($db, $router, $loader) {
		$this->db     =& $db;
		$this->router =& $router;
		$this->loader =& $loader;

		$this->output = !empty($view)
			? $this->loader->loadView($view)
			: $this->loader->loadView('index');
	}

	public function form() {
		return <<< EOT
<script type="text/javascript">
	$(function() {
		$.dform.options.prefix = null;

		$('#modal').dform({
			'type'  : 'div',
			'class' : 'fade',
			'html'  : [
				{
					'type'  : 'div',
					'class' : 'modal-dialog',
					'html'  : [
						{
							'type'  : 'div',
							'class' : 'modal-content',
							'html'  : [
								{
									'type'  : 'div',
									'class' : 'modal-header',
									'html'  : [
										{
											'type'         : 'button',
											'class'        : 'close',
											'data-dismiss' : 'modal',
											'area-label'   : 'Закрыть',
											'html'         : [
												{
													'type'        : 'span',
													'aria-hidden' : 'true',
													'html'        : '×'
												}
											]
										},
										{
											'type'  : 'h4',
											'class' : 'modal-title',
											'html'  : 'Добавить'
										}
									]
								},
								{
									'type'  : 'div',
									'class' : 'modal-body',
									'html'  : [
										{
											'type'   : 'form',
											'class'  : 'form-horizontal',
											'action' : '',
											'method' : 'post',
											'html'   : [
												{
													'type'  : 'div',
													'class' : 'form-group',
													'html'  : [
														{
															'type'  : 'label',
															'for'   : 'number',
															'class' : 'col-sm-2 control-label',
															'html'  : '№'
														},
														{
															'type'  : 'div',
															'class' : 'col-sm-10',
															'html'  : [
																{
																	'type'  : 'span',
																	'id'    : 'number',
																	'class' : 'form-text',
																	'html'  : 'Присваивается автоматически'
																}
															]
														}
													]
												},
												{
													'type'  : 'div',
													'class' : 'form-group',
													'html'  : [
														{
															'type'  : 'label',
															'for'   : 'b',
															'class' : 'col-sm-2 control-label',
															'html'  : 'ФИО'
														},
														{
															'type'  : 'div',
															'class' : 'col-sm-10',
															'html'  : [
																{
																	'type'  : 'input',
																	'id'    : 'b',
																	'name'  : 'b',
																	'class' : 'form-control',
																	'html'  : ''
																}
															]
														}
													]
												},
												{
													'type'  : 'div',
													'class' : 'form-group',
													'html'  : [
														{
															'type'  : 'label',
															'for'   : 't',
															'class' : 'col-sm-2 control-label',
															'html'  : 'Длина волос'
														},
														{
															'type'  : 'div',
															'class' : 'col-sm-10',
															'html'  : [
																{
																	'type'    : 'select',
																	'id'      : 't',
																	'name'    : 't',
																	'class'   : 'form-control',
																	'options' : {
																		0 : 'Выбрать',
																		1 : 'короткие',
																		2 : 'средняя длина',
																		3 : 'длинные'
																	}
																}
															]
														}
													]
												},
												{
													'type'  : 'div',
													'class' : 'form-group',
													'html'  : [
														{
															'type'  : 'label',
															'for'   : 'a',
															'class' : 'col-sm-2 control-label',
															'html'  : 'Возраст'
														},
														{
															'type'  : 'div',
															'class' : 'col-sm-10',
															'html'  : [
																{
																	'type'  : 'number',
																	'id'    : 'a',
																	'name'  : 'a',
																	'class' : 'form-control',
																	'html'  : ''
																}
															]
														}
													]
												},
											]
										}
									]
								},
								{
									'type'  : 'div',
									'class' : 'modal-footer',
									'html'  : [
										{
											'type'         : 'button',
											'class'        : 'btn btn-success',
											'html'         : '<i class="glyphicon glyphicon-ok"></i> Сохранить'
										},
										{
											'type'         : 'button',
											'class'        : 'btn btn-danger',
											'data-dismiss' : 'modal',
											'html'         : '<i class="glyphicon glyphicon-remove"></i> Отмена'
										}
									]
								}
							]
						},
					]
				},
			]
		});
	});
</script>
EOT;
	}

	public function controller() {
		return $this->render();
	}

	public function render() {
		$this->output  = $this->loader->setPlaceholders($this->output, $this->placeholders);
		$this->output .= $this->loader->loadView('form/edit');

		print $this->output . $this->form();
	}
}
