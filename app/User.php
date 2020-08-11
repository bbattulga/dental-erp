<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Shift;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'name', 'email', 'password','sex','location','register','birth_date','description','phone_number', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->hasOne('App\Roles', 'id', 'role_id');
    }
    
    public function roles(){
        return $this->belongsToMany('App\Roles' ,'user_role', 'user_id', 'role_id')
                    ->withPivot('state');
    }

    public function photos(){
        return $this->morphMany('App\Photo', 'imageable');
    }
    
    public function appointments(){
        return $this->hasMany('App\Appointment', 'user_id', 'id');
    }

  public function checkins(){
        return $this->hasMany('App\CheckIn','user_id','id');
  }

  public function treatments(){
    return $this->hasMany('App\UserTreatments', 'user_id', 'id');
  }

  public function getMaleAttribute(){
    return $this->sex == 0;
  }

  public function getFemaleAttribute(){
    return $this->sex == 1;
  }

  public function getAgeAttribute(){
    return date_diff(date_create($this->birth_date), date_create('now'))->y;
  }
  public function getShiftTodayAttribute(){
    return Shift::where('date', Date('Y-m-d'))
                  ->where('user_id', $this->id)
                  ->first();
  }
  public function getProfilePicAttribute(){
        $lastpic = $this->photos()->orderBy('id', 'desc')->first();

        // no profile pic
        if (!$lastpic){
            return '';
        }
        $url = Storage::url('img/avatar/'.$lastpic->path);
        return $url;
    }

    public function generateToken(){
        $this->api_token = $this->str_random();
        $this->save();
        return $this->api_token;
    }

    function str_random(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}
