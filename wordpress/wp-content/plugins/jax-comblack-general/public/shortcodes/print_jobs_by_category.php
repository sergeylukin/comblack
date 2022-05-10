<?php
function cb_add_query_vars_filter( $vars ){
    /*
     * Adds the ability for wordpress to get
     * the job category
     */

    $vars[] = "job_category";
    return $vars;
}
  
add_filter( 'query_vars', 'cb_add_query_vars_filter' );
require_once BASE_PLUGIN_DIR.'/public/shortcodes/category_name.php';

add_shortcode(
    'print_jobs_by_category', function () {
        $job_category = intval(get_query_var('job_category'));
        if(empty($job_category)) {
            return __('עשית משהו לא נכון.', 'jax-comblack-general');
        }

        $array = apiRequest(
            'https://minisites.mida.co.il/services/MidaService.asmx/GetOrdersList',
            [
                // profID=4&profSpec=&areasID=&freeText=&orderType=&branch=&rakaz=&isHot=
                'profID' => $job_category,
                'profSpec' => '',
                'areasID' => '',
                'freeText' => '',
                'orderType' => '',
                'branch' => '',
                'rakaz' => '',
                'isHot' => ''
            ]
        );
        if (!$array) {
            return __('לא נמצאו משרות בהתאם לפרמטרים.', 'jax-comblack-general');
        }

        $jobIDs = [];
        foreach ($array['o'] as $job_raw) {
            /**
             * Returns only ID and name
             */

            if (isset($job_raw['@attributes'])) {
                /**
                 * Appearently sometimes '@attributes' is there and sometimes it isn't...
                 */
                $job = $job_raw['@attributes'];
            } else {
                $job = $job_raw;
            }
            $jobIDs[] = $job['i'];
        }
    
        $string = '<div class="cd-job-block-area">';
        foreach ($jobIDs as $jobID) {
            $job_raw = apiRequest(
                'https://minisites.mida.co.il/services/MidaService.asmx/GetOrdersDetails',
                [
                    'orderID' => $jobID
                ]
            );
            if (!$job_raw) {
                return __('אירעה שגיאה', 'jax-comblack-general');
            }
          
            $job = $job_raw['o']['@attributes'];
          	require BASE_PLUGIN_DIR.'/public/partials/job_block.php';
        }
        $string .= '</div>';

        return $string;
    }
);