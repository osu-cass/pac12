<?php

class Time extends Eloquent {
    public $timestamps = false;

    public function share_text()
    {
        return $this->date.' '.$this->activity().' '.$this->minutes.' minutes';
    }

    public function url()
    {
        return URL::to('workout/' . $this->id);
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function types() {
        return array(
            'cardio' => 'Cardio',
            'strength' => 'Strength/Resistance Training',
            'mind' => 'Mind/Body',
            'sports' => 'Sports & Fitness',
            //'weight' => 'Body Weight Exercise',
        );
    }

    public function activity() {
        $activity = $this->activity;
        if(!$activity) {
            $types = $this->types();
            $activity = $types[$this->type];
        }
        return $activity;
    }
}
