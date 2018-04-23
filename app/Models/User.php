<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics(){

        return $this->hasMany(Topic::class);

    }

    //对授权的方法进行优化，封装到方法中，可直接调用
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    //设置与Reply模型的关联
    public function replies(){

        return $this->hasMany(Reply::class);

    }
}
