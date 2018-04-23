<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class User extends Authenticatable
{
    //使用 laravel-permission 提供的 Trait —— HasRoles,进行权限管理
    use HasRoles;

    use Notifiable { notify as protected laravelNotify; }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

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

    //阅读消息通知后，通知重置
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
