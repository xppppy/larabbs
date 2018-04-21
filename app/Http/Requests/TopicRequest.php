<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // 创建，因没用break，会直接使用patch的验证规则
            case 'POST':
                // 修改
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'title'       => 'required|min:2',
                        'body'        => 'required|min:3',
                        'category_id' => 'required|numeric',
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        //报错信息
        return [
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
}
