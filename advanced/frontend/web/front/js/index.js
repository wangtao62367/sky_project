;$(document).on('click','.title h4',function(){
    var _this = $(this);
    var cateCode = _this.data("target-id");
    _this.parent().parent().find('.articlelist').hide();
    $("#"+cateCode).show();

    _this.parent().find('h4').removeClass('news-selected').removeClass('news-unselected').addClass('news-unselected');
    _this.removeClass('news-unselected').addClass('news-selected');
    
    var url = _this.parent().find("a").attr("href");
    var newUrl = url;
    if(url.indexOf('code') != -1){
        newUrl = common.changeUrlArg(url,'code',cateCode);
    }else{
    	var lastIndex = url.lastIndexOf('/') + 1;
    	newUrl = url.substring(0,lastIndex) + cateCode + '.html';
    }
    
    _this.parent().find("a").attr("href",newUrl)
});

/**
 * 新闻列表切换 
 */
$(document).on('mouseover','.news-cates .cate',function(){
	var _this = $(this);
	if(_this.hasClass("selected")){
		return false; 
	}
	var cateCode = _this.data("target-id");
	_this.parents('.news-cates').parent().find('.news-list').hide();
    $("#"+cateCode).show();
    
    _this.parents('.news-cates').find('.cate').removeClass('selected');
    _this.addClass('selected');
    
});

/**
 * 图文新闻切换
 */
$(document).on('mouseover','.news-items .item',function(){
	 var _this = $(this);
	 if(_this.hasClass("selected")){
		return false; 
	 }
	 var titleImg = _this.data("target-titleimg");
	 var url = _this.data("target-url");
	 var title = _this.data("target-title");
	 $('.news-img-box').find("img").attr("src",titleImg);
	 $('.news-img-box').find("a").attr("href",url).attr("title",title);;
	 
	 _this.parent().find('.item').removeClass('selected');
	 _this.addClass('selected');
	
})



$(document).on('click','.video-item',function(){
	if($(this).hasClass('prism-player')){
		return false;
	}
	var source = $(this).data('videourl');
	var id = $(this).attr('id');
	var player = new Aliplayer({
            id: id,
            width: '280px',
			height: '185px',
            autoplay: true,
            //支持播放地址播放,此播放优先级最高
            source : source,
            /* //播放方式二：点播用户推荐
            vid : '1e067a2831b641db90d570b6480fbc40',
            playauth : '',
            cover: 'http://liveroom-img.oss-cn-qingdao.aliyuncs.com/logo.png',            
            //播放方式三：仅MTS用户使用
            vid : '1e067a2831b641db90d570b6480fbc40',
            accId: '',
            accSecret: '',
            stsToken: '',
            domainRegion: '',
            authInfo: '',
            //播放方式四：使用STS方式播放
            vid : '1e067a2831b641db90d570b6480fbc40',
            accessKeyId: '',
            securityToken: '',
            accessKeySecret: '' */
            },function(player){
                console.log('播放器创建好了。')
           });
	player.on('ready',function(){
		$(".prism-big-play-btn").remove();
	});
})



//创建首页浮动广告
function createAdvDom(position,title,img,link){
    var advBox = $("<div></div>").addClass("adv-box");
    var imgW = 120;
    var imgH = 300;
    if(position == 'left'){
        advBox.addClass('adv-left');
    }else if(position == 'right'){
        advBox.addClass('adv-right');
    }else if(position == 'top'){
        advBox.addClass('adv-top');
        imgW = 1200;
        imgH = 120;
    }else if(position == 'bottom'){
        advBox.addClass('adv-bottom');
        imgW = 1200;
        imgH = 120;
    }else{
        return false;
    }
    var advBody = $('<div></div>').addClass('body');
    
    var contentA = $('<a></a>').attr('title',title).attr('href',link);
    var contentImg = $('<img/>').width(imgW).height(imgH).attr('src',img);
    advBody.append(contentA.append(contentImg));

    var closeBtn = $('<a></a>').attr('href','javascript:;').addClass("close-adv").text("关闭");
    advBox.append(advBody,closeBtn);
    $(document).find('body').append(advBox);
    $(document).on('click','.adv-box .close-adv',function(){
        $(this).parent().remove();
    })
}
//横向轮播滚动
function ScrollImgLeft(id,scrollId){  
	var speed= 50  
	var scroll_begin = $("#"+id);  
	var scroll_end = $("#"+id+"-end");  
	var scroll_div = $("#"+scrollId);
	
	var childW = $(scroll_begin.children(':first-child')[0]).width();
	var w = (childW+25) * (scroll_begin.children()).length;
	scroll_begin.width(w);
	scroll_end.width(w);
	function Marquee(){  
		if(scroll_end.outerWidth(false)-scroll_div.scrollLeft()<=0)  {
			var left = scroll_div.scrollLeft() - scroll_begin.outerWidth(false);
			scroll_div.scrollLeft(left);
		}else{
			var left = scroll_div.scrollLeft();
			left ++;
			scroll_div.scrollLeft(left);
		}
	} 
	var MyMar=setInterval(Marquee,speed)  
	scroll_div.mouseover(function(){
		clearInterval(MyMar);
	}).mouseout(function(){
		MyMar=setInterval(Marquee,speed);
	})

} 
ScrollImgLeft('edu-list',"scroll_div");
ScrollImgLeft('video-list-box','video-box');