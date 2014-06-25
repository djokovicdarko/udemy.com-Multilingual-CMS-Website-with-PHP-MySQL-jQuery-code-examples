$(function() {

	$('#language').live('change', function() {
		languageObject.set($(this));
	});
	
	$('input').live('keypress', function(event) {
		if (event.which == 13) {
			formObject.submit($(this));
			return false;
		}
	});
	
	$('.submit').live('click', function() {
		formObject.submit($(this));
		return false;
	});
	
	$('#contact-form').live('submit', function() {
		formObject.contact($(this));
		return false;
	});

});





