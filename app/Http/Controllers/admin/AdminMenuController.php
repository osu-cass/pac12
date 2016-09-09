<?php

class AdminMenuController extends AdminBaseController {

    function __construct()
    {
        parent::__construct();
        $this->data['active_page'] = 'menus';
    }

    public function index()
    {
        $paginator = Menu::withTrashed()->where('language_id', $this->data['active_language']->id)->with('menuItems')->paginate(5);

        $model_list = array();
        foreach ($this->data['linkable_models'] as $model=>$arr) {
            $model_list[$model] = $model;
        }

        $this->data['model_select'] = Form::select('fmodel', $model_list, null, array('id'=>'modelSelect', 'class' => 'form-control'));
        $this->data['menus'] = $paginator->getCollection();
        $appends = $_GET;
        unset($appends['page']);
        $this->data['links'] = $paginator->appends($appends)->links();

        return View::make('admin.menus.index', $this->data);
    }

    public function add()
    {
        $this->data['action'] = 'add';

        return View::make('admin.menus.add-or-edit', $this->data);
    }

    public function attempt_add()
    {
        $rules = array(
            'name' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/menus/add')->withInput()->withErrors($validator);
        }

        $menu = new Menu;
        $menu->language_id = Input::get('language_id');
        $menu->name = Input::get('name');
        $menu->save();

        return Redirect::to('admin/menus')->with('success', '
            Menu successfully created.
        ');
    }

    public function edit($id)
    {
        $this->data['menu'] = Menu::withTrashed()->find($id);
        $this->data['action'] = 'edit';

        return View::make('admin.menus.add-or-edit', $this->data);
    }

    public function attempt_edit($id)
    {
        $menu = Menu::withTrashed()->find($id);
        $menu->language_id  = Input::get('language_id');
        $menu->name         = Input::get('name');
        $menu->save();

        return Redirect::to('admin/menus')->with('success', '
            Menu successfully updated.
        ');
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return Redirect::to('admin/menus')->with('success', '
            Menu successfully deleted.
        ');
    }

    public function hard_delete($id)
    {
        $menu = Menu::withTrashed()->find($id);
        $menu->forceDelete();
        return Redirect::to('admin/menus')->with('success', '
            Menu successfully deleted forever.
        ');
    }

    public function restore($id)
    {
        $menu = Menu::withTrashed()->find($id);
        $menu->restore();
        return Redirect::to('admin/menus')->with('success', '
            Menu successfully restored.
        ');
    }

    public function item_add()
    {
        $menu_item = new MenuItem;
        $menu_item->order   = Input::get('order');
        $menu_item->menu_id = Input::get('menu_id');
        $menu_item->fmodel  = Input::get('fmodel');
        $menu_item->fid     = Input::get('fid');
        $menu_item->save();

        return Redirect::to('admin/menus')->with('success', '
            Link created.
        ');
    }

    /**
     * AJAX for reordering menu items
     */
    public function item_order()
    {
        $orders = Input::get('orders');
        $menu_items = MenuItem::whereIn('id', array_keys($orders))->get();
        foreach($menu_items as $menu_item) {
            $menu_item->order = $orders[$menu_item->id];
            //echo "Item: " . $menu_item->id . " | Order: " . $orders[$menu_item->id] . "\n";
            $menu_item->save();
        }
        return 1;
    }

    /**
     * AJAX for deleting menu items
     */
    public function item_delete()
    {
        $menu_item = MenuItem::find(Input::get('id'));
        $menu_item->forceDelete();  // Don't soft delete.  These are easy to rebuild.  Additionally, restoring pages
                                    // will restore all menu links for that page, so we don't want
                                    // deliberately deleted links resurfacing.
        return 1;
    }

    /**
     * AJAX for getting 'existing model' dropdown in menu link creation wizard.
     *
     * @return string - HTML of the select element
     */
    public function model_drop_down()
    {
        $model = Input::get('model');
        return Form::select('fid', $model::drop_down($this->data['single_language']), null, array('id'=>'thingSelect', 'class' => 'form-control'));
    }
}
