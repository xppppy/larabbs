<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
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
}
