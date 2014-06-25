var systemObject = {
	navigation : function() {
		if ($('#navigation li').length > 0) {
			$('#navigation li').hover(function() {
				$(this).children('a:first-child').addClass('active');
				if ($(this).children('dl').length > 0) {
					$(this).children('dl').show();
				}
			}, function() {
				$(this).children('a:first-child').removeClass('active');
				if ($(this).children('dl').length > 0) {
					$(this).children('dl').hide();
				}
			});
		}
	},
	ckEditor : function(obj) {
		if (obj.length > 0) {
			obj.ckeditor();
		}
	},
	order : function(obj) {
		if (obj.length > 0) {
			obj.tableDnD({
				onDragClass: 'yellow',
				onDrop: function(table, row) {
					var rows = jQuery.tableDnD.serialize();
					var url = $('#order_url').text();
					jQuery.post(url, { rows : rows });
				}
			});
		}
	},
	add : function(obj) {
		if (obj.length > 0) {
			obj.submit(function() {
			
				var values = obj.serializeArray();
				var url = $('#add_url').text();
				
				jQuery.post(url, values, function(data) {
					
					if ($('#confirmation').length === 0) {
						obj.before(data.message);
					}
					var delay = setTimeout(function() {
						location.reload();
					}, 2000);
					
				}, 'json');
				
				return false;
				
			});
		}
	},
	update : function(obj) {
		if (obj.length > 0) {
			obj.submit(function() {
				
				var values = obj.serializeArray();
				var url = $('#update_url').text();
				
				jQuery.post(url, { values : values }, function(data) {
					if ($('#confirmation').length === 0) {
						obj.before(data.message);
					}
					var delay = setTimeout(function() {
						location.reload();
					}, 2000);
				}, 'json');
				
				return false;
				
			});
		}
	},
	remove : function(obj) {
		if (obj.length > 0) {
			
			obj.hover(function() {
				$(this).prev('input').addClass('selected');
			}, function() {
				$(this).prev('input').removeClass('selected');
			});
			
			obj.click(function() {
				
				var url = $(this).attr('rel');
				var par = $(this).closest('tr');
				
				jQuery.getJSON(url, function(data) {
					
					if (!data.error) {
						par.fadeOut(300, function() {
							if (data.message) {
								$(this).replaceWith($(data.message).hide().fadeIn(300).css('display', 'table-row'));
							} else {
								$(this).remove();
							}
						});
					}
					
				});
				
				return false;
			});
			
		}
	}
};
$(function() {

	$('#language').live('change', function() {
		languageObject.set($(this));
	});
	
	systemObject.navigation();
	
	systemObject.ckEditor($('.ckEditor'));
	
	systemObject.order($('.tbl_repeat .tbody'));
	
	systemObject.update($('.form-update'));
	
	systemObject.add($('.form-add'));
	
	systemObject.remove($('.remove'));

});