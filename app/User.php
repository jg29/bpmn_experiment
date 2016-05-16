<?php

namespace App;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','groups'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Experimente eines Users anzeigen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiments() {

        return $this->hasMany('App\Experiment');

    }

    function getGroup()  {
        if($this->groups != "" and is_array(explode(",",$this->groups))) {
            return json_decode($this->groups, true);
        }
    }

    function inGroup($id) {
        if($this->groups != "" and is_array(explode(",",$this->groups)) and in_array($id,explode(",",$this->groups))) {
            return true;
        }
        return false;
    }

    function isAdmin() {
        if($this->groups != "" and is_array(explode(",",$this->groups)) and in_array(1,explode(",",$this->groups))) {
            return true;
        }
        return false;
    }
    function isEditor() {
        if($this->groups != "" and is_array(explode(",",$this->groups)) and in_array(2,explode(",",$this->groups))) {
            return true;
        }
        return false;
    }

    public static function generateUserId($time) {
        $users = DB::table('answers')->groupBy("student")->get();
        $userArray = array();
        $num = 1;
        foreach($users as $user) {
            $userArray[$user->student] = $num++;
        }
        return $userArray[$time];
    }

}
