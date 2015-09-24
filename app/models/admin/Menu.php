<?php

class Menu extends Eloquent {

	protected $softDelete = true;

	///////////////////////////////////////////////
	//               Relationships               //
	///////////////////////////////////////////////
	public function menuItems()
	{
		return $this->hasMany('MenuItem')->orderBy('order', 'asc');
	}
	public function language()
	{
		return $this->belongsTo('Language');
	}


	///////////////////////////////////////////////
	//               View-Related                //
	///////////////////////////////////////////////
	public static function display($name, $language)
	{
		$menu = Menu::with('menuItems')->where('language_id', $language->id)->where('name', $name)->firstOrFail();

		$models = Menu::get_models($menu->menuItems);

		foreach ($models as $model) {
			echo '
				<li>
					<a href="' . $model->link() . '">
						' . $model->name() . '
					</a>
				</li>
			';
		}
	}

	///////////////////////////////////////////////
	//                  Other                    //
	///////////////////////////////////////////////
	/**
	 * Get the models referenced by the menu links.
	 * MenuItems reference foreign models with foreign keys.
	 * (fmodel, fid)  Because of this fact, we need to compile
	 * each of the models' groups of keys to optimize the DB calls into as few queries as
	 * possible by batching models together, then restructuring the result back into the proper order.
	 *
	 * @param Collection $menu_items - The collection of MenuItem models
	 * @return array - An ordered array of foreign models referenced by the passed MenuItems
	 */
	public static function get_models($menu_items)
	{
		// $fmodels will keep track of the order and batch together the foreign keys of the foreign models.
		$fmodels = array();
		foreach ($menu_items as $menu_item) {
			$fmodels[$menu_item->fmodel][$menu_item->order] = $menu_item->fid;
		}

		// Now, we take those batched groups of IDs and perform a single query for each model.
		// Then place the results into $models (the final, ordered array which we return)
		$models = array();
		foreach ($fmodels as $fmodel=>$ids) {
			$temp_models = $fmodel::with('language')->whereIn('id', $ids)->get();

			foreach ($ids as $order=>$id) {
				$models[$order] = $temp_models->find($id);
			}
		}

		return $models;
	}

}

?>