@extends('layouts.app')
@section('title', '用户列表')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body">
      <form action="{{ route('users.index') }}" class="search-form">
      <div class="form-row">
        <div class="col-md-9">
          <div class="form-row">
            <div class="col-auto"><input type="text" class="form-control form-control-sm" name="search" placeholder="搜索"></div>
            <div class="col-auto"><button class="btn btn-primary btn-sm">搜索</button></div>
          </div>
        </div>
        <div class="col-md-3">
          <select name="order" class="form-control form-control-sm float-right">
            <option value="">排序方式</option>
            <option value="view_count_desc">点击量从高到低</option>
            <option value="view_count_asc">点击量从低到高</option>
            <option value="rating_desc">评价从高到低</option>
            <option value="rating_asc">评价从低到高</option>
          </select>
        </div>
      </div>
    </form>
    <div class="row users-list">
      @foreach($users as $user)
        <div class="col-3 user-item">
          <div class="user-content">
            <div class="top">
              <div class="img"><img src="{{ $user->image }}" alt=""></div>
              <!-- <div class="price"><b>￥</b>{{ $user->price }}</div> -->
              <div class="title">{{ $user->title }}</div>
            </div>
            <div class="bottom">
              <div class="rating">评分 <span>{{ $user->rating }}</span></div>
              <div class="view_count">点击量 <span>{{ $user->view_count }}</span></div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="float-right">{{ $users->appends($filters)->links() }}</div>
  </div>
</div>
</div>
</div>
@endsection

@section('scriptsAfterJs')
  <script>
    var filters = {!! json_encode($filters) !!};
    $(document).ready(function () {
      $('.search-form input[name=search]').val(filters.search);
      $('.search-form select[name=order]').val(filters.order);

      $('.search-form select[name=order]').on('change', function() {
        $('.search-form').submit();
      });
    })
  </script>
@endsection
