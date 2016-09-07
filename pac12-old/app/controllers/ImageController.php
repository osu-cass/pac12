<?php
class ImageController extends BaseController {

	public function gallery()
	{
		return View::make('pages.gallery', $this->data);
	}

	public function upload()
	{
		$rules = array(
			'image'		=> 'required|image'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('gallery')->withInput()->withErrors($validator);
		}
		$file = Input::file('image');
		if ($file->getSize() > 3000000) {
			return Redirect::to('/')->withInput()->withErrors('The image must be less than 3mb large.');
		}

		do {
			$file_name = uniqid() . '.' . $file->getClientOriginalExtension();
			$file_path = Image::path($file_name);
		} while (file_exists($file_path));

		$file->move(Image::path(), $file_name);
		$image = new Image;
		$image->user_id = Auth::user()->id;
		$image->name = $file_name;
		$image->save();
		return Redirect::to('gallery');
	}

	public function upload_challenge()
	{
		$id = Input::get('challenge_id');
		$rules = array(
			'image'		=> 'required|image'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('/admin/challenges/edit/' . $id)->withInput()->withErrors($validator);
		}
		$file = Input::file('image');
		if ($file->getSize() > 3000000) {
			return Redirect::to('/admin/challenges/edit/' . $id)->withInput()->withErrors('The image must be less than 3mb large.');
		}

		do {
			$file_name = uniqid() . '.' . $file->getClientOriginalExtension();
			$file_path = Image::path($file_name);
		} while (file_exists($file_path));

		$file->move(Image::path(), $file_name);
		$image = new Image;

		$id = Input::get('challenge_id');
		$image->challenge_id = $id;
		$image->name = $file_name;
		$image->user_id = 1;
		$image->save();
		return Redirect::to('/admin/challenges/edit/' . $id);
	}

}