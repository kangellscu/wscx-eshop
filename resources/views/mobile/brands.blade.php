<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>分类</title>
		<link rel="stylesheet" href="/h5/css/reset.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" type="text/css" href="/h5/css/classify.css?{{ config('assets.version') }}"/>
	</head>
	<body>
        <div class="return"><span></span><p>为时创想</p></div>
		<!--右边锚点-->
		<ul id="LoutiNav">
@foreach (range('A', 'Z') as $nameCapital)
			<li @if ($loop->first) class="active" @endif>{{ $nameCapital }}</li>
@endforeach
		</ul>
		<!--右边锚点-->
		<h1 class="classTitle">全部品牌</h1>
		<div class="content">
@foreach (range('A', 'Z') as $nameCapital)
			<div class="product louceng" id="pro1">
				<ul>
    @foreach($brands->where('nameCapital', $nameCapital) as $brand)
					<li>@if ($loop->first) <span>{{ $nameCapital }}</span> @endif <a href="/mobile/products?brandId={{ $brand->id }}&from=brand"><img src="{{ $brand->logoUrl }}"/>{{ $brand->name }}</a></li>
    @endforeach
				</ul>
			</div>
@endforeach
		</div>
		
		<div class="footer">
	  		<a href="/mobile"><span><img src="/h5/image/tab1-1.png?{{ config('assets.version') }}"/>首页</span></a>
	  		{{-- <a href="/mobile/products"><span><img src="/h5/image/tab2-1.png?{{ config('assets.version') }}"/>产品</span></a> --}}
	  		<a href="javascript:void(0)"  class="tabActive"><span><img src="/h5/image/tab3.png?{{ config('assets.version') }}"/>品牌</span></a>
	  		<a href="/mobile/comment"><span><img src="/h5/image/tab4-1.png?{{ config('assets.version') }}"/>留言</span></a>
	  	</div>
		
	</body>
	<script type="text/javascript" src="/h5/js/jquery-1.9.0.min.js?{{ config('assets.version') }}"></script>
	<script src="/h5/js/classify.js?{{ config('assets.version') }}"></script>
	<script type="text/javascript">
        $(function() {
            $('.return').on('click', function () {
                window.location.href="/mobile";
            });
        });
    </script>
</html>
