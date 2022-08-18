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
           <div class="termconteinerri" style="width:100%;"> 
		    
		    <?php if( have_posts() ) :
	          while( have_posts() ) : the_post();
                   $id = get_the_ID();
			    
			  ?> 
			  <div class="alldatareturnsingle misratestrow1">
			  <?php   
				   $alldatareturn = ParentOrChildCategoryOfJob($id , 'noparent' , 'alldatareturn');
					 $adam_id = class_exists('Database') ? Database::getAdamIdByJobId($id) : 0;
					// echo $adam_id ;
					 //echo '<br>';
				   echo $alldatareturn ;
			   ?>
			   </div><!-- mz alldatareturnsingle-->
			   
		       <h1><a href="<?php echo get_permalink($id) ; ?>" ><?php the_title()  ; ?></a></h1> 
               <div class="singlepostinall">
			          <div class="singlepostinri">
					      <?php  echo wpautop(get_the_content($id)  ) ; ?>
					  </div><!-- mz singlepostinri-->
			          <div class="singlepostinle">
					       <h2>שלח קורות חיים</h2>
					       <?php echo do_shortcode('[crmformNew]') ?>
					  </div><!-- mz singlepostinle-->
			   </div><!-- mz singlepostinall-->
 
		  <?php endwhile ; 
	         endif; ?>
		   <div class="relativesinglejobs">
				<h2>משרות נוספות:</h2>
		        <div class="relativesinglejobsin">
				 <?php 
					  $postid = get_the_ID();
					  echo relativejobs_func($postid) ;
				 ?>
				
				</div><!-- mz relativesinglejobsin-->
		   </div><!-- mz relativesinglejobs-->
		    
		   
		   </div><!-- mz termconteinerri-->
		   <?php if(!wp_is_mobile() && false ) :  ?>
			   <div class="termconteinerle">
					<?php echo do_shortcode('[sidebarNew1]') ?>
			   </div><!-- mz termconteinerle-->
		   <?php endif ; ?>

    </div><!-- mz wrapperin1-->
</div><!-- mz catsallcareer-->
 
<?php 
		get_footer();
