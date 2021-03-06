<?php

namespace App;

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
    protected $fillable = ['clientid','fname','lname', 'addressid','phonenumber', 'role', 'active', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getFullNameAttribute() {
      return $this->fname . ' ' . $this->lname;
    }

    public function getStatusStrAttribute() {
      return $this->active == 1 ? 'Active' : 'Inactive';
    }

    public function client() {
      return $this->belongsTo('App\Client', 'clientid','id');
    }

    public function address() {
      return $this->hasOne('App\Address', 'id', 'addressid');
    }

    public function usages() {
      return $this->hasMany('App\Usage','cid');
    }
}
