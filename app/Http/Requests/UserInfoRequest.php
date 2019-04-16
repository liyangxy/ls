<?php

namespace App\Http\Requests;

class UserInfoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     public function rules()
     {
         return [
            'name'           => 'required',
            'email'          => 'required',
            'title'          => 'required|max:100',
            'description'    => 'required',
            'image'          => 'sometimes|image',
            'category'    => 'required|exists:categories,id',
        ];
     }

     public function attributes()
     {
         return [
             'name'           => '用户名',
             'email'          => '邮箱',
             'title'          => '标题',
             'description'    => '简介',
             'image'          => '图片',
             'category_id'    => '所属分类',
         ];
     }
}
