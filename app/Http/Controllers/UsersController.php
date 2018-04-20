<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;//表单请求验证
use App\Handlers\ImageUploadHandler;//图片上传

class UsersController extends Controller
{
    //显示个人信息
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //显示个人编辑信息
    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

    //处理个人信息改动
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user){

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
