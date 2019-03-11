<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>为时创想</title>
		<link rel="stylesheet" type="text/css" href="/h5/css/reset.css"/>
		<link rel="stylesheet" type="text/css" href="/h5/css/swiper-3.2.7.min.css" />
		<link rel="stylesheet" href="/h5/css/index.css" />
		
	</head>
	<body>
		
		<!--banner start-->
	  	<div class="banner">
	  		<div class="swiper-container swiper-container1">
			  	<div class="swiper-wrapper">
                @foreach ($banners as $banner)
				    <div class="swiper-slide">
				    	<a href="javascript:void(0)">
				    		<img src="{{ $banner->imageUrl }}"/>
				    	</a>
				    </div>
                @endforeach
			  	</div>
			  	<div class="swiper-pagination swiper-pagination1"></div>
			</div>
	  	</div>
	  	<!--banner end-->
	  	
	  	<div class="content">
        @foreach ($topCategories as $category)
	  		<div class="c_main">
	  			<h1>{{ $category->name }}<a href="">更多 <img src="/h5/image/right.png"/></a></h1>
                <ul>
            @foreach ($products->where('parentId', $category->id) as $product)
	  				<li><a href=""><img src="{{ $product->thumbnailUrl }}"/><span>{{ $product->name }}</span></a></li>
            @endforeach
                </ul>

	  		</div>
        @endforeach
	  	</div>
	  	
	  	<div class="footer">
	  		<a href="javascript:void(0)" class="tabActive"><span><img src="/h5/image/tab1.png"/>首页</span></a>
	  		<a href="/mobile/products"><span><img src="/h5/image/tab2-1.png"/>产品</span></a>
	  		<a href="classify.html"><span><img src="/h5/image/tab3-1.png"/>品牌</span></a>
	  		<a href="leave.html"><span><img src="/h5/image/tab4-1.png"/>留言</span></a>
	  	</div>

		
	</body>
	<script src="/h5/js/jquery-1.9.0.min.js"></script>
	<script src="/h5/js/swiper-3.2.7.min.js"></script>
	<script>
		var mySwiper = new Swiper('.swiper-container1', {
				pagination : '.swiper-pagination1',
				autoplay: 4000,
				autoplayDisableOnInteraction : false,
				paginationClickable: true,
				speed:1000,
				loop : true
			})

	</script>
</html>