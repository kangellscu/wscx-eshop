<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>产品</title>
		<link rel="stylesheet" href="/h5/css/reset.css" />
		<link rel="stylesheet" href="/h5/css/product.css" />
	</head>
	<body>
		
		<div class="proNav">
			<h1>推荐品牌</h1>
			<div class="wrapper" id="wrapper1">
				<div class="scroller">
					<ul class="clearfix">
@foreach ($brands as $brand)
						<li @if ($brand->id == $brandId) class="cur brand-item" @else class="brand-item" @endif data-id="{{ $brand->id }}"><span><img src="{{ $brand->logoUrl }}"/></span></li>
@endforeach
					</ul>
				</div>
			</div>
			<h1>产品分类</h1>
			<div class="wrapper" id="wrapper2">
				<div class="scroller">
					<ul class="clearfix">
@foreach ($subCategories as $category)
						<li @if ($category->id == $categoryId) class="cur category-item" @else class="category-item" @endif data-id="{{ $category->id }}"><span>{{ $category->name }}</span></li>
@endforeach
					</ul>
				</div>
			</div>
		</div>
		
		<div class="product">
			<ul>
                <!--
				<li>
					<a href="">
						<img src="/h5/image/product2.png"/>
						<span>
							<h1>ABB S200系列微型断路器系列断路器系列断路器系列微型</h1>
							<p>订货号：924856</p>
							<p>货期：当日发货</p>
							<h2>￥<small>27.00</small>/个</h2>
						</span>
					</a>
				</li>
                -->
@foreach ($products as $product)
				<li>
					<a href="">
						<img src="{{ $product->thumbnailUrl }}"/>
						<span>
							<h1>{{ $product->name }}</h1>
							<p>{{ $product->briefDesc }}</p>
							<h2>￥<small>27.00</small>/个</h2>
						</span>
					</a>
				</li>
@endforeach
			</ul>
		</div>
        <form method="get" action="/mobile/products">
            <input type="hidden" name="brandId" value="{{ $brandId ? $brandId : '' }}" />
            <input type="hidden" name="categoryId" value="{{ $categoryId ? $categoryId : '' }}" />
        </form>
		
		<div class="footer">
	  		<a href="/mobile"><span><img src="/h5/image/tab1-1.png"/>首页</span></a>
	  		<a href="javascript:void(0)" class="tabActive"><span><img src="/h5/image/tab2.png"/>产品</span></a>
	  		<a href="/mobile/brands"><span><img src="/h5/image/tab3-1.png"/>品牌</span></a>
	  		<a href="/mobile/comment"><span><img src="/h5/image/tab4-1.png"/>留言</span></a>
	  	</div>
		
	</body>
	<script type="text/javascript" src="/h5/js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="/h5/js/iscroll.js"></script>
	<script type="text/javascript" src="/h5/js/navbarscroll.js"></script>
	<script type="text/javascript">
		$(function(){
			//demo示例一到四 通过lass调取，一句可以搞定，用于页面中可能有多个导航的情况
			$('.wrapper').navbarscroll();
		
			//demo示例五 通过id调取
			/*$('#demo05').navbarscroll({
				defaultSelect:6,
				endClickScroll:function(obj){
					console.log(obj.text())
				}
			});
			
			//demo示例六 通过id调取
			$('#demo06').navbarscroll({
				defaultSelect:3,
				scrollerWidth:6,
				fingerClick:1,
				endClickScroll:function(obj){
					console.log(obj.text())
				}
			});*/
            $('.brand-item').on('click', function () {
                $('form input[name="brandId"]').val($(this).data('id'));
                $('form').submit();
            });
            $('.category-item').on('click', function () {
                $('form input[name="categoryId"]').val($(this).data('id'));
                $('form').submit();
            });
		});
	</script>


</html>
