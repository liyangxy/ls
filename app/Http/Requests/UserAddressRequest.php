<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'province'      => 'required|exists:simple_districts,name',
           'city'          => 'required|exists:simple_districts,name',
           'district'      => 'required|exists:simple_districts,name',
           'address'       => 'required|min:2|max:100',
           'zip'           => 'required|exists:simple_districts,code',
           'contact_name'  => 'required|min:2|max:50',
           'contact_phone' => 'required|regex:/^1[3456789][0-9]{9}$/',
       ];
    }

    public function attributes()
    {
        return [
            'province'      => '省',
            'city'          => '城市',
            'district'      => '地区',
            'address'       => '详细地址',
            'zip'           => '邮编',
            'contact_name'  => '姓名',
            'contact_phone' => '电话',
        ];
    }
}
