<?php
class Challenge extends Eloquent {

	public static function columns()
	{
		return array(
			'name',
			'description',
			'published',
			'published_start',
			'published_end'
		);
	}

	public function images()
	{
		return $this->hasMany('Image');
	}
}