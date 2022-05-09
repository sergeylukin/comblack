		<?php
			
		do_action( 'ava_before_footer' );	
			
		global $avia_config;
		$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

		//reset wordpress query in case we modified it
		wp_reset_query();


		//get footer display settings
		$the_id 				= avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
		$footer 				= get_post_meta($the_id, 'footer', true);
		$footer_widget_setting 	= !empty($footer) ? $footer : avia_get_option('display_widgets_socket');


		//check if we should display a footer
		if(!$blank && $footer_widget_setting != 'nofooterarea' )
		{
			if( $footer_widget_setting != 'nofooterwidgets' )
			{
				//get columns
				$columns = avia_get_option('footer_columns');
		?>
				<div class='container_wrap footer_color' id='footer'>

					<div class='container'>

						<?php
						do_action('avia_before_footer_columns');

						//create the footer columns by iterating

						
				        switch($columns)
				        {
				        	case 1: $class = ''; break;
				        	case 2: $class = 'av_one_half'; break;
				        	case 3: $class = 'av_one_third'; break;
				        	case 4: $class = 'av_one_fourth'; break;
				        	case 5: $class = 'av_one_fifth'; break;
				        	case 6: $class = 'av_one_sixth'; break;
				        }
				        
				        $firstCol = "first el_before_{$class}";

						//display the footer widget that was defined at appearenace->widgets in the wordpress backend
						//if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
						for ($i = 1; $i <= $columns; $i++)
						{
							$class2 = ""; // initialized to avoid php notices
							if($i != 1) $class2 = " el_after_{$class}  el_before_{$class}";
							echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
							if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - column'.$i) ) : else : avia_dummy_widget($i); endif;
							echo "</div>";
							$firstCol = "";
						}

						do_action('avia_after_footer_columns');

						?>


					</div>


				<!-- ####### END FOOTER CONTAINER ####### -->
				</div>

	<?php   } //endif nofooterwidgets ?>



			

			<?php

			//copyright
			$copyright = do_shortcode( avia_get_option('copyright', "&copy; ".__('Copyright','avia_framework')."  - <a href='".home_url('/')."'>".get_bloginfo('name')."</a>") );

			// you can filter and remove the backlink with an add_filter function
			// from your themes (or child themes) functions.php file if you dont want to edit this file
			// you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
			// you can also just keep that link. I really do appreciate it ;)
			$kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN."_initial_version"), 'Enfold');


			
			if($copyright && strpos($copyright, '[nolink]') !== false)
			{
				$kriesi_at_backlink = "";
				$copyright = str_replace("[nolink]","",$copyright);
			}

			if( $footer_widget_setting != 'nosocket' )
			{

			?>

				<footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
                    <div class='container'>

                        <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>

                        <?php
                        	if(avia_get_option('footer_social', 'disabled') != "disabled")
                            {
                            	$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
								echo avia_social_media_icons($social_args, false);
                            }
                        
                            
                                $avia_theme_location = 'avia3';
                                $avia_menu_class = $avia_theme_location . '-menu';

                                $args = array(
                                    'theme_location'=>$avia_theme_location,
                                    'menu_id' =>$avia_menu_class,
                                    'container_class' =>$avia_menu_class,
                                    'fallback_cb' => '',
                                    'depth'=>1,
                                    'echo' => false,
                                    'walker' => new avia_responsive_mega_menu(array('megamenu'=>'disabled'))
                                );

                            $menu = wp_nav_menu($args);
                            
                            if($menu){ 
                            echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
                            echo $menu;
                            echo "</nav>";
							}
                        ?>

                    </div>

	            <!-- ####### END SOCKET CONTAINER ####### -->
				</footer>


			<?php
			} //end nosocket check


		
		
		} //end blank & nofooterarea check
		?>
		<!-- end main -->
		</div>
		
		<?php
		
		if(avia_get_option('disable_post_nav') != "disable_post_nav")
		{
			//display link to previous and next portfolio entry
			echo avia_post_nav();
		}
		
		echo "<!-- end wrap_all --></div>";


		if(isset($avia_config['fullscreen_image']))
		{ ?>
			<!--[if lte IE 8]>
			<style type="text/css">
			.bg_container {
			-ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
			}
			</style>
			<![endif]-->
		<?php
			echo "<div class='bg_container' style='background-image:url(".$avia_config['fullscreen_image'].");'></div>";
		}
	?>


