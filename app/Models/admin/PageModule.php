<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class PageModule extends Eloquent {

    use SoftDeletes;

    protected $table = 'pages_modules';
}
