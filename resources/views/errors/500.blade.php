@extends('admin.layout')

@inject('request', 'Illuminate\Http\Request')

@section('title', '出错了')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
<div class="jumbotron">
    <h2 class="text-danger">出错了</h2>
    <p>{{ $exception->getMessage() }}</p>
    <p><a class="btn btn-danger btn-lg" href="{{ $request->headers->get('referer', '#') }}" role="button">返回</a></p>
</div>
@endsection
