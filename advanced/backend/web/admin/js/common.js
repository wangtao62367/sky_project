
;var dialog = function(title,){
	
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
	$(document).on('click','.s-all',function(e){
		if($(this).prop('checked')){
			$('.item').prop('checked',true);
		}else{
			$('.item').prop('checked',false);
		}
	});
})