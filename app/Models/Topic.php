<?php

namespace App\Models;


class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];
    //设置话题与属性关联，1对1用belongsto
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //设置话题与话题人关联，1对1用belongsto
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //设置根据传入的数据排序;使用了 Laravel 本地作用域 ,在对应 Eloquent 模型方法前加上 scope 前缀
    //可以在查询模型时调用作用域方法,在进行方法调用时不需要加上 scope 前缀
    public function scopeWithOrder($query,$order){
        //不同的排序，使用不同的数据读取逻辑
        switch ($order){
            case 'recent':
                $query->recent();//调用下面scopeRecent方法
                break;

            default :
                $query->recentReplied();//调用下面scopeRecnetReplied方法
                break;
        }
        //预防加载N+1问题;
        return $query->with('user','category');
    }
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
