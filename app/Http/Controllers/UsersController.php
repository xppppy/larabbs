<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;//表单请求验证
use App\Handlers\ImageUploadHandler;//图片上传


class UsersController extends Controller
{
    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
    public function __construct() {
        $this->middleware('auth',['except'=>['show']]);
    }

    //显示个人信息
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //显示个人编辑信息
    public function edit(User $user){
        //通过policies下的Userpolicy进行授权，第一个参数为其下的update方法，第二个参数是其下update方法的第二个参数，第一参数默认登陆后数据，不用传参
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    //处理个人信息改动，第一个参数为通过验证后的request参数，第二个参数为注入ImageUploadHandler类，第三个参数为隐形传参
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user){
        //获得全部传参数据
        $data = $request->all();
        //判断是否有头像
        if ($request->avatar) {
            /*传参到ImageUploadHandler类的save方法，第一个参数为头像对象，第二个默认，第三个为用户id，第四个参数限定图片最大值,超过进行裁剪。
             *返回值如果是图片返回图片地址，否则为false
             */
            $result = $uploader->save($request->avatar, 'avatars', $user->id,362);

            if ($result) {
                //把更改后地址和需要更改数据一起放入数组
                $data['avatar'] = $result['path'];
            }
        }
        //写入数据库
        $user->update($data);
        //成功后重定向到个人编辑页面，并显示success内容
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
