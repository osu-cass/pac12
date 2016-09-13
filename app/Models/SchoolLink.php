<?php

class SchoolLink extends Eloquent
{
    protected $table = 'school_links';

    public static function columns()
    {
        return array(
            'url',
        );
    }

}