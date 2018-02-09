;(function(w){
	var fn = {
		changeUrlArg : function (url, arg, val){
		    var pattern = arg+'=([^&]*)';
		    var replaceText = arg+'='+val;
		    return url.match(pattern) ? url.replace(eval('/('+ arg+'=)([^&]*)/gi'), replaceText) : (url.match('[\?]') ? url+'&'+replaceText : url+'?'+replaceText);
		},
	};
	w.common = fn;
})(window);