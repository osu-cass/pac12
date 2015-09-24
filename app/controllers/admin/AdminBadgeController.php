<?php

class AdminBadgeController extends AdminCrudController {

	public $model = 'Badge';
	public $plural = 'badges';
	public $singular = 'badge';

	function __construct()
	{
		parent::__construct();
		$this->data['active_page'] = $this->plural;
	}

	public function validate_rules($id = null)
	{
		return array(
//			'name' => 'required',
//			'description' => 'required',
		);
	}
	public function validate_custom(&$errors)
	{
		return array();
	}

	public function index()
	{
		return $this->index_searchable(array('name'));
	}
}