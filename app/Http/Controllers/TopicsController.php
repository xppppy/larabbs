<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic)
    {
        //withorder,调用模型中的作用域可不加scope前缀；
        $topics = $topic->withOrder($request->order)->paginate(20);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
	    //获取用户提交的数据并以键值对形式填充到模型中
        $topic->fill($request->all());
        //获取登陆用户id，并赋值给user_id，将文章绑定到用户
        $topic->user_id = Auth::id();
        //保存数据
        $topic->save();

		return redirect()->route('topics.show', $topic->id)->with('message', '成功创建话题！');
	}

    public function edit(Topic $topic)
    {

        $this->authorize('update', $topic);//调用授权策略中update方法进行授权判断
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);//调用授权策略中update方法进行授权判断
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', '修改成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);//调用授权策略中destroy方法进行授权判断
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删改成功！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}