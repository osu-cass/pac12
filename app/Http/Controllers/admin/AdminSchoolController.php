<?php

class AdminSchoolController extends AdminCrudController {

    public $model = 'School';
    public $plural = 'schools';
    public $singular = 'school';

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = $this->plural;
    }

    public function validate_rules($id = null)
    {
        return array(
            'url' => 'required',
        );
    }
}