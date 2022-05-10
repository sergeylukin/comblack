<?php
add_shortcode(
    'job_categories', function () {
        $array = getJobCategoriesFromAPI();
        if (!$array) {
            return __('אירעה שגיאה', 'jax-comblack-general');
        }

        $string = '<div class="cd-category-block-area">';
        foreach ($array['p'] as $cat_raw) {
            $cat = $cat_raw['@attributes'];
            $url = site_url().'/'.CATEGORIES_PAGE_SLUG.'/?job_category='.$cat['i'];
            $string .= '<div class="cd-category-block">';
            $string .= '<div class="cb-category-block_item cb-category-block_title">';
                $string .= '<a href="'.$url.'">'.$cat['n'].'</a>';
            $string .= '</div>';
            $string .= '</div>';
        }
        $string .= '</div>';

        return $string;
    }
);