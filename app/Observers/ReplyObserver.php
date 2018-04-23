<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        //每增加一条回复，显示+1
        $reply->topic->increment('reply_count', 1);
    }

    public function creating(Reply $reply)
    {
        //对回复的消息进行清理，防御XSS攻击
        $reply->content = clean($reply->content, 'user_topic_body');
    }
}