(function($){
	
	// owl carousel
	Drupal.behaviors.art_owlcarousel = {
		attach: function(context,settings) {
			$('.views-owl-carousel').each(function(index){
				var responsiveID = $(this).attr('id');
				var options = jmbxAdjustOptions(settings.owlCarousel[responsiveID]);
				options.navigationText = ['<i class="fa fa-angle-left">', '<i class="fa fa-angle-right">'];
				$('#' + responsiveID).imagesLoaded(function()
				{
					$('#' + responsiveID).owlCarousel(options);
				});
			});
		}
	};
	
	function jmbxAdjustOptions(options){
		var _options = {};
		$.extend(_options, options);
		return _options;
	} 
	
})(jQuery);