<?php

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class UserController extends BaseController {

    private function attempt_get_fb_user(array $fields = array())
    {
        $config = Config::get('facebook');
        $fb = new Facebook($config);
        $helper = $fb->getRedirectLoginHelper();

        // Try to get the access token
        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }

        // If no token was returned
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }

            return null;
        }

        // Get token metadata and validate it
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        try {
            $tokenMetadata->validateAppId($config['app_id']);
            $tokenMetadata->validateExpiration();
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }

        // Assemble the fields query string (If empty, grab all default fields)
        if (count($fields) == 0) {
            $fields_query = '';
        } else {
            $fields_query = '?fields=' . implode(',', $fields);
        }

        // Attempt to retrieve the user profile
        try {
            $response = $fb->get('/me' . $fields_query, $accessToken);
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }

        return $response->getGraphUser();
    }

    public function signup()
    {
        return View::make('users.signup', $this->data);
    }

    private function signup_email($user)
    {
        $emailData = array(
            'user' => $user,
        );
        Mail::send('emails.new-user', $emailData, function($message) use ($user) {
            $message->to($user->email)
                ->from('DoNotReply@pac12challenge.org', 'PAC12 Fitness Challenge')
                ->subject('PAC12 Fitness Challenge');
        });
    }

    public function attempt_signup()
    {
        $rules = array(
            'school'    => 'required',
            'email'     => 'required|email|confirmed|unique:users',
            'password'  => 'required|min:6|confirmed'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('signup')->withInput()->withErrors($validator);
        }

        $user = new User;
        $user->school   = Input::get('school');
        $user->email    = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->joined   = Carbon::now()->toDateString();
        $user->save();
        $this->signup_email($user);
        Auth::login($user);

        return Redirect::to('log')->with('success', '
            <p>Your account has been created!</p>
            <p>You have been signed in.</p>
        ');
    }

    public function signup_fb()
    {
        $code = Input::get('code');
        if (strlen($code) == 0) {
            return Redirect::to('/signup')->withErrors('There was an error communicating with Facebook');
        }
        return View::make('users.signup-fb', $this->data);
    }

    public function attempt_signup_fb()
    {
        $fb_user = $this->attempt_get_fb_user(array('email', 'id', 'name'));

        if (!$fb_user) {
            return Redirect::to('/signup')->withErrors('There was an error');
        }

        $inputs = array('email' => $fb_user['email']);
        $rules = array('email'  => 'unique:users');
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('signup')->withInput()->withErrors($validator);
        }

        $uid = intval($fb_user->getField('id'));
        $email = $fb_user->getField('email');

        $profile = Profile::whereUid($uid)->first();
        if (empty($profile)) {
            $user           = new User;
            $user->school   = Input::get('school');
            //$user->name   = $me['first_name'].' '.$me['last_name'];
            $user->email    = $email;
            $user->joined   = Carbon::now()->toDateString();
            //$user->photo  = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
            $user->save();
            $this->signup_email($user);

            $profile            = new Profile();
            $profile->uid       = $uid;
            $profile->username  = $fb_user['username'];
            $profile            = $user->profiles()->save($profile);
        }
        $profile->access_token = $facebook->getAccessToken();
        $profile->save();
        $user = $profile->user;
        Auth::login($user);

        return Redirect::to('/log')->with('success', '
            <p>Your account has been created!</p>
            <p>You have been signed in with Facebook.</p>');
    }

    public function signup_preva()
    {
        if (Auth::user()->password) {
            return Redirect::to('log');
        }
        return View::make('users.signup-preva', $this->data);
    }

    public function attempt_signup_preva()
    {
        $rules = array(
            'school'    => 'required',
            'password'  => 'required|min:6|confirmed'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('signup-preva')->withInput()->withErrors($validator);
        }

        $user = Auth::user();
        $user->school   = Input::get('school');
        $user->password = Hash::make(Input::get('password'));
        $user->joined   = Carbon::now()->toDateString();
        $user->save();
        $this->signup_email($user);

        return Redirect::to('log')->with('success', '
            <p>Your Preva account has successfully been connected to '.$user->school.'!</p>
            <p>You may log minutes through either your Preva account or here.</p>
        ');
    }

    public function signin()
    {
        return View::make('users.signin', $this->data);
    }

    public function attempt_signin()
    {
        $rules = array(
            'signemail' => 'required',
            'signpass'  => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('signin')->withInput()->withErrors($validator);
        }

        $emailCheck = array(
            'email'    => Input::get('signemail'),
            'password' => Input::get('signpass')
        );

        if (Auth::attempt($emailCheck)) {
            return Redirect::intended('log');
        }

        return Redirect::to('signin')->withInput()->withErrors('Sign in attempt failed.');
    }

    public function attempt_signin_fb()
    {
        $facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();

        if($uid != 0) {
            if ($profile = Profile::whereUid($uid)->first()) {
                $user = $profile->user;
                Auth::login($user);
                return Redirect::intended('log');
            }
            else {
                $signup = URL::to('/signup');
                return Redirect::to('signin')->withInput()->withErrors('Current Facebook account is not linked with PAC12. <a href="'.$signup.'">Signup</a>');
            }
        }

        return Redirect::to('signin')->withInput()->withErrors('Facebook Sign in attempt failed.');
    }

    public function signout()
    {
        Session::flush();
        Auth::logout();

        $facebook = new Facebook(Config::get('facebook'));
        if($facebook->getUser()) {
            $params = array( 'next' => URL::to('/') );
            return Redirect::away($facebook->getLogoutUrl($params));
        }

        return Redirect::to('/');
    }

    public function forgot_password()
    {
        return View::make('users.forgot-password', $this->data);
    }

    public function email_password_reset()
    {
        $rules = array(
            'email' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('forgot-password')->withInput()->withErrors($validator);
        }

        $user = User::where('email', Input::get('email'))->first();

        if (!$user) return Redirect::to('forgot-password')->withInput()->withErrors('User not found.');

        $token = static::id_to_token($user->id);

        $emailData = array(
            'user'  => $user,
            'token' => $token
        );
        Mail::send('emails.forgot-password', $emailData, function($message) use ($user) {
            $message->to($user->email)
                ->from('DoNotReply@pac12challenge.org', 'PAC12 Fitness Challenge')
                ->subject('PAC12 Fitness Challenge - Reset Password');
        });

        return View::make('users.forgot-password', $this->data)->with('success', array('A password reset email has been sent to you.'));
    }

    public function password_reset($token)
    {
        $id = static::token_to_id($token);
        $user = User::find($id);
        $password = str_random(8);
        $user->password = Hash::make($password);
        $user->save();

        $emailData = array(
            'user'     => $user,
            'password' => $password
        );
        Mail::send('emails.reset-password', $emailData, function($message) use ($user) {
            $message->to($user->email)
                ->from('DoNotReply@pac12challenge.org', 'PAC12 Fitness Challenge')
                ->subject('PAC12 Fitness Challenge - New Password');
        });

        return Redirect::to('signin')->with('success', 'A new password has been emailed to you.');

    }

    //Doing some stupid bullshit to encode the id

    public function id_to_token($id)
    {
        $token = $id * 37;
        $token = $token - 7;
        $token = $token * $token;
        $token = $token - 123;
        return $token;
    }

    // Can't hack this bullshit

    public function token_to_id($token)
    {
        $id = $token + 123;
        $id = sqrt($id);
        $id = $id + 7;
        $id = $id / 37;
        return $id;
    }

    public function password_change()
    {
        $rules = array(
            'password' => 'required',
            'confirm'  => 'required|same:password',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('account')->withErrors($validator);
        }

        $user = Auth::user();

        if (!$user) return Redirect::to('account')->withErrors('User not found.');

        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Redirect::to('account')->with('success', 'Your password has been updated.');
    }

    public function log()
    {
        if (!Auth::user()->password and !Auth::user()->profiles()) {
            return Redirect::to('signup-preva');
        }

        $this->data['challenge'] = Challenge::orderBy('published_end', 'desc')->first();

        return View::make('pages.log', $this->data);
    }

    public function post_time()
    {
        $rules = array(
            'minutes'  => 'required',
            'date' => 'required'
        );
        if(Input::get('type') == NULL) $rules['activity'] = 'required';

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('log')->withInput()->withErrors($validator);
        }

        $challenge = Challenge::orderBy('published_end', 'desc')->first();

        $start = date('Y-m-d',  strtotime($challenge->published_start));
        $end = date('Y-m-d',  strtotime($challenge->published_end));
        $date = Input::get('date');
        $displayDate = date('M d, Y', strtotime($date));
        $currentDate = date('Y-m-d');

        if ($date < $start || $date > $end) {
            return Redirect::to('log')->withInput()->withErrors('The date must be between ' . $start . ' and ' . $end);
        }

        $minutes = intval(Input::get('minutes'));
        if (!$minutes || $minutes < 0 || $minutes > 120) {
            return Redirect::to('log')->withInput()->withErrors('The time must be between 1 and 120 minutes.');
        }

        $totalTime = User::totalTimeOnDate(Auth::user()->id, $date);

        if ($totalTime >= 120) {
            return Redirect::to('log')->withErrors('You have already submitted the maximum of 120 minutes for ' . $displayDate .'!');
        }

        $time = new Time;
        $time->user_id = Auth::user()->id;
        $time->school = Auth::user()->school;
        $time->date = Input::get('date');
        $time->activity = Input::get('activity');
        $time->type = Input::get('type');

        Input::has('distance') ? $time->distance = Input::get('distance') : $time->distance = 0;
        Input::has('calories') ? $time->calories = Input::get('calories') : $time->calories = 0;
        Input::has('weight') ? $time->weight = Input::get('weight') : $time->weight = 0;
        Input::has('reps') ? $time->reps = Input::get('reps') : $time->reps = 0;

        if ($totalTime + $minutes > 120) {
            $minutes = 120 - $totalTime;
            if ($minutes < 0) $minutes = 0;
        }

        $time->minutes += $minutes;
        $totalTime += $minutes;
        $time->save();

        //Adding to school totals
        if ($currentDate >= $start && $currentDate <= $end) {
            $count = Time::where('school', '=', Auth::user()->school)->groupBy('user_id')->count();
            $schoolTotal = Total::where('school', '=', Auth::user()->school)->first();
            $schoolTotal->minutes += $minutes;
            $schoolTotal->students = $count;
            $schoolTotal->save();
        }

        $badgeText = $this->set_badges($time->user_id, $time->type);

        $totalTime = ($totalTime > 120) ? 120 : $totalTime;

        $success = 'Your time has been submitted!  Your total for '. $displayDate .': ' . $totalTime . ' minutes.';
        $success .= ($totalTime == 120) ? '<br />You have reached the maximum of 120 minutes for '. $displayDate .'.  Good job!' : '';

        $success .= $badgeText;

        return Redirect::to('log')->with('success', $success);
    }

    public function set_badges($user_id, $type)
    {
        $times = DB::table('times')
            ->select(DB::raw('sum(minutes) as total'))
            ->where('type', '=', $type)
            ->where('user_id', '=', $user_id)
            ->first();

        $badges = Badge::where('category', '=', $type)
                    ->where('minutes', '<=', $times->total)
                    ->get();

        if (!$badges) {
            return '';
        } else {
            $badgeText = '';
            foreach ($badges as $badge ) {
                $badgeCheck = UserBadge::where('user_id', '=', $user_id)
                                        ->where('badge_id', '=', $badge->id)->get();
                if ($badgeCheck->isEmpty()) {
                    $badgeText .= '<br>You have earned a badge: ' . $badge->name . '!';
                    $userBadge = new UserBadge();
                    $userBadge->user_id = $user_id;
                    $userBadge->badge_id = $badge->id;
                    $userBadge->save();

                }
            }
            return $badgeText;
        }
    }

    public function get_badges()
    {
        $id = Auth::user()->id;
        print $id;
        $this->data['badges'] = DB::table('badges')
                            ->join('users_badges', 'users_badges.badge_id', '=', 'badges.id')
                            ->where('user_id', '=', $id)
                            ->get();
        return View::make('pages.badges', $this->data);
    }


    public function account()
    {
        return View::make('pages.account', $this->data);
    }

    public function workouts()
    {
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $past_week[] = $date->format('Y-m-d');

            $workout_data[$date->format('Y-m-d')] = array(
                'label' => $date->format('m/d'),
                'minutes' => 0
            );
        }

        // Get times for user grouped by date within the past week
        $times = Time::select(DB::raw('date, sum(minutes) as sum_minutes'))->where('user_id', Auth::user()->id)->whereIn('date', $past_week)->groupBy('date')->get();

        // Minutes
        foreach ($times as $v) {
            $workout_data[$v->date]['minutes'] = $v->sum_minutes;
        }

        $this->data['workout_data'] = $workout_data;
        return View::make('pages.workouts', $this->data);
    }

    public function workout($id)
    {
        $this->data['workout'] = Time::find($id);
        return View::make('pages.workout', $this->data);
    }

    public function account_edit()
    {
        $rules = array(
            'username'  => 'between:4,16',
            'gender'    => 'in:m,f,t,u,o,n',
            'dob'       => 'date'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('account')->withInput()->withErrors($validator);
        }

        $user = Auth::user();
        $user->username         = Input::get('username');
        $user->dob              = Input::get('dob') ? Input::get('dob') : null;
        $user->gender           = Input::get('gender');
        $user->gender_other     = Input::get('gender_other');
        $user->weight           = Input::get('weight');
        $user->height_feet      = Input::get('height_feet');
        $user->height_inches    = Input::get('height_inches');
        $user->save();

        return Redirect::to('account')->with('success', '
            <p>Your account has been updated.</p>
        ');
    }

    public function admin_signin()
    {
        return View::make('admin.signin', $this->data);
    }

    public function admin_attempt_signin()
    {
        $rules = array(
            'loguser' => 'required',
            'logpass' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('admin-signin')->withInput()->withErrors($validator);
        }

        // Users can use either their username or their email to login, so
        // we'll have to do 2 checks.
        $usernameCheck = array(
            'username' => Input::get('loguser'),
            'password' => Input::get('logpass')
        );
        $emailCheck = array(
            'email'    => Input::get('loguser'),
            'password' => Input::get('logpass')
        );

        if (Auth::attempt($usernameCheck) || Auth::attempt($emailCheck)) {
            if (Auth::user()->type == 'superadmin') {
                Session::put('superadmin', true);
                Session::put('admin', true);
                return Redirect::intended('admin');
            }
            if (Auth::user()->type == 'admin') {
                Session::put('admin', true);
                return Redirect::intended('admin');
            }
            return Redirect::intended('/');
        }

        return Redirect::to('admin-signin')->withInput()->withErrors('Login attempt failed.');
    }

}
