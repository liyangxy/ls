<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\UserInfo;

class UserInfosController extends Controller
{
    public function edit()
    {
        $user = \Auth::user();
        // dd($user->userInfo->first()->image);
        return view('user_infos.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = \Auth::user();

        $data = $request->all();
        $userUpdate = [];
        $userInfoUpdate = [];

        if ($request->name && $request->name != $user->name) {
            $userUpdate['name'] = $request->name;
        }
        if ($request->email && $request->email != $user->email) {
            $userUpdate['email'] = $request->email;
        }
        if ($request->title) {
            $userInfoUpdate['title'] = $request->title;
        }
        if ($request->description) {
            $userInfoUpdate['description'] = $request->description;
        }

        if ($request->image) {
            $result = localUploadImage($request->image, 'user_images', $user->id, 362);
            if ($result) {
                $userInfoUpdate['image'] = $result['path'];
            }
        }
        // dd($data['image']);
        $user->update($userUpdate);
        if ($user->userInfo->isNotEmpty()) {
            $userInfo = UserInfo::where('user_id', $user->id)->update($userInfoUpdate);
        } else {
            $userInfoUpdate['user_id'] = $user->id;
            UserInfo::create($userInfoUpdate);
        }
        return redirect()->route('user_infos.edit')->with('success', '资料更新成功！');
    }

}
