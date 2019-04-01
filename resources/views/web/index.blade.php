<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>为时创想</title>
		<link rel="stylesheet" href="/web/css/reset.css" />
		<link rel="stylesheet" href="/web/css/jquery.bxslider.css" />
		<link rel="stylesheet" href="/web/css/index.css" />
		
		<script src="/web/js/jquery-1.9.1.min.js"></script>
		<script src="/web/js/jquery.bxslider.js"></script>
	</head>
	<body>
		
		<!--header start-->
		<div class="header">
			<div class="head_main">
				<p>你好，欢迎来到为时创想科技</p>
				<div class="head_tel">
					<p>联系我们</p>
					<p><img src="/web/image/phone.png"/>300-400-4325</p>
				</div>
			</div>
		</div>
		<!--header end-->
		
		<!--nav start-->
		<div class="nav">
			<div class="nav_main">
				
				<div class="logo">
					<a href="javascript:void(0)" class="logoImg"><img src="/web/image/logo.png"/></a>
					<a href="javascript:void(0)" class="logoText"><img src="/web/image/logo_text.png"/></a>
				</div>
				
				<ul class="nav_list">
					<li><a href="javascript:void(0)" class="total">产品分类</a></li>
					<li><a href="javascript:void(0)">首页</a></li>
					<li><a href="javascript:void(0)" class="nav_hover">制造商品牌</a></li>
					<li><a href="javascript:void(0)">需求留言</a></li>
					<li><a href="javascript:void(0)">联系我们</a></li>
				</ul>
				
			</div>
		</div>
		<!--nav end-->
		
		<!--banner_content start-->
		<div class="banner_content">
			
			<div class="banner_main">
				
				<ul class="class_list">
    @foreach($categories->where('level', 1) as $topCategory)
					<li>
						<p><img src="/web/image/icon1.png"/><a href="">{{ $topCategory->name }}</a></p>
						<div class="hideItem">
							<div class="item">
								<h1>{{ $topCategory->name }}</h1>
								<ul>
        @foreach($categories->where('parentId', $topCategory->id) as $subCategory)
									<li><a href="">{{ $subCategory->name }}</a></li>
        @endforeach
								</ul>
							</div>
						</div>
					</li>
    @endforeach
				</ul>
				
				
				
				<div class="banner">
					<div class="slider6">
                @forelse ($banners as $banner)
				      	<div class="slide"><img src="{{ $banner->imageUrl }}"></div>
                @empty
				      	<div class="slide"><img src="/web/image/banner1.png"></div> 
                @endforelse
				   	</div>
				    <script type="text/javascript">
				        $(document).ready(function(){
				          $('.slider6').bxSlider({
							mode: 'fade',
							auto: true
//				            slideWidth: 600, 
//				            slideMargin: 10
				          });
				        });
				    </script>
				</div>
				
				<div class="contact">
					<ul class="contact_list">
						<li><img src="/web/image/tel1.png"/><p>品类齐全</p></li>
						<li><img src="/web/image/tel2.png"/><p>多仓直发 </p></li>
						<li><img src="/web/image/tel3.png"/><p>正品行货</p></li>
						<li><img src="/web/image/tel4.png"/><p>天天低价</p></li>
						<li><img src="/web/image/tel5.png"/><p>专业客服</p></li>
						<li><img src="/web/image/tel6.png"/><p>售后保障</p></li>
					</ul>
					<div class="contact_tel">
						<h1>服务热线</h1>
						<h2>300-400-4325</h2>
					</div>
				</div>
				
			</div>
			
		</div>
		<!--banner_content end-->
		
		<!--main start-->
		
		<div class="main">
			<div class="main_width">
				
    @foreach($categories->where('level', 1) as $topCategory)
				<div class="product">
					
					<h1 class="class_title">{{ $topCategory->name }}</h1>
        @foreach($categories->where('parentId', $topCategory->id) as $subCategory)
					<div class="prduct_lsit">
						<div class="left_title">
							<p>{{ $subCategory->name }}</p>
						</div>
						<ul>
            @foreach($products->where('categoryId', $subCategory->id)->take(12) as $product)
							<li><a href=""><span><img src="{{ $product->thumbnailUrl }}"/></span><p>{{ $product->name }}</p></a></li>
							
            @endforeach
						</ul>
					</div>
        @endforeach
				</div>
    @endforeach				
				
			</div>
		</div>
		<!--main end-->
		
		<!--footer start-->
		<div class="footer">
			
			<div class="foot_main">
				
				<ul class="foot_tab">
					<li>
						<img src="/web/image/foot4.png"/>
						<h1>品类齐全<strong>省心省力，一站购齐</strong></h1>
					</li>
					<li>
						<img src="/web/image/foot2.png"/>
						<h1>一对一客服<strong>快速响应</strong></h1>
					</li>
					<li>
						<img src="/web/image/foot1.png"/>
						<h1>闪电发货<strong>货期保障</strong></h1>
					</li>
					<li>
						<img src="/web/image/foot3.png"/>
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
						<a href=""><img src="/web/image/foot_logo.png"/></a>
					</p>
					<p class="foot_code"><img src="/web/image/code.png"/><span>微信服务号</span></p>
				</div>
				
				<p class="copyright">版权所有©2006-2019 固安捷（中国）工业品销售有限责任公司 沪ICP备06042629号-1</p>
				
			</div>
			
		</div>
		<!--footer end-->
		
	</body>
</html>
