document.addEventListener('DOMContentLoaded', function () {
	if (document.querySelector('.Swiper-guarantee .swiper-container')) {
		const swiperGuarantee = new Swiper('.Swiper-guarantee .swiper-container', {
		  loop: true,
		  // slidesPerView: 3,
		  // spaceBetween: 10,
		  slidesPerView: 1,
		  spaceBetween: 10,
		  grabCursor: true,

		  navigation: {
		    nextEl: '.Swiper-guarantee .swiper-button-next',
		    prevEl: '.Swiper-guarantee .swiper-button-prev',
		  },

		  breakpoints: {
		    640: {
		      slidesPerView: 2
		    },
		    840: {
		      slidesPerView: 3
		    }
		  }
		});
	}

	document.addEventListener('click', function (e) {
		let jobReservationBtn = e.target.closest('.JobReservation_btn');

		if (!jobReservationBtn) return;

		jobReservationBtn.nextElementSibling.style.display = 'block';
		jobReservationBtn.style.display = 'none';
	});

	document.addEventListener('click', function (e) {
		let jobReservationCloseBtn = e.target.closest('.JobReservation_closeBtn');

		if (!jobReservationCloseBtn) return;

		let jobReservation = jobReservationCloseBtn.closest('.JobReservation');

		if (!jobReservation) return;

		jobReservation.querySelector('.JobReservation_btn').style.cssText = '';
		jobReservation.querySelector('.JobReservation_detailed').style.cssText = '';
	});
	
	let tmplScript = document.getElementById('tmpl-script');

	document.querySelectorAll('.ContactBtn-call').forEach(btn => {
		btn.before(tmplScript.content.cloneNode(true));
	});

	setTimeout(function () {
		document.querySelectorAll('.JobReservation_callOrderBtn').forEach(function (btn) {
			btn.before(tmplScript.content.cloneNode(true));
		});
	}, 1300);
	
});