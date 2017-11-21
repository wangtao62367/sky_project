/**
 * 基于jquery 实现的一些特效
 * create by wangtao 2017-11-01 15:46:00
 */
$(function(){
	$('.nav-memu-title').click(function(ev){
		if($(this).hasClass('is-opened')){
		    $(this).removeClass('is-opened').parent().find('i').removeClass('ico_up').addClass('ico_down');
		    $(this).parent().find('ul').hide(400);
		}else{
			$('.nav-memu-title').removeClass('is-opened').parent().find('ul').hide(400);
			$('.nav-memu-title').parent().find('i').removeClass('ico_up').addClass('ico_down');
			$(this).addClass('is-opened').parent().find('i').removeClass('ico_down').addClass('ico_up');
			$(this).parent().find('ul').show(400);
		}
	});
	
	$(document).on("click",".modal-close",function(){
		$(this).parent().parent(".dialog").remove();
	});
	
	$(document).on("click",".s_all",function(){
		if($(this).prop("checked")){
			$('.checkbox_item').prop('checked',true);
		}else{
			$('.checkbox_item').prop('checked',false);
		}
	});
	
	$(document).on('click','input[type=reset]',function(){
		console.log($(this).parents('form'));
		$(this).parents('form').find('input').not(':button,:submit,:reset,:hidden').val('').removeAttr('checked').removeAttr('selected');
	})
	
})

var showDialog = function (title,content,width,height,modal){
	var $body = $("body");
	title = title || '标题';
	content = content || '主要内容';
	width = width || 200;
	height = height || 100;
	var top = 2 * height/3;
	var left = width/2;
	modal = modal || false;
	var dialogDiv = [
		'<div class="dialog">',
			modal === true ? '<div class="modal"></div>' : '',
				'<div class="modal-body" style="width: '+width+'px;height: '+height+'px;margin-top:-'+top+'px ;margin-left: -'+left+'px;">',
					'<div class="modal-header">',
						title,
					'</div>',
					'<div class="modal-content">',
						content,
					'</div>',
					'<p class="modal-close">X</p>',
				'</div>',
			'</div>',
		'</div>'
	].join("");
	$body.append(dialogDiv)
};
//阿拉伯数字转换为简写汉字
var Arabia_To_SimplifiedChinese = function (Num) {
    for (i = Num.length - 1; i >= 0; i--) {
        Num = Num.replace(",", "")//替换Num中的“,”
        Num = Num.replace(" ", "")//替换Num中的空格
    }    
    if (isNaN(Num)) { //验证输入的字符是否为数字
        //alert("请检查小写金额是否正确");
        return;
    }
    //字符处理完毕后开始转换，采用前后两部分分别转换
    part = String(Num).split(".");
    newchar = "";
    //小数点前进行转化
    for (i = part[0].length - 1; i >= 0; i--) {
        if (part[0].length > 10) {
            //alert("位数过大，无法计算");
            return "";
        }//若数量超过拾亿单位，提示
        tmpnewchar = ""
        perchar = part[0].charAt(i);
        switch (perchar) {
            case "0":  tmpnewchar = "零" + tmpnewchar;break;
            case "1": tmpnewchar = "一" + tmpnewchar; break;
            case "2": tmpnewchar = "二" + tmpnewchar; break;
            case "3": tmpnewchar = "三" + tmpnewchar; break;
            case "4": tmpnewchar = "四" + tmpnewchar; break;
            case "5": tmpnewchar = "五" + tmpnewchar; break;
            case "6": tmpnewchar = "六" + tmpnewchar; break;
            case "7": tmpnewchar = "七" + tmpnewchar; break;
            case "8": tmpnewchar = "八" + tmpnewchar; break;
            case "9": tmpnewchar = "九" + tmpnewchar; break;
        }
        switch (part[0].length - i - 1) {
            case 0: tmpnewchar = tmpnewchar; break;
            case 1: if (perchar != 0) tmpnewchar = tmpnewchar + "十"; break;
            case 2: if (perchar != 0) tmpnewchar = tmpnewchar + "百"; break;
            case 3: if (perchar != 0) tmpnewchar = tmpnewchar + "千"; break;
            case 4: tmpnewchar = tmpnewchar + "万"; break;
            case 5: if (perchar != 0) tmpnewchar = tmpnewchar + "十"; break;
            case 6: if (perchar != 0) tmpnewchar = tmpnewchar + "百"; break;
            case 7: if (perchar != 0) tmpnewchar = tmpnewchar + "千"; break;
            case 8: tmpnewchar = tmpnewchar + "亿"; break;
            case 9: tmpnewchar = tmpnewchar + "十"; break;
        }
        newchar = tmpnewchar + newchar;
    }   
    //替换所有无用汉字，直到没有此类无用的数字为止
    while (newchar.search("零零") != -1 || newchar.search("零亿") != -1 || newchar.search("亿万") != -1 || newchar.search("零万") != -1) {
        newchar = newchar.replace("零亿", "亿");
        newchar = newchar.replace("亿万", "亿");
        newchar = newchar.replace("零万", "万");
        newchar = newchar.replace("零零", "零");      
    }
    //替换以“一十”开头的，为“十”
    if (newchar.indexOf("一十") == 0) {
        newchar = newchar.substr(1);
    }
    //替换以“零”结尾的，为“”
    if (newchar.lastIndexOf("零") == newchar.length - 1) {
        newchar = newchar.substr(0, newchar.length - 1);
    }
    return newchar;
}