jQuery(document).ready( function() {

  jQuery(".cd-job-block_form__submit").click( function(e) {
     e.preventDefault(); 
     job = jQuery(this).attr("data-job")
     email_field = '.cd-job-block_form__email_'+job;
     email = jQuery(email_field).val()
     jQuery.ajax({
        type : "post",
        dataType : "json",
        url : myAjax.ajaxurl,
        data : {
          action: "cb_user_apply",
          job : job,
          email: email
        },
        success: function(response) {
            if (response.success) {
              jQuery(".cd-job-block_form__feedback_"+job).html('בקשתך נשלחה בהצלחה!')
            } else {
              alert('אירעה שגיאה');
            }
        },
        error: function(response) {
          alert('אירעה שגיאה');
        }
     })   

  })

})