<?php

class School extends Eloquent {

    public static function columns() {
        return array(
            'url'
        );
    }

    public static function schools() {
        return School::pluck('name', 'id');
    }

    public static function reports() {
        return array(
            'University of Arizona' => array(
                'emails' => array(
                    'mschwitzky@email.arizona.edu'
                ),
                'users' => array()
            ),
            'Arizona State University' => array(
                'emails' => array(
                    'tamra.garstka@asu.edu',
                    'julie.kipper@asu.edu'
                ),
                'users' => array()
            ),
            'University of California, Berkeley' => array(
                'emails' => array(
                    'ecraypo@berkeley.edu',
                    'mweinber@berkley.edu'
                ),
                'users' => array()
            ),
            'University of Oregon' => array(
                'emails' => array(
                    'russellc@uoregon.edu'
                ),
                'users' => array()
            ),
            'Oregon State University' => array(
                'emails' => array(
                    'tina.clawson@oregonstate.edu'
                ),
                'users' => array()
            ),
            'Stanford University' => array(
                'emails' => array(
                    'sdipaolo@stanford.edu',
                    'rabair@stanford.edu',
                    'jbsexton@stanford.edu'
                ),
                'users' => array()
            ),
            'UCLA' => array(
                'emails' => array(
                    'waberbuch@recreation.ucla.edu',
                    'jandersen@recreation.ucla.edu'
                ),
                'users' => array()
            ),
            'University of Southern California' => array(
                'emails' => array(
                    'djcheung@saemail.usc.edu'
                ),
                'users' => array()
            ),
            'University of Washington' => array(
                'emails' => array(
                    'kbeth6@uw.edu'
                ),
                'users' => array()
            ),
            'Washington State University' => array(
                'emails' => array(
                    'ryan.savage@wsu.edu',
                    'joanne.greene@wsu.edu'
                ),
                'users' => array()
            ),
            'University of Colorado' => array(
                'emails' => array(
                    'nicole.larocque@colorado.edu',
                    'annie.mulvany@colorado.edu'
                ),
                'users' => array()
            ),
            'University of Utah' => array(
                'emails' => array(
                    'mlbohling@crs.utah.edu'
                ),
                'users' => array()
            )
        );
    }
}
