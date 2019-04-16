<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\UserInfo;
use App\Models\Category;
use App\Exceptions\InvalidRequestException;

class UserInfosController extends Controller
{
    public function index(Request $request)
    {
        $users = UserInfo::query()->with('user');

        if ($search = $request->input('search', '')) {
            $like = '%'.$search.'%';
            $users->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like);
            });
        }

        // 如果有传入 category_id 字段，并且在数据库中有对应的类目
        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))) {
            if ($category->is_directory) {
                // 则筛选出该父类目下所有子类目的商品
                $users->whereHas('category', function ($query) use ($category) {
                    // 这里的逻辑参考本章第一节
                    $query->where('path', 'like', $category->path.$category->id.'-%');
                });
            } else {
                $users->where('category_id', $category->id);
            }
        }

        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['view_count', 'rating'])) {
                    $users->orderBy($m[1], $m[2]);
                }
            }
        }

        $users = $users->paginate(1);
        return view('users.index', [
            'users' => $users,
            'filters' => ['search' => $search,  'order'  => $order],
            'category' => $category ?? null,
        ]);
    }

    public function show(UserInfo $userInfo, Request $request)
    {
        if (!$userInfo) {
            throw new InvalidRequestException('访问错误');
        }
        return view('users.show', ['userInfo' => $userInfo->load('user')]);
    }

    public function edit()
    {
        $user = \Auth::user();
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
