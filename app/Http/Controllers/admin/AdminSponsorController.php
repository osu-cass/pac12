<?php

class AdminSponsorController extends AdminCrudController {

    public $model = 'Sponsor';
    public $plural = 'sponsors';
    public $singular = 'sponsor';

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = $this->plural;
    }

    public function validate_rules($id = null)
    {
        return array(
            'name' => 'required',
            //'url' => 'required',
        );
    }

    public function validate_custom(&$errors)
    {
        $published_start = Input::get('published_start');
        $published_end = Input::get('published_end');
        if (Input::get('published_range') && $published_end && strtotime($published_start) >= strtotime($published_end)) {
            $errors[] = 'The publication end time must come after the start time.';
        } else if (!Input::get('published_range')) {
            // Reset these so that we won't ever get snagged by an impossible range
            // if the user has collapsed the publication range expander.
            $published_start = $published_end = 0;
        }

        return array(
            'published'         => Input::get('published') ? 1 : 0,
            'published_range'   => Input::get('published_range') ? 1 : 0,
            'published_start'   => $published_start,
            'published_end'     => $published_end,
        );
    }
}