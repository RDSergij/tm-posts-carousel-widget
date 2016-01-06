jQuery( document ).ready( function() {

	// Slider init
	window.swiper_carousel = new window.Swiper( '.tm-post-carousel-widget', {
		pagination: '.tm-post-carousel-widget .swiper-pagination',
		slidesPerView: window.TMWidgetParam.slidesPerView,
		paginationClickable: true,
		spaceBetween: 30,
		direction: 'horizontal',
		speed: 2500,
		autoplay: 2500
	} );
});
