<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li @if ($navActive == 'banners') class="active" @endif>
        <a href="/admin/banners">Banner管理</a>
    </li>
    <li @if ($navActive == 'categories') class="active" @endif>
        <a href="/admin/products/categories">产品类别管理</a>
    </li>
    <li @if ($navActive == 'brands') class="active" @endif>
        <a href="/admin/products/brands">品牌管理</a>
    </li>
    <li @if ($navActive == 'userComments') class="active" @endif>
        <a href="/admin/comments">用户留言</a>
    </li>
    <li @if ($navActive == 'new') class="active" @endif>
        <a href="/admin/clients/create-form">新增 <span class="sr-only">(current)</span></a>
    </li>
  </ul>
</div>
