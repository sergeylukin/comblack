<?php
    $output = '';

    $term = get_queried_object();
    if(get_field('list_type', $term) == 'Chapters') {
        $pageclass = 'chapters-page';
    } else {
        $pageclass = '';
    }

    $output .= '<div class="date-container '.$pageclass.'"><div class="col"><span class="date_icon"></span><span class="date">עולם העבודה | <span>'.wp_date('F j, Y').'</span></span></div></div>';
    
    $image = get_field('inner_category_image', $term);
    if( !empty( $image ) ):
        $output .= '<img class="category-image" src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" />';
    endif; 

    
         

    $cats = get_terms([
        'taxonomy'   => 'books',
        'hide_empty' => false,
        'parent' => get_queried_object_id(),
        'orderby' => 'term_id',
    ]);
   

    if( have_rows('articles', $term) && get_field('list_type', $term) == 'Articles' ) {
        $output .= '<div class="content-container">';
        $output .= '<h2 class="cat_title">תוכן הענינים</h2>';
        $output .= '<ul class="post-list">';

        while( have_rows('articles', $term) ) : the_row();

                $featured_post = get_sub_field('article');
                if( $featured_post ):
                    $output .= '<li><a target="_blank" href="'.esc_html( get_permalink( $featured_post->ID ) ).'">'.esc_html( $featured_post->post_title ).'</a></li>';
                endif;

        endwhile;
        $output .= '</ul></div>';
    } else if(have_rows('links', $term) && get_field('list_type', $term) == 'External links') {
        $output .= '<div class="content-container">';

        while( have_rows('links', $term) ) : the_row();
                $title = get_sub_field('title');
                $link = get_sub_field('link');
                if($title && $link):
                    $output .= '<h2 class="cat_title link"><a target="_blank" href="'.$link.'">'.$title.'</a></h2>';
                endif;

        endwhile;
        $output .= '</div>';
    } else if(have_rows('links_to_articles', $term) && get_field('list_type', $term) == 'Links to articles') {
        $output .= '<div class="content-container">';
        $output .= '<h2 class="cat_title">'.$term->name.'</h2>';
        $output .= '<ul class="post-list">';
            while( have_rows('links_to_articles', $term) ) : the_row();
                    $title = get_sub_field('title');
                    $link = get_sub_field('link');
                    if($title && $link):
                        $output .= '<li><a href="'.$link.'">'.$title.'</a></li>';
                    endif;

            endwhile;
        $output .= '</ul>';
        $output .= '</div>';
    
    } else if($term->term_id == 121) {
        $output .= '<div class="content-container">';
        $output .= '<h2 class="cat_title">תוכן הענינים</h2>';
            $args = array(
                'post_type' => 'article',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC', //ASC DESC
                'tax_query' => array(
                array(
                    'taxonomy' => 'books',
                    'field' => 'slug',
                    'terms' => $term->slug
                )
                )
            );
        
            $partnersList = new WP_Query( $args );
        
            if($partnersList->have_posts()) {
                $output .= '<ul class="post-list">';
        
                while($partnersList->have_posts()) {
                $partnersList->the_post();
    
                $output .= '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
    
                }
        
                $output .= '</ul>';
            } else {
                //no posts found
            }
        
            wp_reset_postdata();
    

        $output .= '</div>';
        
    } else if($cats){
        $output .= '<div class="content-container '.$pageclass.'">';
   
            foreach ($cats as $cat) :
                $output .= '<h2 class="cat_title"><a href="'.get_term_link($cat->term_id, 'books').'">'.$cat->name.'</a></h2>';
            
                $args = array(
                    'post_type' => 'article',
                    'post_status' => 'publish',
                    // 'orderby' => 'date',
                    'tax_query' => array(
                    array(
                        'taxonomy' => 'books',
                        'field' => 'name',
                        'terms' => $cat->name
                    )
                    )
                );
            
                //the query
                $partnersList = new WP_Query( $args );
            
                //loop through query
                if($partnersList->have_posts()) {
                    $output .= '<ul class="post-list">';
            
                    while($partnersList->have_posts()) {
                    $partnersList->the_post();
                    
            
                    $output .= '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
            
                    
                    }
            
                    $output .= '</ul>';
                } else {
                    //no posts found
                }
            
                wp_reset_postdata();
            endforeach;
        // }
        
        $articles = array(
            'post_type' => 'article',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'books',
                    'include_children' => false,
                    'field' => 'name',
                    'terms' => $term->name
                )
            )
        );
        $articlesList = new WP_Query( $articles );
        if($articlesList->have_posts()) {
            $output .= '<h2 class="cat_title">נושאים נוספים</h2>';
            $output .= '<ul class="post-list">';
                while($articlesList->have_posts()) {
                    $articlesList->the_post();
                    $output .= '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                }
            $output .= '</ul>';
        }

        $output .= '</div>';
    } else {
        $output .= '<div class="content-container">';
        $output .= '<p>No Info</p>';
        $output .= '</div>';
    }
    echo $output;
?>