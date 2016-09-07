<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Eloquent {

    use SoftDeletes;

    protected $table = 'menus_items';

    ///////////////////////////////////////////////
    //               Relationships               //
    ///////////////////////////////////////////////
    public function menu()
    {
        return $this->belongsTo('Menu');
    }

    ///////////////////////////////////////////////
    //                   Other                   //
    ///////////////////////////////////////////////
    /**
     * Get foreign model item (an instance of the object that the MenuItem links to)
     */
    public function item()
    {
        $fmodel = $this->fmodel;
        return $fmodel::find($this->fid);
    }

}
