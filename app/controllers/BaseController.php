<?php

class BaseController extends Controller {

	protected $data = array(
		'active_page' => '', // Used for highlighting the header menu link for the current active page
		'error' => array(),
		'success' => array(),
		'mobile' => false,
	);
	protected $preva;
	protected $mobile = false;

	function __construct()
	{
		$detect = new Mobile_Detect;
		if (($detect->isMobile() || Input::get('mobile')) && !Input::get('desktop')) {
			$this->mobile = true;
			$this->data['mobile'] = true;
		}

		// Used for alerting the user
		if (Session::has('errors')) {
			foreach(Session::get('errors')->all() as $message) {
				$this->data['error'][] = $message;
			}
		}
		if (Session::has('success')) {
			$this->data['success'][] = Session::get('success');
		}

		/*if (Auth::check()) {
			$this->preva = new Preva;
			$this->preva->token = Auth::user()->token;
		}*/
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}