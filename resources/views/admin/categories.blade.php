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

          <h2 class="page-header">新增一级菜单</h2>
          <form class="bs-example bs-example-form" data-example-id="input-group-with-button" method="post" action="/admin/products/categories">
            <input type="hidden" name="_method" value="put" />
            <div class="row">
              <div class="col-lg-6">
                <div class="input-group">
                  <input type="text" class="form-control" name="name" placeholder="一级类别名称">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">添加!</button>
                  </span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </div>
            {{ csrf_field() }}
          </form>
          <p />
        @if ($categories->count())
          <h2 class="page-header">新增二级菜单</h2>
          <form class="bs-example bs-example-form" data-example-id="input-group-with-button" method="post" action="/admin/products/categories">
            <input type="hidden" name="_method" value="put" />
            <div class="row">
              <div class="col-lg-6">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="topParentCategoryName">{{ $categories->first()->name }}</span><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    @foreach ($categories as $category)  
                      <li><a href="#" class="topParentCategoryButton" data-top-parent-categoryid="{{ $category->id }}" data-top-parent-categoryname="{{ $category->name }}">{{ $category->name }}</a></li>
                    @endforeach
                    </ul>
                  </div><!-- /btn-group -->
                  <input type="hidden" id="topParentCategoryId" name="parentId" value="{{ $categories->first()->id }}" />
                  <input type="text" class="form-control" placeholder="二级类别名称" name="name">
                  <span class="input-group-btn">
                    <button id="addSecondCategory" class="btn btn-default" type="submit">添加!</button>
                  </span>
                </div><!-- /input-group -->
              </div>
            </div>
            {{ csrf_field() }}
          </form>
        @endif
          <h2 class="sub-header">类别列表</h2>
          <nav id="actionPannel" class="navbar navbar-default" hidden="true">
            <div class="container-fluid">
              <form id="actionForm" class="navbar-form navbar-left" role="search" method="post">
                <input id="actionFormMethod" type="hidden" name="_method" value="post" />
                <a id="actionBackward" href="#"><span class="label label-default"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> 后移</span></a>
                <a id="actionForward" href="#"><span class="label label-default">前移 <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></span></a>
                <a id="actionDelete" href="#"><span class="label label-danger">删除 <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span></a>
                <div class="form-group">
                  <input id="actionCategoryName" type="text" name="name" class="form-control">
                  <input id="actionMoveDirection" type="hidden" name="moveDirection" value="0">
                </div>
                <button id="actionModifyName" type="submit" class="btn btn-default">修改名字</button>
                {{ csrf_field() }}
              </form>
            </div>
          </nav>

          <div class="bs-example" data-example-id="split-button-dropdown">
            @foreach ($categories as $category)  
            <div class="btn-group">
                @if ((is_null($parentId) && $loop->first) || $parentId == $category->id)
              <button type="button" class="btn btn-primary top-category">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"
                  data-id="{{ $category->id }}"
                  data-name="{{ $category->name }}"
                ></span> -- {{ $category->name }}
              </button>
              <button type="button" class="btn btn-primary dropdown-toggle top-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @else
              <button type="button" class="btn btn-default top-category">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"
                  data-id="{{ $category->id }}"
                  data-name="{{ $category->name }}"
                ></span> -- {{ $category->name }}
              <button type="button" class="btn btn-default dropdown-toggle top-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @endif
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              @if ($category->subs->count())
              <ul class="dropdown-menu">
                @foreach ($category->subs as $subCategory)
                <li><a href="#">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"
                    data-id="{{ $subCategory->id }}"
                    data-name="{{ $subCategory->name }}"
                  ></span> -- {{ $subCategory->name }}</a></li>
                @endforeach
              </ul>
              @endif
            </div>
            @endforeach
          </div>

@endsection

@section('body-assets')
<script type="application/javascript">
    $('.glyphicon-pencil').on('click', function () {
        $('#actionPannel').show();
        $('#actionCategoryName').val($(this).data('name'));
        $('#actionForm').attr('action', '/admin/products/categories/' + $(this).data('id'));
    });
    $('#actionForward').on('click', function () {
        $('#actionMoveDirection').val(1);
        $('#actionForm').attr('method', 'post').submit();
    });
    $('#actionBackward').on('click', function () {
        $('#actionMoveDirection').val(-1);
        $('#actionForm').attr('method', 'post').submit();
    });
    $('#actionDelete').on('click', function () {
        $('#actionFormMethod').val('delete');
        $('#actionForm').submit();
    });
    $('.top-category').on('click', function () {
        $('.top-category').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');
        $(this).siblings('button').removeClass('btn-default').addClass('btn-primary');
    });
    $('.topParentCategoryButton').on('click', function () {
        $('#topParentCategoryName').text($(this).data('top-parent-categoryname'));
        $('#topParentCategoryId').val($(this).data('top-parent-categoryid'));
    });
</script>
@endsection
