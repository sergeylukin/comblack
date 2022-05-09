(function($){
$(window).load(function() {
	if($("#menuparams").length != 0) {
	     var param = $("#menuparams").text();
		 //alert(param);
		 
		 if(param == 'menuparamsabout') {
			 $('#avia-menu').children('li#menu-item-3594').addClass('mzcurrent');
		 }
		 if(param == 'menuparamsblog') {  
			 $('#avia-menu').children('li#menu-item-3221').addClass('mzcurrent');
		 }
		 
	}
	
	 
	
	
});
$(document).ready(function() {
 
	 
})	
$( window ).resize(function() {
           
	});

})(jQuery);
 