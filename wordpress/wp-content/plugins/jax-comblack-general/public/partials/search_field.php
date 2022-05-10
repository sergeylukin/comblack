<?php
add_shortcode('cb_search_field', function() {
  $string = '<form class="cb-search_form" action="/job-search" method="get">';
  $string .= '<input type="text" name="job_search" value="" />';
  $string .= '<button class="cb-search_form_button" type="submit">חיפוש</button>';
  $string .= '</form>';
  
  return $string;
});