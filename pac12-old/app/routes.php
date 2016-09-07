<?php
//------------------------
// Debug / Errors
//------------------------
App::before(function ($request) {
	//Session::flush();
	//ToolBelt::print_session();
	//ToolBelt::debug(Auth::user());
	//ToolBelt::debug(Input::all());
});
App::after(function($request, $response) {
	//ToolBelt::print_queries();
});
App::missing(function($exception) {
	return Response::make(View::make('errors.404'), 404);
});

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
	'before' => 'admin',
	'uses' => 'AdminPageController@index'
));

//------------------------
// AdminUserController
//------------------------
Route::get('admin/users', array(
	'before' => 'admin',
	'uses' => 'AdminUserController@index'
));
Route::get('admin/users/add', array(
	'before' => 'admin',
	'uses' => 'AdminUserController@add'
));
Route::post('admin/users/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminUserController@attempt_add'
));
Route::get('admin/users/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminUserController@edit'
));
Route::post('admin/users/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminUserController@attempt_edit'
));
Route::post('admin/users/password/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminUserController@attempt_edit_password'
));
Route::post('admin/users/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminUserController@delete'
));
Route::post('admin/users/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminUserController@hard_delete'
));
Route::get('admin/users/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminUserController@restore'
));

//------------------------
// AdminLanguageController - superadmin filters!
//------------------------
Route::get('admin/languages', array(
	'before' => 'superadmin',
	'uses' => 'AdminLanguageController@index'
));
Route::get('admin/languages/add', array(
	'before' => 'superadmin',
	'uses' => 'AdminLanguageController@add'
));
Route::post('admin/languages/add', array(
	'before' => array('superadmin', 'csrf'),
	'uses' => 'AdminLanguageController@attempt_add'
));
Route::get('admin/languages/edit/{id}', array(
	'before' => 'superadmin',
	'uses' => 'AdminLanguageController@edit'
));
Route::post('admin/languages/edit/{id}', array(
	'before' => array('superadmin', 'csrf'),
	'uses' => 'AdminLanguageController@attempt_edit'
));
Route::post('admin/languages/hard-delete/{id}', array(
	'before' => array('superadmin', 'csrf'),
	'uses' => 'AdminLanguageController@hard_delete'
));
// Anyone can change their active (editing) language... not just super admin
Route::get('admin/languages/make-active/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminLanguageController@make_active'
));

//------------------------
// AdminPageController
//------------------------
Route::get('admin/pages', array(
	'before' => 'admin',
	'uses' => 'AdminPageController@index'
));
Route::get('admin/pages/add', array(
	'before' => 'admin',
	'uses' => 'AdminPageController@add'
));
Route::post('admin/pages/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminPageController@attempt_add'
));
Route::get('admin/pages/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminPageController@edit'
));
Route::post('admin/pages/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminPageController@attempt_edit'
));
Route::post('admin/pages/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminPageController@delete'
));
Route::post('admin/pages/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminPageController@hard_delete'
));
Route::get('admin/pages/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminPageController@restore'
));
Route::post('admin/pages/copy', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminPageController@copy'
));
Route::get('admin/pages/delete-module/{id}', array(
	'uses' => 'AdminPageController@delete_module'
));

//------------------------
// AdminMenuController
//------------------------
Route::get('admin/menus', array(
	'before' => 'admin',
	'uses' => 'AdminMenuController@index'
));
Route::get('admin/menus/add', array(
	'before' => 'admin',
	'uses' => 'AdminMenuController@add'
));
Route::post('admin/menus/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminMenuController@attempt_add'
));
Route::get('admin/menus/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminMenuController@edit'
));
Route::post('admin/menus/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminMenuController@attempt_edit'
));
Route::post('admin/menus/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminMenuController@delete'
));
Route::post('admin/menus/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminMenuController@hard_delete'
));
Route::get('admin/menus/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminMenuController@restore'
));
Route::post('admin/menus/item-add', array(
	'before' => 'admin',
	'uses' => 'AdminMenuController@item_add'
));
Route::post('admin/menus/item-order', array( // AJAX
	'before' => 'admin',
	'uses' => 'AdminMenuController@item_order'
));
Route::post('admin/menus/item-delete', array( // AJAX
	'before' => 'admin',
	'uses' => 'AdminMenuController@item_delete'
));
Route::post('admin/menus/model-drop-down', array( // AJAX
	'before' => 'admin',
	'uses' => 'AdminMenuController@model_drop_down'
));


//------------------------
// AdminChallengeController
//------------------------
Route::get('admin/challenges', array(
	'before' => 'admin',
	'uses' => 'AdminChallengeController@index'
));
Route::get('admin/challenges/add', array(
	'before' => 'admin',
	'uses' => 'AdminChallengeController@add'
));
Route::post('admin/challenges/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminChallengeController@attempt_add'
));
Route::get('admin/challenges/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminChallengeController@edit'
));
Route::post('admin/challenges/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminChallengeController@attempt_edit'
));
Route::post('admin/challenges/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminChallengeController@delete'
));
Route::post('admin/challenges/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminChallengeController@hard_delete'
));
Route::get('admin/challenges/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminChallengeController@restore'
));
Route::post('admin/challenges/copy', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminChallengeController@copy'
));

