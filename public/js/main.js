document.addEventListener('DOMContentLoaded', function () {
	if (document.querySelector('.Swiper-guarantee .swiper-container')) {
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
	}

	document.addEventListener('click', function (e) {
		let jobReservationBtn = e.target.closest('.JobReservation_btn');

		if (!jobReservationBtn) return;

		jobReservationBtn.nextElementSibling.style.display = 'block';
		jobReservationBtn.style.display = 'none';

		// document.querySelector('.JobReservation_callOrderBtn').insertAdjacentHTML('beforebegin', `<div>Text</div>`);
		// console.log(document.querySelector('.JobReservation_callOrderBtn'));
		// document.querySelector('.JobReservation_callOrderBtn').insertAdjacentHTML('beforebegin', `<script data-b24-form="click/26/tq8hec" data-skip-moving="true">
  //       (function(w,d,u){
  //               var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
  //               var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
  //       })(window,document,'https://cdn.bitrix24.ua/b14740879/crm/form/loader_26.js');
		// </script>`);
		// console.log('Click!');
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
	console.log(tmplScript.content.cloneNode(true));

	document.querySelectorAll('.ContactBtn-call').forEach(btn => {
		btn.before(tmplScript.content.cloneNode(true));
	});

	setTimeout(function () {
		document.querySelectorAll('.ContactBtn-call, .JobReservation_callOrderBtn').forEach(function (btn) {
			btn.before(tmplScript.content.cloneNode(true));
		});
	}, 1300);
	
});