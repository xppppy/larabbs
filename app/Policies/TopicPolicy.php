<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        //修改必须当前id等于登陆id，调用User中的isAuthorOf方法
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        //调用User中的isAuthorOf方法
        return $user->isAuthorOf($topic);
    }
}
