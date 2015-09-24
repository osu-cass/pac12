<?php
class Badge extends Eloquent {

	public static function columns()
	{
		return array(
			'name',
			'description',
			'icon',
			'category',
			'minutes',
		);
	}
}