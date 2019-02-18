@extends('admin.layout')

@section('title', '重置密码')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
<h1 class="page-header">重置密码</h1>
<form class="form-horizontal" method="post" action="/admin/adminusers/{{ $adminId }}/password-reset">
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-2">
            <input type="password" id="password" name="password" class="form-control" />
        </div>
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">确定</button>
            <a href="/admin/adminusers" class="btn btn-primary" type="button">取消</a>
        </div>
    </div>
</form>
@endsection
