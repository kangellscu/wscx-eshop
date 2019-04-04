@extends('admin.layout')

@section('title', 'Banner管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'aboutme'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">联系我们</h1>
          <form method="post" action="/admin/aboutme" enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" name="_method" value="put" />
                {{ csrf_field() }}
                <label for="exampleFormControlFile1">上传新图片</label>
                <input type="file" name="image"class="form-control-file"
                    id="exampleFormControlFile1" accept="image/*">
                <button type="submit" class="btn btn-primary mb-2">上传</button>
              </div>
          </form>
        @if ($aboutme)
        <div class="row">
          <div class="col-xs-6 col-md-3">
            <div class="thumbnail">
              <img src="{{ $aboutme->imageUrl }}" alt="联系我们图片">
            </div>
          </div>
        </div>
        @endif
        <div>
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传图片宽度为 1190 时效果最好</p>
            </div>
        </div>

          <form id="handleBannerForm" method="post">
            <input id="handleBannerMethod" type="hidden" name="_method" value="post" />
            {{ csrf_field() }}
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
