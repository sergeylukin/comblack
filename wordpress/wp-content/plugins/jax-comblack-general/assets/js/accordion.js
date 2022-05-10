/*window.onload = function(){
	var acc = document.getElementsByClassName("jax-accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
	    this.classList.toggle("jax-active");
	    // var panel = this.nextElementSibling;
        var panel_raw = this.getElementsByClassName('jax-panel');
        var panel = panel_raw[0];
	    if (panel.style.maxHeight) {
	      panel.style.maxHeight = null;
	    } else {
	      panel.style.maxHeight = panel.scrollHeight + "px";
	    } 
	  });
	}
}
*/
window.onload = function(){
	var acc = document.getElementsByClassName("jax-accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
        this.classList.toggle("jax-active");
	    if (this.style.maxHeight) {
	      this.style.maxHeight = null;
	    } else {
	      this.style.maxHeight = this.scrollHeight + "px";
	    } 
	  });
	}
}