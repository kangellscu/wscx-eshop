<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>产品列表</title>
		<link rel="stylesheet" href="/web/css/reset.css?{{ config('assets.version') }}">
		<link rel="stylesheet" href="/web/css/layui.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" href="/web/css/product.css?{{ config('assets.version') }}">
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
					<li><a href="/aboutme">联系我们</a></li>
				</ul>
				
			</div>
		</div>
		<!--nav end-->
		
		
		<!--product start-->
		<div class="product">
			
			<!--select start-->
			<div class="select">
				
                {{--
				<ul class="crumbs_nav">
					<li><a href="javascript:void(0)">全部</a></li>
					<li><a href="javascript:void(0)">手工具</a></li>
					<li><a href="javascript:void(0)">扳手</a></li>
				</ul>
                --}}
				
				<div class="classify">
					<h1>分类：</h1>
					<div class="class_overflow">
						<ul>
@foreach ($distinctCategoryIds as $category)
							<li><a href="/products?from={{ $from }}&brandId={{ $brandId }}&&categoryId={{ $category->id }}">{{ $subCategories->where('id', $category->id)->first()->name }}<span></span></a></li>
@endforeach
						</ul>
					</div>
					<a href="javascript:void(0)" class="more" name="false">更多<img src="/web/image/xiangxia.png?{{ config('assets.version') }}" alt=""></a>
				</div>
				
				<div class="classify classify_two">
					<h1>品牌：</h1>
					<div class="class_overflow">
						<ul>
@foreach ($distinctBrandIds as $brand)
							<li><a href="/products?from={{ $from }}&brandId={{ $brand->id }}&categoryId={{ $categoryId }}">{{ $brands->where('id', $brand->id)->first()->name }}<span></span></a></li>
@endforeach
						</ul>
					</div>
					<a href="javascript:void(0)" class="more" name="false">更多<img src="/web/image/xiangxia.png?{{ config('assets.version') }}" alt=""></a>
				</div>
				
			</div>
			<!--select end-->
			
			<!--product_table start-->
			<div class="product_table">
				
				<ul class="tab_head">
					<li class="li1">产品说明</li>
					<li>产品手册</li>
					<li>使用说明</li>
					<li>品牌介绍</li>
					<li>其他文档</li>
				</ul>
				
				<div class="product_for">
					
@foreach ($products as $product)
					<ul class="tab_main">
						<li class="li1">
							<img src="{{ $product->thumbnailUrl }}" alt="{{ $product->name }}">
							<div class="product_text">
								<h1 title="{{ $product->name }}">{{ $product->name }}</h1>
								<p>型号：{{ $product->briefDesc }}</p>
								<p>品牌：{{ $brands->where('id', $product->brandId)->first()->name }}</p>
							</div>
						</li>
						<li>@if ($product->docSpecificationUrl) <button class="product-doc" data-url="{{ $product->docSpecificationUrl }}">下载文档</button> @else - @endif</li>
						<li>@if ($product->docUrl) <button class="product-doc" data-url="{{ $product->docUrl }}">文档</button> @else - @endif</li>
						<li>@if ($product->docInstructionUrl) <button class="product-doc" data-url="{{ $product->docInstructionUrl }}">品牌介绍</button> @else - @endif</li>
						<li>@if ($product->docOtherUrl) <button class="product-doc" data-url="{{ $product->docOtherUrl }}">其他文档</button> @else - @endif</li>
					</ul>
@endforeach
					
				</div>
				
			</div>
			<!--product_table end-->
			
			<!--分页-->
            {{--
			<div id="page"></div>
            --}}
			
		</div>
		<!--product end-->
		
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
	<script src="/web/js/jquery-1.9.1.min.js?{{ config('assets.version') }}"></script>
	<script src="/web/js/layui.all.js?{{ config('assets.version') }}"></script>
	<script>
		layui.use('laypage', function(){
	  		var laypage = layui.laypage
  			,layer = layui.layer;
	  
	  		//执行一个laypage实例
		  	laypage.render({
		    	elem: 'page'
		    	,count: 70 //数据总数
		    	,jump: function(obj){
		      		console.log(obj)
		    	}
		  	});
		});
		$(function(){
			
			$(".more").click(function(){
				var $this = $(this);
				var flag = $this.attr("name");
				console.log(flag)
				if(flag=="false"){
					$this.prev().children("ul").css({"overflow-y":"auto","height":"auto","max-height":"160px"})
					$this.attr("name","ture").html("收起<img src='/web/image/xiangxia.png?{{ config('assets.version') }}' class='moreImg'>");
					
				}else{
					
					$this.prev().children("ul").css({"overflow-y":"hidden","height":"80px","max-height":"160px"})
					$this.attr("name","false").html("更多<img src='/web/image/xiangxia.png?{{ config('assets.version') }}'>");
				}
				
			});

            $('.product-doc').on('click', function () {
                var url = $(this).data('url');
                if (url) {
                    window.open(url); 
                }
            });
		});
	</script>
</html>
