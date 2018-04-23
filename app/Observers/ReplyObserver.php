<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {

        //每增加一条回复，显示+1
        $reply->topic->increment('reply_count', 1);

        // 通知作者话题被回复了
        $topic = $reply->topic;
        $topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply)
    {
        //对回复的消息进行清理，防御XSS攻击
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}