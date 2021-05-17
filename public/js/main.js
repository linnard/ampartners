document.addEventListener('DOMContentLoaded', function () {
	const swiperGuarantee = new Swiper('.Swiper-guarantee .swiper-container', {
	  loop: true,
	  slidesPerView: 3,
	  spaceBetween: 10,
	  grabCursor: true,

	  navigation: {
	    nextEl: '.Swiper-guarantee .swiper-button-next',
	    prevEl: '.Swiper-guarantee .swiper-button-prev',
	  }
	});
});