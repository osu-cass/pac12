<?php

class AdminLanguageController extends AdminBaseController {

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = 'languages';
    }

    public function index()
    {
        $paginator = Language::paginate();

        $this->data['languages'] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->render();

        return View::make('admin.languages.index', $this->data);
    }

    public function add()
    {
        $this->data['action'] = 'add';

        return View::make('admin.languages.add-or-edit', $this->data);
    }

    public function attempt_add()
    {
        $rules = array(
            'name' => 'required',
            'uri' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/languages/add')->withInput()->withErrors($validator);
        }

        $language = new Language;
        $language->name = Input::get('name');
        $language->uri  = Input::get('uri');
        $language->save();

        return Redirect::to('admin/languages')->with('success', '
            <p>Language successfully created.</p>
        ');
    }

    public function edit($id)
    {
        $this->data['language'] = Language::find($id);
        $this->data['action'] = 'edit';

        return View::make('admin.languages.add-or-edit', $this->data);
    }

    public function attempt_edit($id)
    {
        $language = Language::find($id);
        $language->name = Input::get('name');
        $language->uri  = Input::get('uri');
        $language->save();

        return Redirect::to('admin/languages')->with('success', '
            <p>Language successfully updated.</p>
        ');
    }

    public function hard_delete($id)
    {
        if ($id == $this->data['active_language']->id) {
            return Redirect::to('admin/languages/edit/' . $id)->withErrors('
                <p>You cannot delete the language you\'re currently editing.</p>
                <p>Switch to a different language before deleting this one.</p>
            ');
        }

        $language = Language::find($id);
        $language->pre_hard_delete();
        $language->forceDelete();
        return Redirect::to('admin/languages')->with('success', '
            <p>Language "' . $language->name . '" (and related content) successfully deleted forever.</p>
        ');
    }

    public function make_active($id)
    {
        $language = Language::findOrFail($id);
        Session::put('language', $language->id);
        return Redirect::to(URL::previous());
    }

}
