<?php

class Sponsor extends Eloquent {
	public static function columns()
	{
		return array(
			'name',
			'banner',
			'video',
			'description',
			'url',
			'published',
			'published_range',
			'published_start',
			'published_end',
		);
	}

	public function is_published()
	{
		if ((
				$this->published_range &&
				(strtotime($this->published_start) > time() || strtotime($this->published_end) < time())
				// !Session::get('admin')
			) || (
				!$this->published_range &&
				!$this->published 
				// !Session::get('admin')
			)) return false;
		return true;
	}
}