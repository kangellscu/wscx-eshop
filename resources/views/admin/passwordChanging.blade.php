@extends('admin.layout')

@section('title', '修改密码')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
<h1 class="page-header">修改密码</h1>
<form class="form-horizontal" method="post" action="/admin/aaa/password-changing">
    <div class="form-group">
        <label for="curr-password" class="col-sm-2 control-label">当前密码</label>
        <div class="col-sm-2">
            <input type="password" id="curr-password" name="currPassword" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-2">
            <input type="password" id="new-password" name="password" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password-confirm" class="col-sm-2 control-label">确认新密码</label>
        <div class="col-sm-2">
            <input type="password" id="new-password-confirm" name="password_confirmation" class="form-control" />
        </div>
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">确定</button>
            <a href="/admin/clients" class="btn btn-primary" type="button">取消</a>
        </div>
    </div>
</form>
@endsection
