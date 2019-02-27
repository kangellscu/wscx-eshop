@extends('admin.layout')

@section('title', '管理员列表')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
          <h1 class="page-header">管理员管理版块</h1>

          <h2 class="sub-header">管理员列表</h2>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>用户名</th>
                  <th>超级管理员</th>
                  <th>创建时间</th>
                  <th>管理</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($admins as $admin)
                <tr>
                  <td>{{ $admin->name }}
                  <td>@if($admin->isSuperAdmin) 是 @else 否 </td>
                  <td>{{ $admin->createdAt->format('Y-m-d H:i:s') }}</td>
                  <td>
                    <a href="/admin/adminusers/{{ $admin->id }}/password-reset">重置密码</a>
                    &npsb;
                    <a class="delAdminUser" data-adminid="{{ $admin->id }}" data-adminname="{{ $admin->name }}" href="javascript:void()">删除</a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div>
            <form id="delForm" method="post">
                <input type="hidden" name="_method" value="delete" />
                {{ csrf_field() }}
            </form>
          </div>
@endsection

@section('body-assets')
<script type="application/javascript">

$(".delAdminUser").on("click", function() {
    if (confirm("确定要删除管理员: " + $(this).data("adminname"))) {
        var delUrl = "/admin/adminusers/" + $(this).data("adminid");
        $("#delForm").attr("action", $delUrl).submit(); 
    }
});

</script>
@endsection
