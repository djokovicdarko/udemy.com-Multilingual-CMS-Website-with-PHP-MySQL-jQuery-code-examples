var formObject = {
	submit : function(obj) {
		obj.closest('form').submit();
	},
	contact : function(form) {
		var arr = form.serializeArray();
		jQuery.post('/mod/contact-submit.php', arr, function(data) {
			if (!data.error) {
				form.fadeOut(300, function() {
					$('#' + data.message).fadeIn(300).delay(3000).fadeOut(300, function() {
						formObject.clearForm(form);
						form.fadeIn(300);
					});
				});
			} else {
				form.find('.warning').remove();
				if (data.validation) {
					jQuery.each(data.validation, function(k, v) {
						form.find('.' + k).append(v);
					});
				}
			}
		}, 'json');
	},
	clearForm : function(form) {
		var elems = $('input, textarea, select');
		var arr = form.find(elems);
		if (arr.length > 0) {
			jQuery.each(arr, function() {
				$(this).val('');
			});
		}
		form.find('.warning').remove();
	}
};









