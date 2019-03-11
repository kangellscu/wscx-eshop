var oNav = $('#LoutiNav');//导航壳
var aNav = oNav.find('li');//导航
var aDiv = $('.content .louceng');//楼层

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


(function () {

	bDiv.find(".itemtext").addClass("itemtextLeft");
	bDiv.find(".itemimg").addClass("itemimgRgiht");
})();


$(window).scroll(function(){
	var winH = $(window).height();//可视窗口高度
	var iTop = $(window).scrollTop();//鼠标滚动的距离
	 
	if(iTop>=$('#headers').height()){
	 	oNav.fadeIn();
	 	cDiv.each(function(){
		 	if(winH+iTop - $(this).offset().top>winH/2){
		 		cDiv.find(".itemtext").addClass("itemtextRight");
		 		cDiv.find(".itemimg").addClass("itemimgRgiht");
		 	}
		})
	}
})
//$(window).scroll(function(){
//	var winH = $(window).height();//可视窗口高度
//	var iTop = $(window).scrollTop();//鼠标滚动的距离
//	 
//	if(iTop>=$('#headers').height()){
//	 	oNav.fadeIn();
//	 	dDiv.each(function(){
//		 	if(winH+iTop - $(this).offset().top>winH/2){
//		 		dDiv.find(".itemtext").addClass("itemtextLeft");
//		 		dDiv.find(".itemimg").addClass("itemimgRgiht");
//		 	}
//		})
//	}
//})
//$(window).scroll(function(){
//	var winH = $(window).height();//可视窗口高度
//	var iTop = $(window).scrollTop();//鼠标滚动的距离
//	 
//	if(iTop>=$('#headers').height()){
//	 	oNav.fadeIn();
//	 	eDiv.each(function(){
//		 	if(winH+iTop - $(this).offset().top>winH/2){
//		 		eDiv.find(".itemtext").addClass("itemtextRight");
//		 		eDiv.find(".itemimg").addClass("itemimgRgiht");
//		 	}
//		})
//	}
//})