<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('total', function() {
    $totals = Total::all();
    foreach($totals as $total) {
        $count   = DB::table('times')->where('school', '=', $total->school)->count(DB::raw('DISTINCT user_id'));
        $minutes = DB::table('times')->where('school', '=', $total->school)->sum('minutes'); 
        $total->minutes  = $minutes;
        $total->students = $count;
        $total->save();
        echo $total->school . '-' . $count . '-' . $minutes . '<br>';
    }
    echo 'Done.';
});

///////////////////////////////////////////////
//                  Admin                    //
///////////////////////////////////////////////
Route::get('admin', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@index'
));

//------------------------
// AdminUserController
//------------------------
Route::get('admin/users', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@index'
));
Route::get('admin/users/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@add'
));
Route::post('admin/users/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@attempt_add'
));
Route::get('admin/users/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@edit'
));
Route::post('admin/users/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@attempt_edit'
));
Route::post('admin/users/password/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@attempt_edit_password'
));
Route::post('admin/users/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@delete'
));
Route::post('admin/users/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@hard_delete'
));
Route::get('admin/users/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminUserController@restore'
));

//------------------------
// AdminLanguageController - superadmin filters!
//------------------------
Route::get('admin/languages', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@index'
));
Route::get('admin/languages/add', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@add'
));
Route::post('admin/languages/add', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@attempt_add'
));
Route::get('admin/languages/edit/{id}', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@edit'
));
Route::post('admin/languages/edit/{id}', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@attempt_edit'
));
Route::post('admin/languages/hard-delete/{id}', array(
    'middleware' => 'superadmin',
    'uses' => 'AdminLanguageController@hard_delete'
));
// Anyone can change their active (editing) language... not just super admin
Route::get('admin/languages/make-active/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminLanguageController@make_active'
));

//------------------------
// AdminPageController
//------------------------
Route::get('admin/pages', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@index'
));
Route::get('admin/pages/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@add'
));
Route::post('admin/pages/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@attempt_add'
));
Route::get('admin/pages/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@edit'
));
Route::post('admin/pages/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@attempt_edit'
));
Route::post('admin/pages/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@delete'
));
Route::post('admin/pages/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@hard_delete'
));
Route::get('admin/pages/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@restore'
));
Route::post('admin/pages/copy', array(
    'middleware' => 'admin',
    'uses' => 'AdminPageController@copy'
));
Route::get('admin/pages/delete-module/{id}', array(
    'uses' => 'AdminPageController@delete_module'
));

//------------------------
// AdminChallengeController
//------------------------
Route::get('admin/challenges', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@index'
));
Route::get('admin/challenges/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@add'
));
Route::post('admin/challenges/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@attempt_add'
));
Route::get('admin/challenges/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@edit'
));
Route::post('admin/challenges/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@attempt_edit'
));
Route::post('admin/challenges/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@delete'
));
Route::post('admin/challenges/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@hard_delete'
));
Route::get('admin/challenges/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@restore'
));
Route::post('admin/challenges/copy', array(
    'middleware' => 'admin',
    'uses' => 'AdminChallengeController@copy'
));

//------------------------
// AdminSponsorsController
//------------------------
Route::get('admin/sponsors', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@index'
));
Route::get('admin/sponsors/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@add'
));
Route::post('admin/sponsors/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@attempt_add'
));
Route::get('admin/sponsors/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@edit'
));
Route::post('admin/sponsors/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@attempt_edit'
));
Route::post('admin/sponsors/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@delete'
));
Route::post('admin/sponsors/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@hard_delete'
));
Route::get('admin/sponsors/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@restore'
));
Route::post('admin/sponsors/copy', array(
    'middleware' => 'admin',
    'uses' => 'AdminSponsorController@copy'
));

//------------------------
// AdminBadgesController
//------------------------
Route::get('admin/badges', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@index'
));
Route::get('admin/badges/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@add'
));
Route::post('admin/badges/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@attempt_add'
));
Route::get('admin/badges/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@edit'
));
Route::post('admin/badges/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@attempt_edit'
));
Route::post('admin/badges/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@delete'
));
Route::post('admin/badges/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@hard_delete'
));
Route::get('admin/badges/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@restore'
));
Route::post('admin/badges/copy', array(
    'middleware' => 'admin',
    'uses' => 'AdminBadgeController@copy'
));

