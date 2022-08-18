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
 
if($image && $image['url']) {
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
 <div id="catsallcareerid" class="catsallcareer catsallarea">
    <div class="wrapperin2">
	        <?php echo do_shortcode('[searchjobsformtest]') ?>
			 
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
				   $alldatareturn = ParentOrChildCategoryOfJob($id , 'noparent' , 'alldatareturn');
				   echo $alldatareturn ;
				   
				   ?>
				   </div> 
				   
                   				   
				   <h2><a href="<?php echo get_permalink($id) ; ?>" ><?php the_title()  ; ?></a></h2> 
					<div class="misratestrow2">
				   <?php if(!wp_is_mobile()) : ?>
					   <div class="tiurrow nomobile">
					       תיאור המשרה:
					   </div><!-- mz -->					   
				   <?php else :  ?>
				        <div class="tiurrow yesmobile">
						   <span class="tiurmoremob">
						   תיאור המשרה:
						   <?php echo do_shortcode("[av_font_icon icon='ue87f' font='entypo-fontello' style='' caption='' link='' linktarget='' size='19px' position='left' color='#569391' custom_class='' admin_preview_bg='' av_uid='av-6f14vz'][/av_font_icon]"); ?> 
						   </span> 
					       <a class="tuirreadmoremob" href="<?php echo get_permalink($id) ; ?>" ><span >קרא עוד</span></a>
					   </div><!-- mz -->				   
				   <?php endif ;  ?>
				   </div>  
				   <div class="misratestrow3 nomobile">
				   <?php 
				   $temp =  strip_tags(get_the_content()) ; 
				   echo mb_strimwidth($temp, 0, 400, "..."); ;
				   ?>
				   </div> 
				   <div class="misratestrow4"><a  class="nomobile" href="<?php echo get_permalink($id) ; ?>" ><span >קרא עוד</span></a></div>    
			</div> 
 
		  <?php endwhile ; 
	         endif; ?>
		   
		   
		   <div class="nav-previous alignleft"><?php previous_posts_link( 'משרות קודמות' ); ?></div>
		   <div class="nav-next alignright"><?php next_posts_link( 'משרות נוספות' ); ?></div>
		   
		   </div><!-- mz termconteinerri-->
           <div class="termconteinerle">
		   <?php  echo do_shortcode('[sidebarNew1]') ?>
		   
		   </div><!-- mz termconteinerle-->
		   
		   
    </div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
	
<style>
   
</style>



<?php 
		get_footer();
