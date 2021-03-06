@extends('layouts.app')
@section('title', '编辑资料')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
            </h4>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <h4>有错误发生：</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel-body">

            <form action="{{ route('user_infos.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="category" id="category" value="">

                <div class="form-group">
                    <label for="name-field">用户名</label>
                    <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" />
                </div>
                <div class="form-group">
                    <label for="email-field">邮 箱</label>
                    <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" />
                </div>
                <div class="form-group">
                    <label for="title-field">标题</label>
                    @if ($user->userInfo->isNotEmpty())
                         <textarea name="title" id="title-field" class="form-control" rows="2" placeholder="请填写标题" required >{{ old('title', $user->userInfo->first()->title) }}</textarea>
                    @else
                         <textarea name="title" id="title-field" class="form-control" rows="2" placeholder="请填写标题" required ></textarea>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="image-label">上传图片</label>
                    <input type="file" name="image">

                    @if($user->userInfo->isNotEmpty())
                        <br>
                        <img class="thumbnail img-responsive" src="{{ config('app.url') . '/' . $user->userInfo->first()->image }}" width="200" />
                    @endif
                </div>
                <div class="form-group">
                    <label for="description-field">简介</label>
                    @if ($user->userInfo->isNotEmpty())
                         <textarea name="description" id="description-field" class="form-control" rows="6" placeholder="请介绍一下自己。" required>{{ old('description', $user->userInfo->first()->description) }}</textarea>
                    @else
                         <textarea name="description" id="description-field" class="form-control" rows="6" placeholder="请介绍一下自己。" required></textarea>
                    @endif
                </div>
                <div class="form-group">
                    <label for="category-field">所属分类<strong>
                        @if($user->userInfo->isNotEmpty())
                            <span id="selectCategory">{{ old('category', '：'.$user->userInfo->first()->category->name) }}</span>
                        @else
                            <span id="selectCategory"></span>
                        @endif
                    </strong></label>
                    <ul class="navbar-nav mr-auto">
                        @if(isset($categoryTree))
                          <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="categoryTree">选择分类<b class="caret"></b></a>
                            <ul class="dropdown-menu" aria-labelledby="categoryTree">
                              @each('user_infos._edit_category_item', $categoryTree, 'category')
                            </ul>
                          </li>
                        @endif
                    </ul>
                </div>
                <br>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scriptsAfterJs')
<script>
$(document).ready(function() {
  // 删除按钮点击事件
  $('.dropdown-item').click(function() {
    // 获取按钮上 data-id 属性的值，也就是地址 ID
    var id = $(this).data('id');
    var name = $(this).data('name');

    $('#category').val(id);
    $('#selectCategory').html('：'+name);
    // alert(id + name);
  });
});
</script>
@endsection
