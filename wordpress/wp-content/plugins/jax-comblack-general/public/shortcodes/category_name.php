<?php
add_shortcode(
    'category_name', function () {
      	$job_category = intval(get_query_var('job_category'));
        return getCategoryNameByID($job_category);
    });