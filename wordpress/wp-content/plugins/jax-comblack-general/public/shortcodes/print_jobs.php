<?php
add_shortcode(
    'print_jobs', function () {
        $array = apiRequest(
            'https://minisites.mida.co.il/services/MidaService.asmx/GetOrdersDetails',
            [
                'orderID' => ''
            ]
        );
        if (!$array) {
            return __('אירעה שגיאה', 'jax-comblack-general');
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