<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;


// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
//模型观察器，对模型从创建到结束进行监听，触发以上方法是触发事件
class TopicObserver
{
//    public function creating(Topic $topic)
//    {
//        //
//    }
//
//    public function updating(Topic $topic)
//    {
//        //
//    }
    //保存时，截取excerpt作为摘录，用于SEO搜索引擎优化。make_excerpt为辅助方法，在bootstrap/helpers.php
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');//使用HTMLPurifier for Laravel扩展包中的clean方法，防止xss攻击。

        $topic->excerpt = make_excerpt($topic->body);        // 生成话题摘录


    }

    public function saved(Topic $topic){
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}