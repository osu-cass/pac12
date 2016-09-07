<?php

class AdminUserController extends AdminBaseController {

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = 'users';
    }

    public function index()
    {
        $search = Input::get('search') ? urldecode(Input::get('search')) : null;

        $paginator = User::withTrashed();

        // Limit viewable types if not superadmin
        if (!Session::get('superadmin')) {
            $paginator->whereIn('type', array_keys($this->okay_types()));
        }

        if ($search) {
            $terms = explode(' ', $search);
            $paginator = $paginator->where(function($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = '%'.$term.'%';
                    $query->orWhere('email', 'like', $term)
                        ->orWhere('username', 'like', $term)
                        ->orWhere('school', 'like', $term);
                }
            });
        }
        $paginator = $paginator->paginate();

        $this->data['users'] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->links();
        $this->data['search'] = $search;

        return View::make('admin.users.index', $this->data);
    }

    public function add()
    {
        $this->data['okay_types'] = $this->okay_types();
        return View::make('admin.users.add', $this->data);
    }

    public function attempt_add()
    {
        $rules = array(
            'type'      => 'required|in:'.$this->okay_types_csv(),
            'email'     => 'required|email|unique:users',
            'username'  => 'between:4,16',
            'password'  => 'required|min:6|confirmed'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/users/add')->withInput()->withErrors($validator);
        }

        $user = new User;
        $user->type         = Input::get('type');
        $user->email        = Input::get('email');
        $user->username     = Input::get('username');
        $user->school       = Input::get('school');
        $user->password     = Hash::make(Input::get('password'));
        $user->save();

        return Redirect::to('admin/users')->with('success', 'User successfully created.');
    }

    public function edit($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $this->data['edit_user'] = $user;
        $this->data['okay_types'] = $this->okay_types();
        return View::make('admin.users.edit', $this->data);
    }

    public function attempt_edit($id)
    {
        $rules = array(
            'type'      => 'required|in:'.$this->okay_types_csv(),
            'email'     => 'required|email|unique:users,email,'.$id,
            'username'  => 'between:4,16'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/users/edit/'.$id)->withInput()->withErrors($validator);
        }

        $user = User::withTrashed()->find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $user->type         = Input::get('type');
        $user->email        = Input::get('email');
        $user->username     = Input::get('username');
        $user->school       = Input::get('school');
        $user->save();

        return Redirect::to('admin/users/edit/'.$id)->with('success', '
            <p>User successfully updated.</p>
            <p><a href="'.URL::to('admin/users').'">Return to Users</a></p>
        ');
    }

    public function attempt_edit_password($id)
    {
        $rules = array(
            'password'  => 'required|min:6|confirmed'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/users/edit/'.$id)->withInput()->withErrors($validator);
        }

        $user = User::withTrashed()->find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Redirect::to('admin/users/edit/'.$id)->with('success', '
            <p>User\'s password successfully reset.</p>
            <p><a href="'.URL::to('admin/users').'">Return to Users</a></p>
        ');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $user->delete();
        $user->profiles()->delete();
        return Redirect::to('admin/users')->with('success', '
            <p>User successfully deleted.</p>'/*.'<p><a href="'.URL::to('admin/users/restore/'.$user->id).'">Undo</a></p>'*/
        );
    }

    public function hard_delete($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $user->forceDelete();
        $user->profiles()->forceDelete();
        return Redirect::to('admin/users')->with('success', '
            <p>User successfully deleted forever.</p>
        ');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$this->okay_user($user)) {
            return Redirect::to('admin/users')->withErrors('You don\'t have permission to edit that user.');
        }

        $user->restore();
        $user->profiles()->restore();
        return Redirect::to('admin/users')->with('success', '
            <p>User successfully restored.</p>
        ');
    }


    ///////////////////////////////////////////////
    //              Permissions                  //
    ///////////////////////////////////////////////
    /**
     * Determine whether the current logged in user has permission to edit a specific user.
     *
     * @param User $user - The user being edited
     * @return bool
     */
    public function okay_user($user)
    {
        if (!Session::get('superadmin') && ($user->type == 'superadmin' || $user->type == 'admin')) return false;
        return true;
    }

    /**
     * Depending on the user's type (admin, superadmin) - what types can be assigned to other users in add / edit?
     *
     * @return array - Array of types that the current user can edit
     */
    public function okay_types()
    {
        $array = User::types_array();
        if (!Session::get('superadmin')) {
            unset($array['superadmin']);
            unset($array['admin']);
        }
        return $array;
    }

    /**
     * Same as okay_types(), but in a comma separated list (for use in the validator)
     *
     * @return string - Comma separated list of types that the current user can edit
     */
    public function okay_types_csv()
    {
        return implode(',', $this->okay_types());
    }

}