<?php




	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */


	wp_footer();


?>
<?php if(!is_page(3442) || true ) : ?>
<div class="side-tabs-wrp">
 <?php
     $mainlabel = 'שלח  קו"ח';   
	 $titleinside = 'שלח  קו"ח';
	 $subtitleinside =  'ותתחיל לקבל הצעות עבודה בדיסקרטיות';
 
?>
	<div> 
	<?php //echo do_shortcode("[av_font_icon icon='ue84b' font='entypo-fontello' style='' caption='' link='' linktarget='' size='30px' position='center' color='#fff' custom_class='' admin_preview_bg='' av_uid='av-6f14vz'][/av_font_icon]"); ?>
	 
	<?php echo $mainlabel ; ?>	 
	</div>
</div>
<div class="side-form hideMe">
	<span class="close-form">X</span>
	<div role="form" class="wpcf7"  lang="he-IL" dir="rtl">
	  <div class="iconnelet">
	 
	  </div>
	  <p class="stickytitleblue" style=" ">
	  <span><?php   echo $titleinside ; ?>	</span> 
	  <?php echo $subtitleinside ; ?>	
	   </p>	
      <form> 
       <input type="text" placeholder="שם מלא">
       <input type="text" placeholder="אימייל">
       <input type="file" placeholder='בחר קובץ קו"ח'>
       <input type="submit" placeholder="שלח" value="שלח">
	   
      </form>	  
 
 </div>
 </div>
 
 <script type="text/javascript">
(function ($) {
	$(document).ready(function () {
	$('.side-tabs-wrp  ').removeClass('hideMe');
		$('.side-tabs-wrp > div, #botnewsletter, .side-form > span.close-form').click(function() {
			if($('.side-tabs-wrp, .mobile-contact-tab').hasClass('hideMe')){
				$('.side-tabs-wrp, .mobile-contact-tab').removeClass('hideMe');
				$('.side-form').addClass('hideMe');
			}else{
				$('.side-tabs-wrp, .mobile-contact-tab').addClass('hideMe');
				$('.side-form').removeClass('hideMe');
			}
		});          
	});
	//
	var parentid = $('.subcatsallcareermenu .classactive1').attr('parent-id');
	//console.log( parentid);
	$('.catscareerallmenu>li').each(function(){
		 $temp = $(this).attr('parentis');
		// console.log( parentid + ' ' + $temp);
		 if( parentid == $temp) {
			 $(this).addClass('classactive1');
		 }
	});
	// select mobile menu substr
	var parentidM = $('#mobileonlyselectid2 option:selected').attr('parent-id');
	console.log(parentidM);
	$("#mobileonlyselectid select option[value='" + parentidM + "']").prop("selected", true)
	
	
	//
	$('#mobileonlyselectid , #mobileonlyselectid2').on('change' , function(){
		var url = $('option:selected', this).attr('linkattr') ; 
		console.log(url);
		window.location.href = url;
	});
	//
	$(window).scroll(function() {
		var screenwidth = $(window).width();
		if( screenwidth > 750 ) {
			if($(window).scrollTop() > 350) {
				$('.catsallcareer').addClass('mefixed');
			} else {
				$('.catsallcareer').removeClass('mefixed');
			}
		}
	});
})(jQuery);
</script>
 <style type="text/css">
     .catsallcareer {
		 transition: all 1s ease-in-out;
	 }
     .mefixed {
		 width:100%;
		 z-index:999;
		 top:94px;
		 position:fixed;
	 }
	 .logged-in .mefixed {
		top:127px; 
	 }
</style>
 
<?php endif ;?>
<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>
 
</body>
</html>
