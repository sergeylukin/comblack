(($) => {
    $(document).ready( function() {
        assignFormsToJobs($);
        changeHiddenInputOfJobInEveryFormToMatchJobID($);
    });
})(jQuery)

function assignFormsToJobs($) {
    let currentJobID;
    /*
        Assigns the class cd-job-block_form_'+currentJobID to each form
    */
    $('.cd-job-block_form_wrapper').each(function() {
        currentJobID = $(this).attr('data-job');
        $('.elementor-form', this).addClass('cd-job-block_form_'+currentJobID);
    });
}

function changeHiddenInputOfJobInEveryFormToMatchJobID($) {
    let currentJobID;
    /*
        Changes the value of the hidden input of the name job_id
        (which Elementor adds the class of elementor-field-group-job_id to)
        to the value of the current job
    */
    $('.cd-job-block_form_wrapper').each(function() {
        currentJobID = $(this).attr('data-job');

        elem = '';
        elem += '<div class="elementor-field-type-hidden elementor-field-group elementor-column elementor-field-group-test elementor-col-100">';
        elem += '<input size="1" type="hidden" name="form_fields[job_id]" id="form-field-job_id" class="elementor-field elementor-size-sm  elementor-field-textual" value="'+currentJobID+'" aria-invalid="false">';
        elem += '</div>';
        $('.elementor-form .elementor-field-group-job_id input', this).val(currentJobID);
      	console.log($(this).find('input[name="form_fields[job_id]"]'));
    });
}