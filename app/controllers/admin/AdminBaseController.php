<?php

class AdminBaseController extends BaseController {

	public $languages;

	function __construct()
	{
		parent::__construct();

		///////////////////////////////////////////////
		//                Languages                  //
		///////////////////////////////////////////////
		$this->languages = Language::all();
		$language_drop = array();
		foreach ($this->languages as $language) {
			$language_drop[$language->id] = $language->name;
		}
		$this->data['language_drop'] = $language_drop;
		$this->data['all_languages'] = $this->languages;
		$this->data['single_language'] = count($this->languages) == 1 ? true : false;

		// Handle the current active language
		if (!Session::get('language')) {
			Session::put('language', Language::primary()->id);
		}
		$this->data['active_language'] = $this->languages->find(Session::get('language'));

		///////////////////////////////////////////////
		//         Menu Link Creation Wizard         //
		///////////////////////////////////////////////
		// Place menu linkable models here
		$this->data['linkable_models'] = array(
			'Page' => array(
				'add' => URL::to('admin/pages/add')
			)
		);

		// Grab the menu we're currently working with when creating content
		// from the menu link wizard
		if (Session::has('menu_id')) {
			$this->data['menu_id'] = Session::get('menu_id');
		} else if (Input::old('menu_id')) {
			$this->data['menu_id'] = Input::old('menu_id');
		}
	}

	/**
	 * Handle adding new menu items when creating content (such as pages) from within the menu system.
	 *
	 * @param string $fmodel - Name of the model.
	 * @param int $fid - ID of the model.
	 * @return Redirect to the menu index with success message.
	 */
	protected function also_add_menu_item($fmodel, $fid)
	{
		$order = MenuItem::where('menu_id', Input::get('menu_id'))->count();
		$menu_item = new MenuItem;
		$menu_item->menu_id	= Input::get('menu_id');
		$menu_item->fmodel	= $fmodel;
		$menu_item->fid 	= $fid;
		$menu_item->order	= $order;
		$menu_item->save();
		return Redirect::to('admin/menus')->with('success', $fmodel . ' and menu link successfully created.');
	}

}