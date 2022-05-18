window.addEventListener("load", function() {

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}


const spans = document.querySelectorAll('.word span');

console.log(spans);
spans.forEach((span, idx) => {
	span.addEventListener('click', (e) => {
		e.target.classList.add('active');
	});
	span.addEventListener('animationend', (e) => {
		e.target.classList.remove('active');
	});
	
	// Initial animation
	setTimeout(() => {
		span.classList.add('active');
	}, 750 * (idx+1))
})

let selects = document.querySelectorAll('.js-taxonomy-selector')
console.log(selects)
	selects.forEach(
		function(el){
			console.log(el);
		let url = el.dataset.url;
			el.addEventListener('change', (e) => {
				console.log('changed to ' + e.target.value)
			let body = {
				taxonomy: el.dataset.taxonomy,
				careerist_id: el.dataset.careerist_id,
				id: e.target.value,
				action: el.dataset.action,
				nonce: el.dataset.nonce,
			}
		let params = new URLSearchParams(body);
			console.log(params);
				fetch(url, {
					method: "POST",
					body: params,
				}).then(res => res.json())
					.then(response => {
						console.log(response);
					})
			})
		}
	);






});




/* Sync btn */
document.addEventListener('DOMContentLoaded', function(e) {
	let testimonialForm = document.getElementById('careerist-sync-trigger-form');

	testimonialForm.addEventListener('submit', (e) => {
		e.preventDefault();

		// reset the form messages
		resetMessages();

		// collect all the data
		let data = {
			nonce: testimonialForm.querySelector('[name="nonce"]').value
		}
		
		// validate everything
		// ajax http post request
		let url = testimonialForm.dataset.url;
		let params = new URLSearchParams(new FormData(testimonialForm));

		testimonialForm.querySelector('.js-form-submission').classList.add('show');

		fetch(url, {
			method: "POST",
			body: params
		}).then(res => res.json())
			.catch(error => {
				resetMessages();
				testimonialForm.querySelector('.js-form-error').classList.add('show');
			})
			.then(response => {
				resetMessages();
				
				if (response === 0 || response.status === 'error') {
					testimonialForm.querySelector('.js-form-error').classList.add('show');
					return;
				}

				testimonialForm.querySelector('.js-form-success').classList.add('show');
				testimonialForm.reset();
			})
	});



//wp_ajax_careerist_wire_taxonomy
});
  
function resetMessages() {
	document.querySelectorAll('.field-msg').forEach(f => f.classList.remove('show'));
}

function validateEmail(email) {
	let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}




jQuery(document).ready( function () {
	    jQuery('#myTable').DataTable();
} );
