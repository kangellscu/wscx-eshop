@extends('admin.layout')

@section('title', '用户评论')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'brands'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">品牌管理</h1>

          <h2 class="sub-header">品牌列表</h2>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>首字母</th>
                  <th>品牌</th>
                  <th>logo</th>
                  <th>品牌故事</th>
                  <th>编辑</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($brands as $brand)
                <tr>
                  <td>{{ $brand->nameCapital }}</td>
                  <td>{{ $brand->name }}</td>
                  <td><img src="{{ $brand->logoUrl }}" width="60" height="60" /></td>
                  <td>{{ object_get($brand, 'story', '-') }}</td>
                  <td><a href="/admin/products/brand-form?brandId={{ $brand->id }}" />编辑</a>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent
@endsection
