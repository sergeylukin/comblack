<?php
function cb_add_query_vars_search_filter( $vars ){
    /*
     * Adds the ability for wordpress to get
     * the job category
     */

    $vars[] = "job_search";
    return $vars;
}
  
add_filter( 'query_vars', 'cb_add_query_vars_search_filter' );

add_shortcode(
    'print_jobs_by_search', function () {
        $job_search = sanitize_text_field(get_query_var('job_search'));
        if (empty($job_search)) {
          return __('לא נמצאו משרות המתאימות לחיפוש.', 'jax-comblack-general');
        }
        $array = apiRequest(
            'https://minisites.mida.co.il/services/MidaService.asmx/GetOrdersDetails',
            [
                'orderID' => ''
            ]
        );
        if (!$array) {
            return __('אירעה שגיאה', 'jax-comblack-general');
        }

        foreach ($array['o'] as $key => $job_raw) {
            if (!stristr($job_raw['@attributes']['d'], $job_search)) {
                unset($array['o'][$key]);
            }
        }
      
      	if (empty($array['o'])) {
            return __('לא נמצאו משרות המתאימות לחיפוש.', 'jax-comblack-general');
        }

        $string = '<div class="cb-job-block-area">';
        foreach ($array['o'] as $job_raw) {
            $job = $job_raw['@attributes'];
          	require BASE_PLUGIN_DIR.'/public/partials/job_block.php';
        }
        $string .= '</div>';

        return $string;
    }
);