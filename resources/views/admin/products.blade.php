@extends('admin.layout')

@section('title', '产品管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'products'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">产品管理</h1>

          <h2 class="sub-header">产品列表</h2>
          <a href="/admin/products/form">新增产品</a>
          <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span id="selected-brand">{{ $brands->where('id', $brandId)->first() ? $brands->where('id', $brandId)->first()->name : "--请选择--" }}</span>
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="brand-item" href="#">--请选择--</a></li>
                      @foreach ($brands as $brand)
                        <li><a class="brand-item" data-brand-id="{{ $brand->id }}" href="#">[{{ $brand->nameCapital }}] {{ $brand->name }}</a></li>
                      @endforeach
                      </ul>
                    </li>
                  </ul>
                  <form class="navbar-form navbar-left">
                    <button type="button" class="btn btn-default">查询</button>
                  </form>
                </div>
              </div>
          </nav>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>品牌</th>
                  <th>类别</th>
                  <th>产品</th>
                  <th>产品说明</th>
                  <th>产品图片</th>
                  <th>产品状态</th>
                  <th>管理</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($products as $product)
                <tr>
                  <td>{{ object_get($brands->where('id', $product->brandId)->first(), 'name') }}</td>
                  <td>{{ object_get($categories->where('id', $product->categoryId)->first(), 'name') }}</td>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->briefDesc }}</td>
                  <td><img src="{{ $product->thumbnailUrl }}" width="60" height="60" /></td>
                  <td>{{ $product->statusDesc }}</td>
                  <td>
                    <a href="/admin/products/form?productId={{ $product->id }}">编辑</a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent
            <form id="delForm" method="post">
                <input type="hidden" name="_method" value="delete" />
                {{ csrf_field() }}
            </form>
          </div>
@endsection
