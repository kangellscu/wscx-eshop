<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>留言</title>
		<link rel="stylesheet" type="text/css" href="/h5/css/reset.css?{{ config('assets.version') }}"/>
		<link rel="stylesheet" href="/h5/css/leave.css?{{ config('assets.version') }}" />
        <link rel="stylesheet" href="/h5/css/alert.css?{{ config('assets.version') }}" />
	</head>
	<body>
		
        <div class="return"><span></span><p>为时创想</p></div>
		<div class="leave">
			<p>这是一段信息这是一段信息这是一段信息这是一段信息这是一段信息这是一段信息这是一段信息这是一段信息</p>
			<h1>我们的服务热线：028-64023118</h1>
		</div>
		
        <form method="post" action="/mobile/comment">
		<div class="userInfo">
			<ul>
				<li>姓名：<input type="text" name="name" /></li>
				<li>邮箱：<input type="text" name="email" /></li>
				<li>手机号：<input type="text" name="phone" /></li>
				<li>留言填写：<textarea rows="4" placeholder="请输入留言" name="comment"></textarea></li>
			</ul>
		</div>
            {{ csrf_field() }}
            {{ method_field('put') }}
        </form>

		<div class="btn">
			<button id="submitButton" class="btnActive">我要留言</button>
		</div>
		
		<div class="footer">
	  		<a href="/mobile"><span><img src="/h5/image/tab1-1.png?{{ config('assets.version') }}"/>首页</span></a>
	  		{{-- <a href="/mobile/products"><span><img src="/h5/image/tab2-1.png?{{ config('assets.version') }}"/>产品</span></a> --}}
	  		<a href="/mobile/brands"><span><img src="/h5/image/tab3-1.png?{{ config('assets.version') }}"/>品牌</span></a>
	  		<a href="javascript:vido(0)" class="tabActive"><span><img src="/h5/image/tab4.png?{{ config('assets.version') }}"/>留言</span></a>
	  	</div>
	    <script src="/h5/js/jquery-1.9.0.min.js?{{ config('assets.version') }}"></script>
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

                $('.return').on('click', function () {
                    window.location.href="/mobile";
                });
            });
        </script>
		
	</body>
</html>
