<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
//模型观察器，对模型从创建到结束进行监听，触发以上方法是触发事件
class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    //保存时，截取excerpt作为摘录，用于SEO搜索引擎优化。make_excerpt为辅助方法，在bootstrap/helpers.php
    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
}