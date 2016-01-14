jQuery( document ).ready( function() {

	// Slider init
	window.swiper_carousel = new window.Swiper( '.tm-post-carousel-widget', {
		nextButton: '.tm-post-carousel-widget .swiper-button-next',
		prevButton: '.tm-post-carousel-widget .swiper-button-prev',
		slidesPerView: window.TMWidgetParam.slidesPerView,
		paginationClickable: true,
		spaceBetween: 30,
		direction: 'horizontal',
		speed: 1500,
		autoplay: 2000
	} );
});
