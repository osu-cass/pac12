<?php

class AdminChallengeController extends AdminCrudController {

    public $model = 'Challenge';
    public $plural = 'challenges';
    public $singular = 'challenge';

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = $this->plural;
    }

    public function validate_rules($id = null)
    {
        return array(
            'name' => 'required',
            'description' => 'required',
            'published_start' => 'required',
            'published_end' => 'required'

        );
    }
    public function validate_custom(&$errors)
    {
        return array();
    }

    public function index()
    {
        return $this->index_searchable(array('name'));
    }

    public function index_searchable($searchable = array())
    {
        $model = $this->model;

        $search = Input::get('search') ? urldecode(Input::get('search')) : null;
        $paginator = $model::orderBy('published_start', 'desc');

        if ($search) {
            $terms = explode(' ', $search);
            $paginator = $paginator->where(function($query) use ($terms, $searchable) {
                foreach ($terms as $term) {
                    $term = '%'.$term.'%';
                    foreach ($searchable as $column) {
                        $query->where($column, 'like', $term);
                    }
                }
            });
        }
        $paginator = $paginator->paginate();

        $this->data[$this->plural] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->links();
        $this->data['search'] = $search;
        return View::make('admin.' . $this->plural . '.index', $this->data);
    }

    public function attempt_add()
    {
        $model = $this->model;

        $errors = $this->validate_input($custom);
        if (count($errors)) {
            return Redirect::to('admin/' . $this->plural . '/add')->withInput()->withErrors($errors);
        }

        $object = new $model;
        foreach($model::columns() as $column) {
            $object->{$column} = isset($custom[$column]) ? $custom[$column] : Input::get($column);
        }
        $object->save();

        return Redirect::to('admin/' . $this->plural)->with('success', '
            ' . $model . ' successfully created.
        ');
    }

    public function attempt_edit($id)
    {
        $model = $this->model;

        $errors = $this->validate_input($custom, $id);
        if (count($errors)) {
            return Redirect::to('admin/' . $this->plural . '/edit/' . $id)->withInput()->withErrors($errors);
        }

        $object = $model::findOrFail($id);
        foreach ($model::columns() as $column) {
            $object->{$column} = isset($custom[$column]) ? $custom[$column] : Input::get($column);
        }
        $object->save();

        return Redirect::to('admin/' . $this->plural . '/edit/' . $id)->with('success', '
            ' . $model . ' successfully updated.
        ');
    }
}
