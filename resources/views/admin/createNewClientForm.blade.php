@extends('admin.layout')

@section('title', '创建软件')

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

<h1 class="page-header">创建软件</h1>
<form class="form-horizontal" method="post" action="/admin/clients">
    <div class="form-group">
        <label for="serialno" class="col-sm-2 control-label">软件号</label>
        <div class="col-sm-3">
            <input type="text" id="serialno" name="serialNo" class="form-control" />
            <p class="help-block">一位大写字母接着3到5位数字.例:F001</p>
        </div>
    </div>
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">确定</button>
            <a href="/admin/clients" class="btn btn-primary" type="button">取消</a>
        </div>
    </div>
</form>
@endsection
