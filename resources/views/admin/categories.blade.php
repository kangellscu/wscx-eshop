@extends('admin.layout')

@section('title', '类别管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'categories'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">类别管理</h1>

          <h2 class="sub-header">类别列表</h2>

          <div class="bs-example" data-example-id="split-button-dropdown">
            @foreach ($categories as $category)  
            <div class="btn-group">
                @if ((is_null($parentId) && $loop->first) || $parentId == $category->id)
              <button type="button" class="btn btn-primary">{{ $category->name }} <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @else
              <button type="button" class="btn btn-default">{{ $category->name }} <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @endif
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu">
                @foreach ($category->subs as $subCategory)
                <li><a href="#">{{ $subCategory->name }}<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></li>
                @endforeach
              </ul>
            </div>
            @endforeach
          </div>
@endsection
