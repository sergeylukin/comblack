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
});
  
function resetMessages() {
	document.querySelectorAll('.field-msg').forEach(f => f.classList.remove('show'));
}

function validateEmail(email) {
	let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}
