<?php

class MenuItem extends Eloquent {

	protected $table = 'menus_items';

	protected $softDelete = true;

	///////////////////////////////////////////////
	//               Relationships               //
	///////////////////////////////////////////////
	public function menu()
	{
		return $this->belongsTo('Menu');
	}

	///////////////////////////////////////////////
	//                   Other                   //
	///////////////////////////////////////////////
	/**
	 * Get foreign model item (an instance of the object that the MenuItem links to)
	 */
	public function item()
	{
		$fmodel = $this->fmodel;
		return $fmodel::find($this->fid);
	}

}