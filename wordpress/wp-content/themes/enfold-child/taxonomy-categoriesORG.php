<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();
$taxonomyacf = get_queried_object();
//var_dump($taxonomyacf);
$taxonomy = get_queried_object();
$currenttermid = get_queried_object()->term_id;
 
 
$image = get_field('topimage', $taxonomyacf);	
 
if($image['url']) {
	$topsectioncareerstyle = 'style = "background-image: url('.$image["url"].') !important;"';
} else {
	$topsectioncareerstyle = "";
}
?>	
 <div class="topsectioncareer 1" <?php echo  $topsectioncareerstyle ; ?>>
    <div class="wrapperin1">
	       <h1>
		    <?php $taxonomy = get_queried_object();
            echo  $taxonomy->name;?>
		   </h1>
	</div><!-- mz wrapperin1-->
</div><!-- mz topsectioncareer-->
 <div id="catsallcareerid" class="catsallcareer">
    <div class="wrapperin2">
	        <ul class="catscareerallmenu">
	        <?php 
			$mobileoptions = '';
			// get a list of available taxonomies for a post type
			$args = [
				'taxonomy'     => 'careers',
				'parent'        => 0,
				'number'        => 1000,
				'hide_empty'    => false           
			];
			$taxonomies = get_taxonomies(['object_type' => ['careers']]);

			$taxonomy = 'categories' ;
			// loop over your taxonomies
			 
			$termsparentall    = get_terms(['taxonomy' => $taxonomy , 'parent' => 0, 'hide_empty' => false]);
			
           foreach($termsparentall as $t){
			    //echo  $t->term_id  . ' ' . $t->name . '<br>' ;
				$term = get_term($t);
				$termacf = get_term($t->term_id); //Example term ID
			    if($currenttermid == $t->term_id) {
					$classactive = 'classactive1';
					$attrparentid = 'parentis="'.$t->term_id.'"';
					$isselected = ' selected';
				} else {
					$classactive = '';
					$attrparentid = 'parentis="'.$t->term_id.'"';
					$isselected = '';
				}
				$title2rows =  get_field('toptitle2rows', 'term_' . $t->term_id);	
				if($title2rows) {
					$titleonmenu = $title2rows ; 
				} else {
					$titleonmenu = $term->name ; 
				}
				echo '<li '.$attrparentid.' class="'.$classactive.'"><a href="'. get_term_link($t->term_id) .'">' . $titleonmenu   .'</a></li>';
				$mobileoptions .= '<option  ' .$isselected.' value="'.$t->term_id.'" linkattr="'.get_term_link($t->term_id).'" >'.$term->name.'</options>'; 
		    }
		   
		  
			?>
			</ul>
			<div id="mobileonlyselectid" class="mobileonlyselect">
			    <div class="mobileonlyselectlabel">תחום:</div> 
				<select class="mobileonlyselectclss">
					  <?php echo $mobileoptions ; ?>
				</select>
			</div><!-- mz mobileonlyselect-->
	</div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
 <div class="subcatsallcareer">
    <div class="wrapperin2">
	     <ul class="subcatsallcareermenu">
            <?php 
			$mobileoptions2 = '';
			$taxonomy = 'categories' ;
			$termchilds = get_term_children(  $currenttermid ,   $taxonomy )	;	
	         if(empty($termchilds)) {
				 $termparent = get_term($currenttermid , $taxonomy);
				 $termParent = ($termparent->parent == 0) ? $currenttermid :  $termparent->parent ;
				 //var_dump($termParent) ;
				 $termchilds = get_term_children(  $termParent ,   $taxonomy )	;
			 } else {
				 $termParent =   $currenttermid  ;
			 }
		    if(!empty($termchilds)) {
					foreach($termchilds as $tid){
								//echo  $t->term_id  . ' ' . $t->name . '<br>' ;
								$term = get_term($tid); //Example term ID
								if($currenttermid == $tid) {
									$classactive = 'classactive1';
									$attrparentid = 'parent-id="'.$termParent.'"';
									$isselected = ' selected';
								} else {
									$classactive = '';
									$attrparentid = '';
									$isselected = '';
								}
								echo '<li '.$attrparentid.' class="'.$classactive.'"><a href="'. get_term_link($tid) .'">' . get_term( $tid  )->name   .'</a></li>';
							 
					          $mobileoptions2  .= '<option '.$attrparentid.' '.$isselected.' value="" linkattr="'.get_term_link($tid).'" >'.get_term( $tid  )->name.'</options>'; 
					}	
					$alljobsoptionsubslink =  get_term_link($termParent)  ;
					//echo 'sssssssssssssssss';
					//var_dump($alljobsoptionsubslink);
			} 
		   
		   
			?>
          </ul>
		  <div  id="mobileonlyselectid2"  class="mobileonlyselect2">
			    <div class="mobileonlyselectlabel">מקצוע: </div> 
				<select class="mobileonlyselectclss">
					  <?php 
						 $alljobsoption = '<option   value="" linkattr="'.$alljobsoptionsubslink.' " > כל המקצועות</options>' ;
					  echo $alljobsoption.$mobileoptions2 ; ?>
				</select>
			</div><!-- mz mobileonlyselect-->
	</div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
<div class="termconteinerall1 wrapperallmain">
    <div class="wrapperin2">
           <h2>
		   <?php $taxonomy = get_queried_object();
            echo  'משרות דרושים '.$taxonomy->name;?>
		   </h2>       
		   <div class="termconteinerall1in">
		          <?php 
				  echo  term_description( $currenttermid ) ;
				     ?>
		   </div> 
    </div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->

<div class="termconteinerall2 wrapperallmain">
    <div class="wrapperin2">
           <div class="termconteinerri"> 
		   <p style="text-align: right;"><span style="font-size: 14pt;"><strong> 
						<?php  echo 'נמצאו '. $wp_query->found_posts.' משרות:'; ?>
						</strong></span></p>
		    <?php if( have_posts() ) :
	          while( have_posts() ) : the_post();
               $id = get_the_ID();
			    
			  ?> 
		  
 
			  	<div class="misratestall">
				   <div class="misratestrow1"><?php 
				   $areas = get_the_terms( $id , array('area' , 'categories' ) );
				   foreach($areas as $a) {
					   $termid = $a->term_id;
					   echo '<a href="'.get_term_link($termid).'">#'.$a->name.'</a>';
					   echo ' ';
					  // echo '<br>';
				   }
				  // var_dump($areas); 
				   
				   ?>
				   </div> 	    
				   <h2><a href="<?php echo get_permalink($id) ; ?>" ><?php the_title()  ; ?></a></h2> 
				   <div class="misratestrow2">תיאור המשרה:</div>  
				   <div class="misratestrow3">
				   <?php 
				   $temp =  strip_tags(get_the_content()) ; 
				   echo mb_strimwidth($temp, 0, 400, "..."); ;
				   ?>
				   </div> 
				   <div class="misratestrow4"><a href="<?php echo get_permalink($id) ; ?>" ><span >קרא עוד</span></a></div>    
			</div> 
 
		  <?php endwhile ; 
	         endif; ?>
		   
		   
		   <div class="nav-previous alignleft"><?php previous_posts_link( 'משרות קודמות' ); ?></div>
		   <div class="nav-next alignright"><?php next_posts_link( 'משרות נוספות' ); ?></div>
		   
		   </div><!-- mz termconteinerri-->
           <div class="termconteinerle">
		   <?php echo do_shortcode('[sidebarNew1]') ?>
		   
		   </div><!-- mz termconteinerle-->
		   
		   
    </div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
	
<style>
   
</style>



<?php 
		get_footer();
