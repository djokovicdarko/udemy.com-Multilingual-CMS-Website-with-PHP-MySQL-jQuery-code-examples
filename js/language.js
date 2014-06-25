var languageObject = {
	set : function(obj) {
		var v = obj.val();
		if (v !== '') {
			jQuery.cookie('lang', v, { expires : 365, path : '/' });
			location.reload();
		}
	}
};