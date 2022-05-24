<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();

?>	
<?php  include('help-filter-categories-jobsingle.php');  ?> 

<div class="singlepostwrapall wrapperallmain">
    <div class="wrapperin2">
           <div class="termconteinerri"> 
		    
		    <?php if( have_posts() ) :
	          while( have_posts() ) : the_post();
                   $id = get_the_ID();
			    
			  ?> 
			  <div class="alldatareturnsingle misratestrow1">
			  <?php   
				   $alldatareturn = ParentOrChildCategoryOfJob($id , 'noparent' , 'alldatareturn');
					 $adam_id = Database::getAdamIdByJobId($id);
				   echo $alldatareturn ;
			   ?>
			   </div><!-- mz alldatareturnsingle-->
			   
		       <h1><a href="<?php echo get_permalink($id) ; ?>" ><?php the_title()  ; ?></a></h1> 
               <?php //echo nl2br(get_the_content() , false) ; ?>
               <?php  echo wpautop(get_the_content($id)  ) ; ?>
               <?php  //the_content($id)   ; ?>
			  
		  <?php endwhile ; 
	         endif; ?>
		   
		    
		   
		   </div><!-- mz termconteinerri-->
           <div class="termconteinerle">
		   <?php echo do_shortcode('[sidebarNew1]') ?>
		   
		   </div><!-- mz termconteinerle-->
		   
		   
    </div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
 
<?php 
		get_footer();
