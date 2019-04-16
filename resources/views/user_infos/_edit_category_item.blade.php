<!-- 如果当前类目有 children 字段并且 children 字段不为空 -->
@if(isset($category['children']) && count($category['children']) > 0)
  <li class="dropdown-submenu">
    <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown" data-id="{{ $category['id'] }}" data-name="{{ $category['name'] }}">{{ $category['name'] }}</a>
    <ul class="dropdown-menu">
      <!-- 遍历当前类目的子类目，递归调用自己这个模板 -->
      @each('user_infos._edit_category_item', $category['children'], 'category')
    </ul>
  </li>
@else
  <li><a class="dropdown-item" href="#" data-id="{{ $category['id'] }}" data-name="{{ $category['name'] }}">{{ $category['name'] }}</a></li>
@endif
