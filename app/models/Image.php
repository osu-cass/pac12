<?php

class Image extends Eloquent {

	///////////////////////////////////////////////
	//               Relationships               //
	///////////////////////////////////////////////
	public function user()
	{
		return $this->belongsTo('User')->withTrashed();
	}

	public function challenge()
	{
		return $this->belongsTo('Challenge')->withTrashed();
	}

	///////////////////////////////////////////////
	//                  Mutators                 //
	///////////////////////////////////////////////
	public function setUpdatedAt($value)
	{
		// Override - do nothing.  (We don't need this column, but we're still using the built-in timestamp
		// for created_at.)
	}

	///////////////////////////////////////////////
	//                    Other                  //
	///////////////////////////////////////////////
	public function url()
	{
		return URL::to('uploads/images/' . $this->name);
	}

	public static function path($append = '')
	{
		$ds = DIRECTORY_SEPARATOR;
		return base_path() . $ds . 'public' . $ds . 'uploads' . $ds . 'images' . $ds . $append;
	}
}