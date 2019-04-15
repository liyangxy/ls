@extends('layouts.app')
@section('title', '用户列表')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body">
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
    <div class="float-right">{{ $users->links() }}</div>
  </div>
</div>
</div>
</div>
@endsection
