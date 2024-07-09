jQuery(function($) {

	var isDraggable = $(document).width() > 1024 ? true : false;

	$('.map-contact').each(function() {
		var options = {
			draggable: isDraggable,
		    markers: [
		        {
		            address: $(this).data('address'),
		        }
		    ],
		    zoom: 15,
		    icon: {
				image: $(this).data('icon'), 
				iconsize: [50, 50],
				iconanchor: [12, 12]
			},

		}
		$(this).gMap(options);
	});
});

jQuery(function($) {
	function mapMatch() {
		var cfHeight 	= $('.astrid-contact-form').outerHeight();
		$('.map-contact').css('min-height', cfHeight + 90);
	}
	$(document).ready(mapMatch);
	$(window).on('resize',mapMatch);
});

jQuery(function($) {
	$( '.toggle-map' ).click(function() {
		$(this).parent().find('.astrid-contact-form, .map-contact-overlay').fadeToggle();
		$(this).toggleClass('map-toggled');
		$(this).find('.fa').toggleClass('fa-map-o fa-close');
	});	
});

jQuery(function($) {

	var elements   =	$('.timeline-area .t-event');
	var imgs = $(".timeline-area .t-event img")
	var count = imgs.length;

	imgs.load(function() {
	    count--;
	    if (!count) {
			var max = -1;
			elements.each(function() {

			    var h = $(this).outerHeight(); 
			    max = h > max ? h : max;
			});
			elements.css('float', 'left');
			elements.outerHeight(max);
			elements.filter(':odd').css('margin-top', max - 1);
	    }
	}).filter(function() { return this.complete; }).load();

});

jQuery(function($) {
	if ( $().owlCarousel ) {
		$(".ap-carousel").owlCarousel({
			navigation : false,
			pagination: true,
			responsive: true,
			items: 3,
			itemsDesktopSmall: [1400,3],
			itemsTablet:[970,2],
			itemsTabletSmall: [600,1],
			itemsMobile: [360,1],
			touchDrag: true,
			mouseDrag: true,
			autoHeight: false,
			autoPlay: false
		});
	}
});