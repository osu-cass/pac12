<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
Use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes, Notifiable;

    public $timestamps = false;

    public function times()
    {
        return $this->hasMany('Time')->orderBy('date', 'desc')->orderBy('id');
    }

    public function images()
    {
        return $this->hasMany('Image');
    }

    public function profiles()
    {
      return $this->hasMany('Profile');
    }

    public static function totalTimeToday($user_id)
    {
        $user = User::where('id', $user_id)->with('times')->firstOrFail();
        $total = 0;
        foreach ($user->times as $time) {
            if ($time->date == Carbon::now()->toDateString()) {
                $total += $time->minutes;
            }
        }
        return $total;
    }

    public static function totalTimeOnDate($user_id, $date)
    {
        $user = User::where('id', $user_id)->with('times')->firstOrFail();
        $total = 0;
        foreach ($user->times as $time) {
            if ($time->date == $date) {
                $total += $time->minutes;
            }
        }
        return $total;
    }

    public function full_name()
    {
        return $this->username;
    }

    /**
     * This is where you can add user types.
     *
     * @return array - All available types
     */
    public static function types_array()
    {
        return array(
            'superadmin' => 'superadmin',
            'admin' => 'admin',
            'user'  => 'user'
        );
    }



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }


    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}