//------------------------
// AdminSponsorsController
//------------------------
Route::get('admin/sponsors', array(
	'before' => 'admin',
	'uses' => 'AdminSponsorController@index'
));
Route::get('admin/sponsors/add', array(
	'before' => 'admin',
	'uses' => 'AdminSponsorController@add'
));
Route::post('admin/sponsors/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSponsorController@attempt_add'
));
Route::get('admin/sponsors/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminSponsorController@edit'
));
Route::post('admin/sponsors/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSponsorController@attempt_edit'
));
Route::post('admin/sponsors/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSponsorController@delete'
));
Route::post('admin/sponsors/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSponsorController@hard_delete'
));
Route::get('admin/sponsors/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminSponsorController@restore'
));
Route::post('admin/sponsors/copy', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSponsorController@copy'
));

//------------------------
// AdminBadgesController
//------------------------
Route::get('admin/badges', array(
	'before' => 'admin',
	'uses' => 'AdminBadgeController@index'
));
Route::get('admin/badges/add', array(
	'before' => 'admin',
	'uses' => 'AdminBadgeController@add'
));
Route::post('admin/badges/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminBadgeController@attempt_add'
));
Route::get('admin/badges/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminBadgeController@edit'
));
Route::post('admin/badges/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminBadgeController@attempt_edit'
));
Route::post('admin/badges/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminBadgeController@delete'
));
Route::post('admin/badges/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminBadgeController@hard_delete'
));
Route::get('admin/badges/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminBadgeController@restore'
));
Route::post('admin/badges/copy', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminBadgeController@copy'
));

//------------------------
// AdminSchoolsController
//------------------------
Route::get('admin/schools', array(
	'before' => 'admin',
	'uses' => 'AdminSchoolController@index'
));
Route::get('admin/schools/add', array(
	'before' => 'admin',
	'uses' => 'AdminSchoolController@add'
));
Route::post('admin/schools/add', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSchoolController@attempt_add'
));
Route::get('admin/schools/edit/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminSchoolController@edit'
));
Route::post('admin/schools/edit/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSchoolController@attempt_edit'
));
Route::post('admin/schools/delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSchoolController@delete'
));
Route::post('admin/schools/hard-delete/{id}', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSchoolController@hard_delete'
));
Route::get('admin/schools/restore/{id}', array(
	'before' => 'admin',
	'uses' => 'AdminSchoolController@restore'
));
Route::post('admin/schools/copy', array(
	'before' => array('admin', 'csrf'),
	'uses' => 'AdminSchoolController@copy'
));

//------------------------
// AdminReportController
//------------------------

Route::get('admin/reports', array(
	'before' => array('admin'),
	'uses' => 'AdminReportController@main'
));

Route::get('admin/report/{date}', array(
	'before' => array('admin'),
	'uses' => 'AdminReportController@daily'
));

Route::post('admin/report/range', array(
	'before' => array('admin'),
	'uses' => 'AdminReportController@range'
));

///////////////////////////////////////////////
//                Front End                  //
///////////////////////////////////////////////

//------------------------
// UserController
//------------------------
Route::get('admin-signin', array(
	'before' => 'nonadmin',
	'uses' => 'UserController@admin_signin'
));
Route::post('admin-signin', array(
	'before' => 'csrf',
	'uses' => 'UserController@admin_attempt_signin'
));

// --------------
// User pages
// --------------
Route::get('account', array(
	'before' => 'auth',
	'uses' => 'UserController@account'
));
Route::post('account', array(
	'before' => array('auth', 'csrf'),
	'uses' => 'UserController@account_edit'
));
Route::get('workouts', array(
	'before' => 'auth',
	'uses' => 'UserController@workouts'
));
Route::get('workout/{id}', array(
	'uses' => 'UserController@workout'
));
Route::get('log', array(
	'before' => 'auth',
	'uses' => 'UserController@log'
));
Route::get('gallery', array(
	'before' => 'auth',
	'uses' => 'ImageController@gallery'
));
Route::post('images/upload_challenge', array(
	'before' => 'auth',
	'uses' => 'ImageController@upload_challenge'
));
Route::post('images/upload', array(
	'before' => 'auth',
	'uses' => 'ImageController@upload'
));
Route::get('badges', array(
	'before' => 'auth',
	'uses' => 'UserController@get_badges'
));
Route::get('signin', array(
	'before' => 'guest',
	'uses' => 'UserController@signin'
));
Route::post('signin', array(
	'before' => 'guest',
	'uses' => 'UserController@attempt_signin'
));
Route::get('signin-fb', array(
	'before' => 'guest',
	'uses' => 'UserController@attempt_signin_fb'
));
Route::post('signup', array(
	'before' => array('guest', 'csrf'),
	'uses' => 'UserController@attempt_signup'
));
Route::get('signup', array(
	'before' => 'guest',
	'uses' => 'UserController@signup'
));
Route::post('signup-fb', array(
	'before' => array('guest', 'csrf'),
	'uses' => 'UserController@attempt_signup_fb'
));
Route::get('signup-fb', array(
	'before' => 'guest',
	'uses' => 'UserController@signup_fb'
));
Route::get('signup-preva', array(
	'before' => 'auth',
	'uses' => 'UserController@signup_preva'
));
Route::post('signup-preva', array(
	'before' => array('auth', 'csrf'),
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
	'before' => array('auth', 'csrf'),
	'uses' => 'UserController@post_time'
));

// --------------
// Pages
// --------------
Route::get('/', 'PageController@show');
Route::get('{url}/{section?}', 'PageController@show');