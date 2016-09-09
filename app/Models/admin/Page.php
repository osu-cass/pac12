<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Eloquent {

    use SoftDeletes;

    // Columns to update/insert on edit/add
    public static function columns()
    {
        return array(
            'language_id',
            'name',
            'url',
            'html',
            'js',
            'css',
            'title',
            'meta_description',
            'meta_keywords',
            'og_type',
            'og_image',
            'twitter_card',
            'twitter_image',
            'published',
            'published_range',
            'published_start',
            'published_end'
        );
    }

    ///////////////////////////////////////////////
    //               Relationships               //
    ///////////////////////////////////////////////
    public function changes()
    {
        return Change::where('fmodel', 'Page')
                     ->where('fid', $this->id)
                     ->with('user')
                     ->orderBy('created_at', 'DESC')
                     ->get();
    }

    public function modules()
    {
        return $this->hasMany('PageModule');
    }

    // All menu-linkable models must have a language associated
    public function language()
    {
        return $this->belongsTo('Language');
    }

    // Handling relationships in controller CRUD methods
    public function pre_delete()
    {
        MenuItem::where('fmodel', 'Page')
                ->where('fid', $this->id)
                ->delete();
    }
    public function pre_restore()
    {
        MenuItem::where('fmodel', 'Page')
                ->where('fid', $this->id)
                ->restore();
    }
    public function pre_hard_delete()
    {
        Change::where('fmodel', 'Page')
              ->where('fid', $this->id)
              ->delete();

        MenuItem::where('fmodel', 'Page')
                ->where('fid', $this->id)
                ->forceDelete();
    }

    ///////////////////////////////////////////////
    //               Menu Linkable               //
    ///////////////////////////////////////////////
    // Menu link related methods - all menu-linkable models must have these
    // NOTE: Always pull models with their languages initially if you plan on using these!
    // Otherwise, you're going to be performing repeated queries.  Naughty.
    public function link()
    {
        return URL::to($this->url);
    }
    public function link_edit()
    {
        return URL::to('admin/pages/edit/' . $this->id);
    }
    public function name()
    {
        return $this->name;
    }
    public function name_full($exclude_language = false)
    {
        if ($exclude_language) return $this->name;
        return $this->language->name . ' | ' . $this->name;
    }
    public function name_module()
    {
        return 'Page';
    }
    public static function drop_down($exclude_language = false)
    {
        $pages = Page::orderBy('language_id')->get();
        $arr = array();
        foreach ($pages as $page) {
            $arr[$page->id] = $page->name_full($exclude_language);
        }
        return $arr;
    }

    ///////////////////////////////////////////////
    //                View-Related               //
    ///////////////////////////////////////////////
    public function meta_html()
    {
        $html = '';
        if ($this->title) {
            $html .= '<meta name="og:title" content="' . $this->title . '" />' . "\n";
            $html .= '<meta name="twitter:title" content="' . $this->title . '" />' . "\n";
        }
        if ($this->meta_description) {
            $html .= '<meta name="description" content="' . $this->meta_description . '" />' . "\n";
            $html .= '<meta name="og:description" content="' . $this->meta_description . '" />' . "\n";
            $html .= '<meta name="twitter:description" content="' . $this->meta_description . '" />' . "\n";
        }
        if ($this->meta_keywords) {
            $html .= '<meta name="keywords" content="' . $this->meta_keywords . '" />' . "\n";
        }
        if ($this->url) {
            $html .= '<meta name="og:url" content="' . $this->link() . '" />' . "\n";
            $html .= '<meta name="twitter:url" content="' . $this->link() . '" />' . "\n";
        }
        if ($this->og_type) {
            $html .= '<meta name="og:type" content="' . $this->og_type . '" />' . "\n";
        }
        if ($this->og_image) {
            $html .= '<meta name="og:image" content="' . $this->og_image . '" />' . "\n";
        }
        if ($this->twitter_card) {
            $html .= '<meta name="twitter:card" content="' . $this->twitter_card . '" />' . "\n";
        }
        if ($this->twitter_image) {
            $html .= '<meta name="twitter:image" content="' . $this->twitter_image . '" />' . "\n";
        }
        return $html;
    }

    public function is_published()
    {
        if ((
                $this->published_range &&
                (strtotime($this->published_start) > time() || strtotime($this->published_end) < time()) &&
                !Session::get('admin')
            ) || (
                !$this->published_range &&
                !$this->published &&
                !Session::get('admin')
            )) return false;
        return true;
    }

    public function get_module_by_number($number)
    {
        $modules = $this->modules;

        foreach ($modules as $module) {
            if ($module->number == $number) return $module->html;
        }
        return false;
    }
}
