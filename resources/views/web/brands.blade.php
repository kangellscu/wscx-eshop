<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>制造商品牌</title>
		<link rel="stylesheet" href="/web/css/reset.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" href="/web/css/brand.css?{{ config('assets.version') }}">
	</head>
	<body>
		
		<!--header start-->
		<div class="header">
			<div class="head_main">
				<p>工业智能制造服务平台、定制化技术解决方案专家</p>
				<div class="head_tel">
					<p>联系我们</p>
					<p><img src="/web/image/phone.png?{{ config('assets.version') }}"/>028-64023118</p>
				</div>
			</div>
		</div>
		<!--header end-->
		
		<!--nav start-->
		<div class="nav">
			<div class="nav_main">
				
				<div class="logo">
					<a href="javascript:void(0)" class="logoImg"><img src="/web/image/foot_logo.png?{{ config('assets.version') }}"/></a>
					<a href="javascript:void(0)" class="logoText"><img src="/web/image/logo_text.png?{{ config('assets.version') }}"/></a>
				</div>
				
				<ul class="nav_list">
					<li><a href="/">首页</a></li>
					<li><a href="javascript:void(0)" class="nav_hover">制造商品牌</a></li>
					<li><a href="/comment">需求留言</a></li>
					<li><a href="/aboutme">联系我们</a></li>
				</ul>
				
			</div>
		</div>
		<!--nav end-->
		
		<!-- brand start -->
		<div class="brand">
			<div class="brand_main">
				
				<!-- 字母排序 start -->
				<div class="brandNav">
					<p>按字母搜索</p>
					<ul data-type="name-capital">
						<li class="firstLi activeLi">全部</li>
@foreach (range('A', 'Z') as $nameCapital)
                        <li>{{ $nameCapital }}</li>
@endforeach
					</ul>
				</div>
				<!-- 字母排序 end-->
				<div class="brand_module">
					
					<!-- 单个字母模块start -->
@foreach(range('A', 'Z') as $nameCapital)
					<div class="brand_alone" data-name-capital="{{ $nameCapital }}">
                        <h1><i></i>{{ $nameCapital }}</h1>
                        <ul>
    @foreach($brands->where('nameCapital', $nameCapital) as $brand)
                            <li><a href="/products?from=brand&brandId={{ $brand->id }}"><img src="{{ $brand->logoUrl }}" alt=""><span>{{ $brand->name }}</span></a>
    @endforeach
                        </ul>
                    </div>
@endforeach
				</div>
			</div>
		</div>
		<!-- brand end -->
		
		<!--footer start-->
		<div class="footer">
			
			<div class="foot_main">
				
				<ul class="foot_tab">
					<li>
						<img src="/web/image/foot4.png?{{ config('assets.version') }}"/>
						<h1>品类齐全<strong>省心省力，一站购齐</strong></h1>
					</li>
					<li>
						<img src="/web/image/foot2.png?{{ config('assets.version') }}"/>
						<h1>一对一客服<strong>快速响应</strong></h1>
					</li>
					<li>
						<img src="/web/image/foot1.png?{{ config('assets.version') }}"/>
						<h1>闪电发货<strong>货期保障</strong></h1>
					</li>
                    <!--
					<li>
						<img src="/web/image/foot3.png?{{ config('assets.version') }}"/>
						<h1>7天无理由退换货<strong>企业定制类产品除外</strong></h1>
					</li>
                    -->
				</ul>
				
                <!--
				<ul class="ship">
					<li>
						<p>如何注册</p>
						<a href="">手机注册</a>
					</li>
					<li>
						<p>如何下单</p>
						<a href="">下单流程</a>
						<a href="">订单状态</a>
					</li>
					<li>
						<p>如何支付</p>
						<a href="">网上支付</a>
						<a href="">银行转账</a>
					</li>
					<li>
						<p>配送政策</p>
						<a href="">配送政策</a>
					</li>
					<li>
						<p>售后服务</p>
						<a href="">售后政策</a>
						<a href="">7天无理由退换货</a>
						<a href="">投诉与建议</a>
					</li>
					<li>
						<p>网站地图</p>
						<a href="">全部产品分类</a>
						<a href="">全部品牌</a>
					</li>
				</ul>
                -->
				
				<div class="foot_logo">
					<p class="footLogo">
						<a href=""><img src="/web/image/foot_logo.png?{{ config('assets.version') }}"/></a>
					</p>
					<p class="foot_code"><img src="/web/image/code.png?{{ config('assets.version') }}"/><span>微信服务号</span></p>
				</div>
				
				<p class="copyright"></p>
				
			</div>
			
		</div>
		<!--footer end-->
		
	</body>
	<script src="/web/js/jquery-1.9.1.min.js?{{ config('assets.version') }}"></script>
	<script type="text/javascript">
		$(function(){
			// 获取导航栏到屏幕顶部的距离
			var oTop = $(".brandNav").offset().top;
			//获取导航栏的高度，此高度用于保证内容的平滑过渡
			var martop = $('.brandNav').outerHeight();
		 
			var sTop = 0;
			// 监听页面的滚动
			$(window).scroll(function () {
				// 获取页面向上滚动的距离
				sTop = $(this).scrollTop();
				// 当导航栏到达屏幕顶端
				if (sTop+32 >= oTop) {
					// 修改导航栏position属性，使之固定在屏幕顶端
					$(".brandNav").css({ "position": "fixed", "top": "0" });
					// 修改内容的margin-top值，保证平滑过渡
					$(".brand_module").css({ "margin-top": martop });
				} else {
					// 当导航栏脱离屏幕顶端时，回复原来的属性
					$(".brandNav").css({ "position": "static" });
					$(".brand_module").css({ "margin-top": "0" });
				}
			})

            $('ul[data-type="name-capital"] > li').on('click', function() {
                $('ul[data-type="name-capital"] > li.activeLi').removeClass('activeLi');
                $(this).addClass('activeLi');
                var selected = $(this).text();
                if (selected == '全部') {
                    $('div.brand_module > div.brand_alone').show();
                } else {
                    $('div.brand_module > div.brand_alone').hide();
                    $('div.brand_module > div.brand_alone[data-name-capital="' + selected + '"]').show();
                }
            });
		})
	</script>
</html>
