<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li @if ($navActive == 'list') class="active" @endif>
        <a href="/admin/clients">列表</a>
    </li>
    <li @if ($navActive == 'new') class="active" @endif>
        <a href="/admin/clients/create-form">新增 <span class="sr-only">(current)</span></a>
    </li>
  </ul>
</div>
