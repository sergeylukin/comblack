<?php
$string .= '<div class="cb-job-block">';
          	  $string .= '<div class="jax-accordion">';
          		$string .= '<div class="cb-job-block_item cb-job-block_title">'.$job['d'].'</div>';
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.getCategoryNameByID($job['order_def_prof1']).'</div>';
                $string .= '<div style="text-align: right;">תתי קטגוריות</div>';          		
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.getCategoryNameByID($job['order_def_subprof1']).'</div>';                    
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.getCategoryNameByID($job['order_def_subprof1']).'</div>';
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.getCategoryNameByID($job['order_def_prof2']).'</div>';
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.getCategoryNameByID($job['order_def_subprof2']).'</div>';
                $string .= '<div class="cb-job-block_item cb-job-block_category">'.$job['sub_proffesion_name'].'</div>';
                    $string .= '<div>';
                	$string .= '<div class="cb-job-block_item cb-job-block_desc">'.$job['n'].'</div>';
          			$string .= '<div><button class="cb-job-block_button">פרטי המשרה</button></div>';
          		$string .= '<div class="cb-job-block_item cb-job-block_area"><span>אזור: '.$job['area1'].'</span></div>';
                    $string .= '<div class="cd-job-block_form_wrapper cd-job-block_form_wrapper_'.$job['i'].'" data-job="'.$job['i'].'">';
            
          
          	    $string .= '<div class="cb-job-block_details jax-panel" onclick="event.stopPropagation();">';
                  
                    $string .= do_shortcode('[elementor-template id="843"]');
                    $string .= '</div>';
			$string .= '</div>';

            $string .= '<span class="cd-job-block_form__feedback_'.$job['i'].'"></span>';
          	    $string .= '</div>';

                  
          	  $string .= '</div>';
          	$string .= '</div>';