//------------------------
// AdminSchoolsController
//------------------------
Route::get('admin/schools', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@index'
));
Route::get('admin/schools/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@add'
));
Route::post('admin/schools/add', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@attempt_add'
));
Route::get('admin/schools/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@edit'
));
Route::post('admin/schools/edit/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@attempt_edit'
));
Route::post('admin/schools/delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@delete'
));
Route::post('admin/schools/hard-delete/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@hard_delete'
));
Route::get('admin/schools/restore/{id}', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@restore'
));
Route::post('admin/schools/copy', array(
    'middleware' => 'admin',
    'uses' => 'AdminSchoolController@copy'
));

//------------------------
// AdminReportController
//------------------------

Route::get('admin/reports', array(
    'middleware' => 'admin',
    'uses' => 'AdminReportController@main'
));

Route::get('admin/report/{date}', array(
    'middleware' => 'admin',
    'uses' => 'AdminReportController@daily'
));

Route::post('admin/report/range', array(
    'middleware' => 'admin',
    'uses' => 'AdminReportController@range'
));

///////////////////////////////////////////////
//                Front End                  //
///////////////////////////////////////////////

//------------------------
// UserController
//------------------------
Route::get('admin-signin', array(
    'middleware' => 'nonadmin',
    'uses' => 'UserController@admin_signin'
));
Route::post('admin-signin', array(
    'uses' => 'UserController@admin_attempt_signin'
));

// --------------
// User pages
// --------------
Route::get('account', array(
    'middleware' => 'auth',
    'uses' => 'UserController@account'
));
Route::post('account', array(
    'middleware' => 'auth',
    'uses' => 'UserController@account_edit'
));
Route::get('workouts', array(
    'middleware' => 'auth',
    'uses' => 'UserController@workouts'
));
Route::get('workout/{id}', array(
    'uses' => 'UserController@workout'
));
Route::get('log', array(
    'middleware' => 'auth',
    'uses' => 'UserController@log'
));
Route::get('gallery', array(
    'middleware' => 'auth',
    'uses' => 'ImageController@gallery'
));
Route::post('images/upload_challenge', array(
    'middleware' => 'auth',
    'uses' => 'ImageController@upload_challenge'
));
Route::post('images/upload', array(
    'middleware' => 'auth',
    'uses' => 'ImageController@upload'
));
Route::get('badges', array(
    'middleware' => 'auth',
    'uses' => 'UserController@get_badges'
));
Route::get('signin', array(
    'middleware' => 'guest',
    'uses' => 'UserController@signin'
));
Route::post('signin', array(
    'middleware' => 'guest',
    'uses' => 'UserController@attempt_signin'
));
Route::get('signin-fb', array(
    'middleware' => 'guest',
    'uses' => 'UserController@attempt_signin_fb'
));
Route::post('signup', array(
    'middleware' => 'guest',
    'uses' => 'UserController@attempt_signup'
));
Route::get('signup', array(
    'middleware' => 'guest',
    'uses' => 'UserController@signup'
));
Route::post('signup-fb', array(
    'middleware' => 'guest',
    'uses' => 'UserController@attempt_signup_fb'
));
Route::get('signup-fb', array(
    'middleware' => 'guest',
    'uses' => 'UserController@signup_fb'
));
Route::get('signup-preva', array(
    'middleware' => 'auth',
    'uses' => 'UserController@signup_preva'
));
Route::post('signup-preva', array(
    'middleware' => 'auth',
    'uses' => 'UserController@attempt_signup_preva'
));

Route::get('signout', 'UserController@signout');

Route::get('forgot-password', 'UserController@forgot_password');

Route::post('forgot-password', 'UserController@email_password_reset');

Route::get('password-reset/{token}', 'UserController@password_reset');

Route::post('change-password', 'UserController@password_change');

// --------------
// Workouts
// --------------
Route::post('post-time', array(
    'middleware' => 'auth',
    'uses' => 'UserController@post_time'
));

// --------------
// Pages
// --------------
Route::get('/', 'PageController@show');
Route::get('{url}/{section?}', 'PageController@show');
