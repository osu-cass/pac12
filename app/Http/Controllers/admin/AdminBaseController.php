<?php

class AdminBaseController extends BaseController {

    public $languages;

    function __construct()
    {
        parent::__construct();

        // Access to the session object in constructors was deprecated in Laravel 5.3
        $this->middleware(function ($request, $next) {
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

            return $next($request);
        });
    }

}
