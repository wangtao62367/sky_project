;
/*
 * 方法：String.format()
 * 功能：替换字符串的站位符
 * 
 */
String.prototype.format = function() {  
 	if(arguments.length == 0) return this;  
 	var param = arguments[0];  
 	var s = this;  
	if(typeof(param) == 'object') {  
	    for(var key in param) {
	    	s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]); 
	    }
	    return s;  
	} else {  
		for(var i = 0; i < arguments.length; i++) {
		  	s = s.replace(new RegExp("\\{" + i + "\\}", "g"), arguments[i]); 
		}
	  	return s;  
	}  
};
/*
 *　方法:Array.remove(index)
 *　功能:删除数组元素.
 *　参数:dx删除元素的下标.
 *　返回:在原数组上修改数组.
 */
Array.prototype.remove = function(index)
{
　if(isNaN(index)||index>this.length){return false;}
　this.splice(index,1);
}

function checkUrl(urlString){
	if(urlString!=""){
		var reg=/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
		if(!reg.test(urlString)){
			return false;
	    }
		return true;
	}
	return true;
}

var dialog = function(title){
	
}


var batchDel = function($batchDelUrl,callback){
	var idsObj = $("input[name=ids]");
    var ids = '';
    $.each(idsObj,function(index,el){
        if($(el).prop('checked')){
            ids += $(el).val() + ',';
        }
    })
    if(ids == ''){
        alert('请先勾选需要删除的数据');return false;
    }
    var confir = confirm('确认删除勾选的数据？');
    if(confir){
        $.post($batchDelUrl,{ids : ids},function(res){
            console.log(res);
            if(res){
            	callback ? callback() : window.location.reload();
            }
        });
    }
}

$(function(){
	//全选
	$(document).on('click','.s-all',function(e){
		if($(this).prop('checked')){
			$('.item').prop('checked',true);
		}else{
			$('.item').prop('checked',false);
		}
	});
	//导出
	$(document).on('click','.excel-btn',function(){
	    var form = $(this).parents('form')[0];
	    var exportInput =$('<input/>').attr('type','hidden').attr('name','handle').val('export');
	    $(form).append(exportInput);
	    $(form).submit();
	    exportInput.remove();
	})
})