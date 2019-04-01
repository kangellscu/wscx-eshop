<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>留言</title>
		<link rel="stylesheet" href="/web/css/reset.css?{{ config('assets.version') }}" />
		<link rel="stylesheet" href="/web/css/leave.css?{{ config('assets.version') }}">
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
					<li><a href="javascript:void(0)" class="total">产品分类</a></li>
					<li><a href="/">首页</a></li>
					<li><a href="/brands">制造商品牌</a></li>
					<li><a href="javascript:void(0)" class="nav_hover">需求留言</a></li>
					<li><a href="javascript:void(0)">联系我们</a></li>
				</ul>
				
			</div>
		</div>
		<!--nav end-->
		
		<!-- Leave a message start -->
		<div class="leave">
			<div class="leave_main">
				<p>
					这里是一段文字说明，浔阳江头夜送客，枫叶荻花秋瑟瑟。主人下马客在船，举酒欲饮无管弦。醉不成欢惨将别，别时茫茫江浸月
					浔阳江头夜送客，枫叶荻花秋瑟瑟。主人下马客在船，举酒欲饮无管弦。醉不成欢惨将别，别时茫茫江浸月
					浔阳江头夜送客，枫叶荻花秋瑟瑟。主人下马客在船，举酒欲饮无管弦。醉不成欢惨将别，别时茫茫江浸月
				</p>
                <form method="post" action="/comment">
				<div class="leaveForm">
					<ul class="form_left">
						<li><span>用户名：</span><input type="text" name="name" placeholder="请输入姓名"></li>
						<li><span>邮箱：</span><input type="text" name="email" placeholder="请输入邮箱"></li>
						<li><span>其他联系方式：</span><input type="text" name="phone" placeholder="请输入手机号"></li>
					</ul>
					<ul class="form_right">
						<li><span>用户留言：</span><textarea placeholder="请输入留言" name="comment"></textarea></li>
					</ul>
				</div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                </form>
				<h1 class="leaveBtn"><button id="submitButton">提交留言</button></h1>
				
			</div>
		</div>
		<!-- Leave a message end -->
		
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
		
	    <script src="/web/js/jquery-1.9.1.min.js?{{ config('assets.version') }}"></script>
        <script src="/h5/js/alert.js?{{ config('assets.version') }}"></script>
        <script type="application/javascript">
            function showError(message) {
                jqueryAlert({
                    icon    : '/h5/image/warning.png?{{ config('assets.version') }}',
                    content : message,
                    closeTime : 2000
                }).show();
            }
            function showInfo(message) {
                jqueryAlert({
                    icon    : '/h5/image/right2.png?{{ config('assets.version') }}',
                    content : message,
                    closeTime : 2000
                }).show();
            }
            function checkPhone(phone) { 
                return (/^1[34578]\d{9}$/.test(phone));
            }
            function checkEmail(email) {
                return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email);
            }
            $(document).ready(function () {
                var submitStatus = @if (session('submitStatus')) 'success' @else null @endif;
                if (submitStatus === 'success') {
                    showInfo('提交成功');
                }
                $('#submitButton').on('click', function () {
                    var name = $('form input[name="name"]').val();
                    var email = $('form input[name="email"]').val();
                    var phone = $('form input[name="phone"]').val();
                    var comment = $('form textarea[name="comment"]').val();
                    if ( ! name) {
                        showError('请输入您的名字');
                        return;
                    } else if (name.length > 16) {
                        showError('您的名字太长啦');
                        return;
                    }
                    if ( ! email && ! phone) {
                        showError('请您输入邮箱或者手机号码');
                        return;
                    }
                    if (phone && ! checkPhone(phone)) {
                        showError('手机号格式错误');
                        return;
                    }
                    if (email && ! checkEmail(email)) {
                        showError('邮箱格式错误');
                        return;
                    }
                    if ( ! comment) {
                        showError('请输入您的留言');
                        return;
                    }

                    $('form').submit();
                });
            });
        </script>
	</body>
</html>
