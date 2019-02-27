@extends('admin.layout')

@section('title', 'Banner管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
          <h1 class="page-header">Banner管理</h1>

          <h2 class="sub-header">已上架Banners</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Banner图片</th>
                  <th>创建时间</th>
                  <th>下架</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($deactivedBanners as $banner)
                    <tr>
                      <td><img src="{{ $banner->image_url }}" width="100" height="100" /></td>
                      <td>{{ $banner->createdAt->format('Y-m-d H:i:s') }}</td>
                      <td><a class="handleBanner"
                            data-action="{{/admin/banners/{{ $banner->id }}/deactivation"
                            data-actionname="下架"
                            href="javascript:void();">下架</a></td>
                    </tr>
                  @endforeach
              </tbody>
          </div>

          <h2 class="sub-header">待上架Banners</h2>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Banner图片</th>
                  <th>创建时间</th>
                  <th>上架</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($deactivedBanners as $banner)
                <tr>
                  <td><img src="{{ $banner->image_url }}" width="100" height="100" /></td>
                  <td>{{ $banner->createdAt->format('Y-m-d H:i:s') }}</td>
                  <td><a class="handleBanner"
                        data-action="{{/admin/banners/{{ $banner->id }}/deactivation"
                        data-actionname="上架"
                        href="javascript:void();">上架</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent

          <form id="handleBannerForm">
            {{ csrf_field() }}
          </form>
@endsection

@section('body-assets')
<script type="application/javascript">

$(".handleBanner").on("click", function() {
    if (confirm("确定要" + $(this).data("actionname") + "么?")) {
        $("#handleBannerForm").attr("action", $(this).data("action").submit(); 
    }
});

</script>
@endsection
