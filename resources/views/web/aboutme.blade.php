<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>为时创想</title>
		<link rel="stylesheet" href="/web/css/reset.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" href="/web/css/jquery.bxslider.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" href="/web/css/index.css?{{ config('assets.version') }}" />
		
		<script src="/web/js/jquery-1.9.1.min.js?{{ config('assets.version') }}"></script>
		<script src="/web/js/jquery.bxslider.js?{{ config('assets.version') }}"></script>
	</head>
	<body>
		
		<!--header start-->
		<div class="header">
			<div class="head_main">
				<p>你好，欢迎来到为时创想科技</p>
				<div class="head_tel">
					<p>联系我们</p>
					<p><img src="/web/image/phone.png?{{ config('assets.version') }}"/>300-400-4325</p>
				</div>
			</div>
		</div>
		<!--header end-->
		
		<!--nav start-->
		<div class="nav">
			<div class="nav_main">
				
				<div class="logo">
					<a href="javascript:void(0)" class="logoImg"><img src="/web/image/logo.png?{{ config('assets.version') }}"/></a>
					<a href="javascript:void(0)" class="logoText"><img src="/web/image/logo_text.png?{{ config('assets.version') }}"/></a>
				</div>
				
				<ul class="nav_list">
					<li><a href="/">首页</a></li>
					<li><a href="/brands">制造商品牌</a></li>
					<li><a href="/comment">需求留言</a></li>
					<li><a href="javascript:void(0)" class="nav_hover">联系我们</a></li>
				</ul>
				
			</div>
		</div>
		<!--nav end-->
		
		<div class="contact_main">
			<div class="contact_width">
@if ($aboutme)
                <img src="{{ $aboutme->imageUrl }}" alt="联系我们" />
@endif
			</div>
		</div>
		<!--main end-->
		
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
					<li>
						<img src="/web/image/foot3.png?{{ config('assets.version') }}"/>
						<h1>7天无理由退换货<strong>企业定制类产品除外</strong></h1>
					</li>
				</ul>
				
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
				
				<div class="foot_logo">
					<p class="footLogo">
						<a href=""><img src="/web/image/foot_logo.png?{{ config('assets.version') }}"/></a>
					</p>
					<p class="foot_code"><img src="/web/image/code.png?{{ config('assets.version') }}"/><span>微信服务号</span></p>
				</div>
				
				<p class="copyright">版权所有©2006-2019 固安捷（中国）工业品销售有限责任公司 沪ICP备06042629号-1</p>
				
			</div>
			
		</div>
		<!--footer end-->
		
	</body>
</html>
