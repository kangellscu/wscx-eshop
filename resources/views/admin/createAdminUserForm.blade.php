@extends('admin.layout')

@section('title', '创建管理员')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'new'])
    @endcomponent
@endsection

@section('body-content')

    @component('admin.componentAlert')
    @endcomponent

<h1 class="page-header">创建管理员</h1>
<form class="form-horizontal" method="post" action="/admin/adminusers">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-3">
            <input type="text" id="name" name="name" class="form-control" />
            <p class="help-block">用户名，不超过32个字符</p>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-2">
            <input type="password" id="password" name="password" class="form-control" />
        </div>
    </div>
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">确定</button>
            <a href="/admin/adminusers" class="btn btn-primary" type="button">取消</a>
        </div>
    </div>
</form>
@endsection
