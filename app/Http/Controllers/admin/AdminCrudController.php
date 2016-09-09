<?php

class AdminCrudController extends AdminBaseController {

    public $model = 'TeamMember';
    public $plural = 'members';
    public $singular = 'member';

    private function get_all_model()
    {
        $model = $this->model;

        if (in_array('SoftDeletes', class_uses($model))) {
            return $model::withTrashed();
        } else {
            return $model::all();
        }
    }

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $model = $this->model;
        $paginator = $model::paginate();
        $this->data[$this->plural] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->links();

        return View::make('admin.' . $this->plural . '.index', $this->data);
    }

    public function index_searchable($searchable = array())
    {
        $model = $this->model;
        $search = Input::get('search') ? urldecode(Input::get('search')) : null;

        if ($search) {
            $terms = explode(' ', $search);
            $paginator = $model::where(function($query) use ($terms, $searchable) {
                foreach ($terms as $term) {
                    $term = '%'.$term.'%';
                    foreach ($searchable as $column) {
                        $query->where($column, 'like', $term);
                    }
                }
            })->paginate();
        } else {
            $paginator = $model::paginate();
        }

        $this->data[$this->plural] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->links();
        $this->data['search'] = $search;
        return View::make('admin.' . $this->plural . '.index', $this->data);
    }

    public function add()
    {
        $this->data['action'] = 'add';
        return View::make('admin.' . $this->plural . '.add-or-edit', $this->data);
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

    public function edit($id)
    {
        $model = $this->model;
        $object = $model::findOrFail($id);
        $this->data[$this->singular] = $object;
        $this->data['action'] = 'edit';

        return View::make('admin.' . $this->plural . '.add-or-edit', $this->data);
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

    /**
     * Validate all input when adding or editing.
     *
     * @param array &$custom - This array is initialized by this function.  Its purpose is to
     *                          exclude certain columns that require intervention of some kind (such as
     *                          checkboxes because they aren't included in input on submission)
     * @param int $id - (Optional) ID of member beind edited
     * @return array - An array of error messages to show why validation failed
     */
    public function validate_input(&$custom, $id = null)
    {
        $errors = array();

        $validator = Validator::make(Input::all(), $this->validate_rules($id));
        if ($validator->fails()) {
            foreach($validator->messages()->all() as $error) {
                $errors[] = $error;
            }
        }

        $custom = $this->validate_custom($errors);

        return $errors;
    }

    public function validate_rules($id = null)
    {
        return array();
    }

    public function validate_custom(&$errors)
    {
        return array();
    }

    public function delete($id)
    {
        $model = $this->model;

        $object = $model::find($id);
        if (method_exists($object, 'pre_delete')) {
            $object->pre_delete();
        }
        $object->delete();

        return Redirect::to('admin/' . $this->plural)->with('success', '
            ' . $model . ' successfully deleted.
        ');
    }

    public function restore($id)
    {
        $model = $this->model;

        if (in_array('SoftDeletes', class_uses($model))) {
            $object = $model::withTrashed()->find($id);
            if (method_exists($object, 'pre_restore')) {
                $object->pre_restore();
            }
            $object->restore();

            return Redirect::to('admin/' . $this->plural)->with('success', '
                ' . $model . ' successfully restored.
            ');
        } else {
            return Redirect::to('admin/' . $this->plural)->with('note', '
                ' . $model . ' doesn\'t support soft deletion.
            ');
        }

    }

    public function hard_delete($id)
    {
        $model = $this->model;

        $object = $this->get_all_model()->find($id);
        if (method_exists($object, 'pre_hard_delete')) {
            $object->pre_hard_delete();
        }
        $object->forceDelete();

        return Redirect::to('admin/' . $this->plural)->with('success', '
            ' . $model . ' successfully deleted forever.
        ');
    }

}
