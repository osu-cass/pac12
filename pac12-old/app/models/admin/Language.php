<?php

class Language extends Eloquent {

	///////////////////////////////////////////////
	//                  Other                    //
	///////////////////////////////////////////////
	/**
	 * Models with foreign keys (such as Pages and Menus) will be deleted by cascade.
	 * However, we still need to run any pre-deletion functions on these before that happens to
	 * delete any relations that don't cascade (such as MenuItems).
	 */
	public function pre_hard_delete() {
		$pages = Page::where('language_id', $this->id)->get();
		foreach ($pages as $page) {
			$page->pre_hard_delete();
		}
	}

	/**
	 * We need to have a primary language for usage in error handlers (404), etc.
	 */
	public static function primary() {
		return Language::where('uri', 'en')->first();
	}
}