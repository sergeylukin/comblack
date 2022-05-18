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
	selects.forEach(
		function(el){
		let url = el.dataset.url;
			el.addEventListener('change', (e) => {
			let body = {
				taxonomy: el.dataset.taxonomy,
				careerist_id: el.dataset.careerist_id,
				id: e.target.value,
				action: el.dataset.action,
				nonce: el.dataset.nonce,
			}
		let params = new URLSearchParams(body);
				fetch(url, {
					method: "POST",
					body: params,
				}).then(res => res.json())
					.then(response => {
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




	function format(d) {
		// `d` is the original data object for the row
		var str = ''
		str += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
		for (var attr in d) {
			if (attr.slice(0, 4) == 'adam') {
				str += '<tr>' +
				'<td>'+attr.replace('adam_', '')+':</td>' +
				'<td>' +
				d[attr] +
				'</td>' +
				'</tr>'
			}
		}
		str += '</table>'
		return str
		
	}
// function format (name, value) {
// 	    return '<div>Name: ' + name + '<br />Value: ' + value + '</div>';
// }
document.addEventListener("DOMContentLoaded", function() {
	/* Formatting function for row details - modify as you need */

	var jobsTable = document.getElementById('myTable')
	let table = new DataTable('#myTable', {
			ajax: jobsTable.dataset.fetchUrl,
			// scrollY:        200,
			// deferRender:    true,
			// scroller:       true,
			columns: [
				{
					className: 'dt-control',
					orderable: false,
					data: null,
					defaultContent: '',
				},
				{ data: 'adam_id' },
				{ data: 'name' },
				{ data: 'category' },
				{ data: 'subcategory' },
				{ data: 'post' },
			],
			order: [[1, 'desc']],
			"initComplete": function(settings, json) {
				let togglers = document.querySelectorAll('#myTable td.dt-control')
				for (let i = 0; i < togglers.length; i++) {
					togglers[i].addEventListener('click', function (evt) {
						var tr = evt.target.parentNode;
						var row = table.row(tr);

						// row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
						if (row.child.isShown()) {
							// This row is already open - close it
							row.child.hide();
							tr.classList.remove('shown');
						} else {
							// Open this row
							row.child(format(row.data())).show();
							tr.classList.add('shown');
						}
					});
				}
			},
		});

		// Add event listener for opening and closing details

} );
