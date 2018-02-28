;(function(w){
	var fn = {
		changeUrlArg : function (url, arg, val){
		    var pattern = arg+'=([^&]*)';
		    var replaceText = arg+'='+val;
		    return url.match(pattern) ? url.replace(eval('/('+ arg+'=)([^&]*)/gi'), replaceText) : (url.match('[\?]') ? url+'&'+replaceText : url+'?'+replaceText);
		},
		/**
		 * 时间秒数格式化
		 * @param s 时间戳（单位：秒）
		 * @returns {*} 格式化后的时分秒
		 */
		sec_to_time : function(s) {
		    var t;
		    if(s > -1){
		        var hour = Math.floor(s/3600);
		        var min = Math.floor(s/60) % 60;
		        var sec = s % 60;
		        if(hour < 10) {
		            t = '0'+ hour + ":";
		        } else {
		            t = hour + ":";
		        }

		        if(min < 10){t += "0";}
		        t += min + ":";
		        if(sec < 10){t += "0";}
		        t += sec.toFixed(0);
		    }
		    return t;
		},
	    /**
	     * 时间转为秒
	     * @param time 时间(00:00:00)
	     * @returns {string} 时间戳（单位：秒）
	     */
	    time_to_sec : function (time) {
	        var s = '';

	        var hour = time.split(':')[0];
	        var min = time.split(':')[1];
	        var sec = time.split(':')[2];

	        s = Number(hour*3600) + Number(min*60) + Number(sec);

	        return s;
	    },
	    /**
	     * 上传文件
	     * @param formData 数据new FormData($('#uploadForm')[0])
	     * @param trueCallBack 请求成功回调
	     * @param failCallBack 请求失败回调
	     */
	    uploadFile : function (formData,trueCallBack,failCallBack) {
	    	
	    	$.ajax({
	    	    url: '/user/ajax-upload',
	    	    type: 'POST',
	    	    cache: false,
	    	    data: formData,//new FormData($('#uploadForm')[0]),
	    	    processData: false,
	    	    contentType: false
	    	}).done(function(res) {
	    		trueCallBack || trueCallBack(res);
	    	}).fail(function(res) {
	    		failCallBack || failCallBack();
	    	}); 
	    }
	};
	w.common = fn;
})(window);