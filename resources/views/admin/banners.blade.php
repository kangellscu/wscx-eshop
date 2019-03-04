@extends('admin.layout')

@section('title', 'Banner管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
          <h1 class="page-header">Banner管理</h1>
          <form method="post" action="/admin/banners" enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" name="_method" value="put" />
                {{ csrf_field() }}
                <label for="exampleFormControlFile1">上传新banner</label>
                <input type="file" name="image"class="form-control-file"
                    id="exampleFormControlFile1" accept="image/*">
                <button type="submit" class="btn btn-primary mb-2">上传</button>
              </div>
          </form>
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
                  @foreach ($activedBanners as $banner)
                    <tr>
                      <td><img src="{{ $banner->imageUrl }}" width="100" height="100" /></td>
                      <td>{{ $banner->createdAt->format('Y-m-d H:i:s') }}</td>
                      <td><a class="handleBanner"
                            data-action="/admin/banners/{{ $banner->id }}/deactivation"
                            data-actionname="下架"
                            href="javascript:void();">下架</a></td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
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
                  <th>删除</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($deactivedBanners as $banner)
                <tr>
                  <td><img src="{{ $banner->imageUrl }}" width="100" height="100" /></td>
                  <td>{{ $banner->createdAt->format('Y-m-d H:i:s') }}</td>
                  <td><a class="handleBanner"
                        data-action="/admin/banners/{{ $banner->id }}/activation"
                        data-actionname="上架"
                        href="javascript:void();">上架</a></td>
                  <td><a class="handleBanner"
                        data-action="/admin/banners/{{ $banner->id }}"
                        data-actionname="删除"
                        data-method="delete"
                        href="javascript:void();">删除</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent

          <form id="handleBannerForm" method="post">
            <input id="handleBannerMethod" type="hidden" name="_method" value="post" />
            {{ csrf_field() }}
          </form>
@endsection

@section('body-assets')
<script type="application/javascript">

$(".handleBanner").on("click", function() {
    if (confirm("确定要" + $(this).data("actionname") + "么?")) {
        var submitMethod = $(this).data('method') === undefined ?
            'post' : $(this).data('method');
        $("#handleBannerMethod").val(submitMethod);
        $("#handleBannerForm").attr("action", $(this).data("action")).submit(); 
    }
});

</script>
@endsection
