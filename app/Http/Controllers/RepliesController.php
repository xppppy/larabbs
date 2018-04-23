<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        //获得回复的内容
        $reply->content = $request['content'];
        //获得登陆者id
        $reply->user_id = Auth::id();
        //获得与文章的外键id
        $reply->topic_id = $request->topic_id;
        //存入数据库
        $reply->save();
        //跳转
        return redirect()->to($reply->topic->link())->with('success', '创建成功！');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->route('replies.index')->with('success', '删除成功！');
    }
}