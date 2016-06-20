(function($) {
	$(function() {

		
		function showOrHideStuffInAdmin() {
			$('.wpro-admin div.wpro-form-block').hide();
			var id = $('input[name="wpro-service"]:checked').attr('id');
			if (typeof (id) !== 'undefined') {
				id = id.substr(0, id.length - 5) + 'div';
				$('.wpro-admin #' + id).each(function() {
					$(this).show();
					$('#wpro-form-general-settings').show();
				});
			}
		}
		
		showOrHideStuffInAdmin();

		$('input[name="wpro-service"]:radio').change(showOrHideStuffInAdmin);


	});
}(jQuery));
