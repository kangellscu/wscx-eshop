var oNav = $('#LoutiNav');//导航壳
var aNav = oNav.find('li');//导航
var aDiv = $('.brand_content .louceng');//楼层

$(window).scroll(function(){
	 var winH = $(window).height();//可视窗口高度
	 var iTop = $(window).scrollTop();//鼠标滚动的距离
	 
	 if(iTop>=$('#headers').height()){
	 	oNav.fadeIn();
//				 	oTop.fadeIn();
	 //鼠标滑动式改变	
	 aDiv.each(function(){
	 	if(winH+iTop - $(this).offset().top>winH/2){
	 		aNav.removeClass('active');
	 		aNav.eq($(this).index()).addClass('active');
	 		
	 	}
	 })
	 }else{
	 	oNav.fadeOut();
	 }
})
//点击回到当前楼层
aNav.click(function(){
	var t = aDiv.eq($(this).index()).offset().top;
	$('body,html').animate({"scrollTop":t},500);
	$(this).addClass('active').siblings().removeClass('active');
});



$(function() {
  $(window).scroll(function() {
  //获取垂直滚动的距离
    var scrollTop = $(document).scrollTop();
    if (scrollTop >= 190) {
      $("#LoutiNav").css({"top":"0","position":"fixed"});
    }else {
    $("#LoutiNav").css({"top":"inherit","position":"absolute"});
      } 
    });
});
  
  
