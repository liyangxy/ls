@extends('layouts.app')
@section('title', $userInfo->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body userInfo-info">
    <div class="row">
      <div class="col-5">
        <img class="cover" src="{{ $userInfo->image_url }}" alt="">
      </div>
      <div class="col-7">
        <div class="title">{{ $userInfo->title }}</div>
        <!-- <div class="price"><label>价格</label><em>￥</em><span>{{ $userInfo->price }}</span></div> -->
        <div class="sales_and_reviews">
          <div class="view_count">点击量 <span class="count">{{ $userInfo->view_count }}</span></div>
          <!-- <div class="review_count">累计评价 <span class="count">{{ $userInfo->review_count }}</span></div> -->
          <div class="rating" title="评分 {{ $userInfo->rating }}">评分 <span class="count">{{ str_repeat('★', floor($userInfo->rating)) }}{{ str_repeat('☆', 5 - floor($userInfo->rating)) }}</span></div>
        </div>
      </div>
    </div>
    <div class="userInfo-detail">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#userInfo-detail-tab" aria-controls="userInfo-detail-tab" role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#userInfo-reviews-tab" aria-controls="userInfo-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">用户评价</a>
        </li> -->
      </ul>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="userInfo-detail-tab">
          {!! $userInfo->description !!}
        </div>
        <div role="tabpanel" class="tab-pane" id="userInfo-reviews-tab">
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection
