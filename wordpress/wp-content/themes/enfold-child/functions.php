<?php
 
function stop_removing_tags(){
    remove_filter('the_content', 'wpautop');
}
add_action('init', 'stop_removing_tags');
add_action('wp_enqueue_scripts', 'enfold_child_css', 1001);
 
// Load CSS
function enfold_child_css() {
	wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0.0', true );
    // porto child theme styles
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
	wp_register_style( 'styles-child2', get_stylesheet_directory_uri() . '/css/rtl.css' );
    wp_enqueue_style( 'styles-child' );
	wp_enqueue_style( 'styles-child2' );

}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );
      function load_admin_style() {
        wp_enqueue_style( 'admin_css',get_stylesheet_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
       } 
 
//add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/5.0.6/css/font-awesome.min.css' );
}
/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'New 1 Sidebar', 'textdomain' ),
        'id'            => 'new1sidebar-1',
        'description'   => __( 'New 1 Sidebar', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

$careerist_categories = Database::getCategoriesWithTaxonomy();
$careerist_areas = Database::getAreasWithTaxonomy();
function detect_category() {
	global $wp;
	$segments = explode('/', $wp->request);
	if ($segments[0] === 'categories') {
		$category = $segments[1];
		if ($category === 'all') {
			return 0;
		} else {
			$term = get_term_by('slug', $category, 'categories');
			if ($term->parent) {
				return $term->parent;
			} else {
				return $term->term_id;
			}
		}
	} else {
		return 0;
	}
}
function detect_subcategory() {
	global $wp;
	$segments = explode('/', $wp->request);
	if ($segments[0] === 'categories') {
		$category = $segments[1];
		if ($category === 'all') {
			return 0;
		} else {
			$term = get_term_by('slug', $category, 'categories');
			if ($term->parent) {
				return $term->term_id;
			} else {
				return 0;
			}
		}
	} else {
		return 0;
	}
}
function detect_area() {
	global $wp;
	$segments = explode('/', $wp->request);
	if ($segments[0] === 'categories' && $area = $segments[2]) {
		$term = get_term_by('slug', $area, 'area');
		return $term->term_id;
	}
	if ($segments[0] === 'area' && $area = $segments[1]) {
		if ($area == 'all') return 0;
		$term = get_term_by('slug', $area, 'area');
		return $term->term_id;
	}
}

add_shortcode( 'searchjobsformtest', 'searchjobsformtest_func' ); 
function searchjobsformtest_func($atts) {
	global $careerist_categories, $careerist_areas;
	$formUniqueHash = randomHash();
	$selected_category = detect_category();
	$selected_subcategory = detect_subcategory();
	$selected_area = detect_area();
     ob_start(); ?>
	<form name="careeristJobSearchForm<?php echo $formUniqueHash ?>" class="js-careeristJobSearchForm<?php echo $formUniqueHash ?> searchjobsformtest" method="GET" action="/">
    <div class="rowform1all99">
		<div class="rowform1">
			<select class="js-careeristCategorySelect<?php echo $formUniqueHash ?>">
<?php
$all_areas_term = get_term_by('slug', 'all', 'area');
$all_categories_term = get_term_by('slug', 'all', 'categories');
$all_subcategories_term = get_term_by('slug', 'all-subcategories', 'categories');
?>
	<option value="0" <?php echo $selected_category == 0 ? 'selected' : '' ?>><?php echo $all_categories_term->name; ?></option>
				<?php foreach($careerist_categories as $category): if (!$category['is_parent']) continue; ?>
				<option value="<?php echo $category['local_taxonomy_id'] ?>" <?php echo $category['local_taxonomy_id'] == $selected_category ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="rowform1">
			<select class="js-careeristSubcategorySelect<?php echo $formUniqueHash ?>">
			<option value="0" <?php echo $selected_subcategory == 0 ? 'selected' : '' ?>><?php echo $all_subcategories_term->name; ?></option>
			<?php foreach($careerist_categories as $category): if ($selected_category && $category['parent_local_taxonomy_id'] != $selected_category) continue; ?>
			<option value="<?php echo $category['local_taxonomy_id'] ?>" <?php echo $category['local_taxonomy_id'] == $selected_subcategory ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="rowform1">
			<select class="js-careeristAreaSelect<?php echo $formUniqueHash ?>">
			<option value="0" <?php echo $selected_area == 0 ? 'selected' : '' ?>><?php echo $all_areas_term->name; ?></option>
				<?php foreach($careerist_areas as $area): ?>
				<option value="<?php echo $area['local_taxonomy_id'] ?>" <?php echo $area['local_taxonomy_id'] == $selected_area ? 'selected' : '' ?>><?php echo $area['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div><!-- mz rowform1all-->
    <div class="rowform2">
	     <input type="submit" placeholder=" " value="חפש" />
	</div>

</form>
<script>
(function() {
	var careerist_categories = <?php echo json_encode($careerist_categories) ?>;
	var careerist_areas = <?php echo json_encode($careerist_areas) ?>;
	var careeristCategorySelect = document.querySelector('.js-careeristCategorySelect<?php echo $formUniqueHash ?>')
	var careeristSubcategorySelect = document.querySelector('.js-careeristSubcategorySelect<?php echo $formUniqueHash ?>')
	var careeristAreaSelect = document.querySelector('.js-careeristAreaSelect<?php echo $formUniqueHash ?>');
	var careeristJobSearchForm = document.querySelector('.js-careeristJobSearchForm<?php echo $formUniqueHash ?>');

	careeristCategorySelect.addEventListener('change', function(evt) {
		let catId = evt.target.value
		let subCategories = careerist_categories.filter((cat) => cat.parent_local_taxonomy_id === '' + catId)
		var i, L = careeristSubcategorySelect.options.length - 1;
		for(i = L; i >= 1; i--) {
			careeristSubcategorySelect.remove(i);
		}
		subCategories.forEach((category) => {
			var option = document.createElement("option");
			option.text = category.name;
			option.value = category.local_taxonomy_id;
			careeristSubcategorySelect.appendChild(option);
		})
	});

	const formChangeClb = function() {
		let actionUrl = ''
		if (careeristSubcategorySelect.value == 0 && careeristCategorySelect.value == 0) {
			if (careeristAreaSelect.value == 0) {
				actionUrl = '/categories/all'
			} else {
				let selectedAreaSlug = careerist_areas.filter((cat) => cat.local_taxonomy_id === '' + careeristAreaSelect.value)[0].slug
				actionUrl = '/area/' + selectedAreaSlug
			}
		} else {
			let selectedCategorySlug = (careeristSubcategorySelect.value != 0
				? careerist_categories.filter((cat) => cat.local_taxonomy_id === '' + careeristSubcategorySelect.value)[0].slug
				: careerist_categories.filter((cat) => cat.local_taxonomy_id === '' + careeristCategorySelect.value)[0].slug
			)
			let selectedAreaSlug = ''
			if (careeristAreaSelect.value != 0) {
				selectedAreaSlug = careerist_areas.filter((cat) => cat.local_taxonomy_id === '' + careeristAreaSelect.value)[0].slug
			}
			actionUrl = '/categories/' + selectedCategorySlug + '/' + selectedAreaSlug;
		}
		careeristJobSearchForm.action = actionUrl
	};

	formChangeClb();
	careeristCategorySelect.addEventListener('change', formChangeClb);
	careeristSubcategorySelect.addEventListener('change', formChangeClb);
	careeristAreaSelect.addEventListener('change', formChangeClb);
})();
</script>


 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 
//
add_shortcode( 'sidebarNew1', 'sidebarNew1_func' ); 
function sidebarNew1_func($atts) { 
     ob_start(); ?>
<?php if ( is_active_sidebar( 'new1sidebar-1' ) ) { ?>
    <ul class="sidebararchive11">
        <?php dynamic_sidebar('new1sidebar-1'); ?>
    </ul>
<?php } ?> 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 
//
add_shortcode( 'widgetimagetitle', 'widgetimagetitle_func' ); 
function widgetimagetitle_func($atts) { 
     ob_start(); ?>
	<div class="widgetimagetitleall" style="background-image: url( http://comblack.s553.upress.link/wp-content/uploads/2022/04/icon6.jpg);">
	      <h2>פיתוח תוכנה</h2>   
          <div class="widgetimagetext">תיאור הקטגוריה תיאור</div> 
          <div class="widgetimagelink">לתחום >></div>		  
	</div> 	
 <style>


 </style>
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 
//
add_shortcode( 'misratest', 'misratest_func' ); 
function misratest_func($atts) { 
     ob_start(); ?>
	<div class="misratestall">
	       <div class="misratestrow1">#חוקר סייבר #מרכז</div> 	    
	       <h2>משרה אחת שם המשרה</h2> 
           <div class="misratestrow2">תיאור המשרה:</div>  
           <div class="misratestrow3">צוות קומבלק – סיירת מערכות מידע מובחרת שבראשה איך לא, עומד אלי שוורץ בוגר ממר"מ. אז אם את/ה יוצא/ת ממר"מ, אופק, 8200, יח' טכנולוגית מובחרת או חי/ה ונושם/ת טכנולוגיות? מצויין!…. כי גם אנחנו ובדיוק בגלל זה מקומך איתנו.
בקומבלק תקבל/י לצידך צוות שתומך, מקדם, ממנף ומלווה אותך לאורך כל הקריירה והרבה יותר מעבר למשרה הראשונה.</div> 
           <div class="misratestrow4"><a href="" ><span >קרא עוד</span></a></div>    
	</div> 	
 <style>


 </style>
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
}
// [misrothitec type="subs"]
add_shortcode( 'misrothitec', 'misrothitec_func' ); 
function misrothitec_func($atts) { 
     ob_start();
	 $type = false ;
     if(isset($atts['type'])) {
		 if($atts['type'] == 'subs') {
			 $type = 'subs';
		 }  
	 }
//// get all parent job terms 
// image $imagebg =  get_field('toptitle2rows', 'term_' . $t->term_id);	
            $args = [
				'taxonomy'     => 'careers',
				'parent'        => 0,
				'number'        => 1000,
				'hide_empty'    => false           
			];
			$taxonomies = get_taxonomies(['object_type' => ['careers']]);
			$taxonomy = 'categories' ;
			 
			$termsparentall    = get_terms(['taxonomy' => $taxonomy , 'parent' => 0, 'hide_empty' => false , 'exclude'  => array(131 , 130) ]);
           foreach($termsparentall as $t){ 
		         $imagebg =  get_field('topimage', 'term_' . $t->term_id);	
				 //var_dump($imagebg);
				 if($imagebg['url']) {
					$topsectioncareerstyle = '22 style = "background-image: url('.$imagebg["url"].') !important;"';
				} else {
					$topsectioncareerstyle = "11";
				}
				 ?>
                 <a class="boxmisrothiteclink" href="<?php if ($t->term_id) { echo get_term_link($t->term_id); } ?>">
				<div class="widgetimagetitleall boxmisrothitec av-animated-generic bottom-to-top avia_start_delayed_animation99" <?php echo  $topsectioncareerstyle ; ?>>
				      <div class="boxmisrothitech2">
					        <h2><?php echo  $t->name; ?></h2> 
					  </div><!-- mz boxmisrothitech2--> 					  
					  <div class="widgetimagetext">
					  &nbsp;
					  </div> 
					  <div class="widgetimagelink">לתחום >></div>		  
				</div> 
				 </a>
                				

		   <?php
				 
		    }
	 ?>
 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 
//
function ParentOrChildCategoryOfJob($post_id = null , $parent = 'yes' , $datacat_and_sun_and_area_return_bytext = false , $datacat_and_child_ids_return_array = false) {
    $terms = get_the_terms($post_id, 'categories');
	$parentcatid = 0;
	$chilrencatids = array();
	foreach($terms as $key => $term){
		if($term->parent != 0){
			$chilrencatids[] = $term->term_id; 
		}
		if($term->parent == 0){
			$parentcatid = $term->term_id; 
		}
	}
	// area
	$areaterms = get_the_terms($post_id, 'area');
	$araeidarr = array();
	foreach($areaterms as $key => $terma){
		$araeidarr[] = $terma ;
	}
	if($datacat_and_sun_and_area_return_bytext == false){ // return id of parent or child
	    if($datacat_and_child_ids_return_array){
			$dataarr = array();
			$dataarr['parentcat'] = $parentcatid;
			$dataarr['chilrencatids'] = $chilrencatids;
			return $dataarr ;
		}
		if($parent == 'yes') {
			 return $parentcatid;
		} else {
			return $chilrencatids ;
		}
	} else { // return full data : cat , subs , area 
        	
		$data1 = '<span>תחום:</span> ' . linktotermbyid($parentcatid) . ' <span>|</span> '; 
		$data2 = '<span>מקצוע:</span> ' . linktotermbyid($chilrencatids) . ' <span>|</span> '; 
		$data3 = '<span class="eizorspan"><span>אזור:</span> ' . linktotermbyid($araeidarr).'</span>'; 
		$data = $data1 . $data2 . $data3;
		return $data ;
	}
	
}
// 
function linktotermbyid($termid){
	if($termid && !is_array($termid)) {
		return '<a href="'.get_term_link($termid).'">'.get_term( $termid )->name.'</a>' ; 
	} else {
		$temp = '';
		foreach($termid as $t) {
			$temp .= '<a href="'.get_term_link($t).'">'.get_term( $t )->name.'</a> ';
		}
		return $temp;
	}
	return ;
}
//
add_shortcode( 'lastjobs', 'lastjobs_func' ); 
function lastjobs_func($atts) { 
     ob_start();
$args = array(
    'post_type' => 'careers',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
    'posts_per_page' => 5
     );
$query = new WP_Query( $args ); 
if ( $query->have_posts() ) {
	echo '<div class="lastjobswidgetall"> ';
    while ( $query->have_posts() ) {
        $query->the_post();
		$id = get_the_id(); ?>
		 <div class="misratitlerowlast"> 
              <?php echo '<a class="atitlew" href="'.get_permalink($id).'">'.get_the_title().'</a>'; ?>  
		 </div><!-- mz misratitlerowlast--> 
		 <div class="misratestrow1"> 
			<?php
			$ParentOrChildCategoryOfJob = ParentOrChildCategoryOfJob($id , 'yes9' , true ,false);
			echo $ParentOrChildCategoryOfJob;
			?>
		 </div><!-- mz misratestrow1--> 
		 <div class="mafridbottom"></div>
	 <?php
 
    } 
	echo '</div><!-- mz lastjobswidgetall-->';
}
wp_reset_postdata();
	 ?>
 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 
//   
function relativejobs_func($postid) { 
     ob_start();
	 
	  $mychildcatid =  ParentOrChildCategoryOfJob($postid ,  'yes9' ,  false  ) ;
	 // echo $mychildcatid[0] ;
$args = array(
    'post_type' => 'careers',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
    'posts_per_page' => 3 , 
	'tax_query' =>
              array(
                        array(
                          'taxonomy' => 'categories',
                          'field'    => 'id',
                          'terms'    => $mychildcatid[0] 
                        ),
                      ), 
     );
$query = new WP_Query( $args ); 
if ( $query->have_posts() ) {
	echo '<div class="relativejobsboxall"> ';
    while ( $query->have_posts() ) {
        $query->the_post();
		$id = get_the_id(); ?>
		 <div class="relativejobsbox1"> 
			   <h3>
			   <a class="atitlewrelativ" href="<?php echo get_permalink($id); ?>">
			   <?php echo get_the_title(); ?>
			   </a> 
			   </h3>
			   <div class="atextwrelativ">
			        <?php echo the_excerpt() ; ?>
			   </div><!-- mz atextwrelativ-->
			   <div class="divider1"><span></span></div><!-- mz divider1--> 
			   <a class="atitlewrelativbutton" href="<?php echo get_permalink($id); ?>">
			   קרא עוד
			   </a> 
		  <div class="misratestrow1999"> 
			<?php
			//$ParentOrChildCategoryOfJob = ParentOrChildCategoryOfJob($id , 'yes9' , true ,false);
			//echo $ParentOrChildCategoryOfJob;
			?>
		 </div><!-- mz misratestrow1-->   
		 </div><!-- mz relativejobsbox1--> 
		  
		  
	 <?php
 
    } 
	echo '</div><!-- mz relativejobsboxall-->';
}
wp_reset_postdata();
	 ?>
 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
} 




// crm form [crmformNew courceid=""]
// crm form [crmformNew type="singlesidebar"]
add_shortcode( 'crmformNew', 'crmformNew_func' ); 
function crmformNew_func($atts) { 
     ob_start(); 
		 $formclasslang = 'crmformhe';
		 $fullnamelang = 'שם מלא';
		 $fullnamelangerror = 'יש להקליד שם מלא';
		 $phonelang = 'נייד';
		 $phonelangerror = 'יש להקליד מספר טלפון';
		 $emaillang ="דוא&quot;ל";
		 $emaillangerror ="ש להקליד כתובת מייל תקנית";
		 $sendbutton = "שלח";
		 $checkboxlang = 'אני מאשר קבלת חומר פרסומי, שיווקי ואחר לפרטים אלה';
		 
		  if(isset($atts['popupfooter'])    ) {
			  $popupfooter = $atts['popupfooter'];
			  //echo $popupfooter ;
			  $courceid = 9575 ;
	     } else {
			 $popupfooter = false;
		 }
		 if(isset($atts['courceid'])    ) {
			  $courceid = $atts['courceid'];
	     } else {
			 $courceid = 9575;
		 }
		  
		 
		 
		 /*
		 $test1 = 'test1';
		 $test2 = '0545565567';
		 $test3 = 'test333@jhgfg.com';
		 */
	     $test1 = '';
		 $test2 = '';
		 $test3 = '';
 		 
	 ?>
    <form    class="crmform <?php echo $formclasslang   ?>"  enctype="multipart/form-data" name="form" id="crmformnewid" method="POST" action="<?php echo get_page_link(get_the_ID());?>"   onsubmit="return validateFormSimple1(this);">

		<div class="formcrmall">
		<div class="formcrmrow">
		 <input type="hidden" name="courceid" value="<?php echo $courceid ; ?>" />
		 <input type="text" placeholder="Company" name="malkodetdvash"    class="malkodetdvash" >
			<div class="formcrmcell formcrmcellright"> 
					 <input class="must1"  type="text" placeholder="שם" name="firstname9" value="<?php echo  $test1; ?>"   >
					 <div class="erroritem"></div> 
			</div>
			<?php if(!$popupfooter):  // ?>
			<div class="formcrmcell formcrmcellleft"> 
					<div class="_input ">
					<input class="must1" type="tel" placeholder="טלפון" name="phone9"  value="<?php echo  $test2; ?>"  >
					<div class="erroritem"></div> 
				 
				</div>			
			</div>
			<?php endif ; ?>
			<div class="formcrmcell formcrmcellright"> 
					<div class="_input ">
						<input class="must1"  type="email" placeholder="אימייל" name="email9" value="<?php echo  $test3; ?>" >
						<div class="erroritem"></div> 
					</div>				
				</div>
			<?php if(  false):  // !$popupfooter?>
			<div class="formcrmcell formcrmcellleft"> 
					<div class="_input ">
					<input  class="must1" type="text"  placeholder="תעודת זהות" name="teze9" >
					<div class="erroritem"></div> 
				</div>			
			</div>
			<?php endif ; ?>
			<?php if(true): ?>
            <div class="formcrmrow">
		
				<div class="formcrmcell formcrmcellfull formcrmcell50centered">
				  <div class="_input">
                         <input  class="must1no" type="file" placeholder="קורות חיים" id="file" name="file" />
						 <div class="erroritem"></div>
                  </div>
               </div>
		    </div>
			<?php endif ; ?>
		</div>
		<div class="formcrmrow">
				
				<div class="formcrmcell formcrmcellleft"> 
				<div class="_input _submit">
                    <div id="submitdiv"><?php echo $sendbutton ; ?></div>
					<button style="display:none;" type="submit"><?php echo $sendbutton ; ?></button>
				</div>
				
				</div>
				<div class="sendsuccessmsg">הודעה נשלחה בהצלחה</div> 
		</div>
		
		 
</div> 
 
    </form>

 
<script type="text/javascript">
(function($){
$(window).load(function() {
    $('#submitdiv').on('click' , function(){
		 //
		 if(validateFormSimple1()) {  console.log('submitdiv');
			  send_api_data_theme();
			  $('.sendsuccessmsg').show();
			 window.location.href = 'https://comblack.co.il/thank-you/';
		 }
	});
});
})(jQuery);

function send_api_data_theme(){ 
console.log('send_api_data_theme');
        var fname , lname ,  email , phone ,  city , teze , cvfile ;
		if (document.getElementById("apiamail") || true) {
			 
              if(jQuery("#file" ).length != 0) {
				cvfile = jQuery("#file").val();
				// var files = jQuery('#file')[0].files;
				var file_data = jQuery('#file').prop('files')[0];
			  } else {
				  cvfile = '';
				  var file_data = '111';
			  }
			  var form_data = new FormData();
			  form_data.append('file', file_data);
              form_data.append('action', 'review_vote_ajax_request'); 
              form_data.append('fname', jQuery('#crmformnewid').find('input[name=firstname9]').val()); 
              //form_data.append('lname', jQuery('#crmformnewid').find('input[name=lastname9]').val()); 
              form_data.append('email', jQuery('#crmformnewid').find('input[name=email9]').val()); 
              form_data.append('phone', jQuery('#crmformnewid').find('input[name=phone9]').val()); 
             // form_data.append('city', jQuery('#crmformnewid').find('input[name=city9]').val()); 
              //form_data.append('teze', jQuery('#crmformnewid').find('input[name=teze9]').val()); 
              form_data.append('courceid', jQuery('#crmformnewid').find('input[name=courceid]').val()); 
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				contentType: false,
                processData: false,
                data: form_data,
				success:function(data){
				     console.log(data);
				},
				error: function(errorThrown){
				     console.log(errorThrown);
				}
			});
       } //if
 
     return false;
    }  
function validateFormSimple1(form) {   	 
	var myform =  jQuery('form#crmformnewid');
	var mustinputs = myform.find('.must1'); console.log()
	var labeltext = '';
	var errors = 0;
	mustinputs.each(function(index, el) {  
		jQuery(el).on('keypress click' , function(){
				jQuery(el).removeClass('notvalid');
				jQuery(el).next().text('');
			});	
        if(jQuery(el).val() == '' || jQuery(el).val() == null) { 
			 jQuery(el).focus(); 
			 jQuery(el).addClass('notvalid');
			labeltext = jQuery(el).attr("placeholder");
			 jQuery(el).parent().children('.erroritem').text('נא למלא שדה חובה -  ' + labeltext);
			errors = 1;	
		}
		if(jQuery(el).attr('type') == 'email' ) {  //alert('2');
			var email = jQuery(el).val();
			 var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if (!filter.test(email)) {
				jQuery(el).focus();
				 jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('נא למלא שדה אימייל בצורה תקינה' );
				
				 errors = 1; 
				 // return false; 
			}
 			
		}
		//
		if(jQuery(el).attr('type') == 'tel' ) {  //alert('2');
			var phone = jQuery(el).val();
			 var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
			 if (!filter.test(phone)) {
				jQuery(el).focus();
				 jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('נא למלא שדה טלפון בצורה תקינה' );
				
				 errors = 1; 
				 // return false; 
			}
			if(phone.length == 10 || phone.length == 9){
				
			} else {
				jQuery(el).focus();
				jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('נא למלא שדה טלפון בצורה תקינה' );
				
				 errors = 1; 
			}
 			
		}
		if(jQuery(el).attr('name') == 'teze9' ) {   //alert('3');
			var teze = jQuery(el).val();
			 var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
			 if (!filter.test(teze)) {
				jQuery(el).focus();
				 jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('נא למלא שדה תעודת זהות בצורה תקינה' );
				
				 errors = 1; 
				 // return false; 
			}
			if(teze.length == 10 || teze.length == 9){
				
			} else {
				jQuery(el).focus();
				jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('נא למלא שדה תעודת זהות בצורה תקינה' );
				
				 errors = 1; 
			}
 			
		}
		if(jQuery(el).attr('name') == 'file' ) {
			 var korot = jQuery(el).val(); console.log(korot + '1');
			if(korot == ''){
				jQuery(el).addClass('notvalid');
			         jQuery(el).parent().children('.erroritem').text('יש להעלות קובץ קורות חיים' );
			         //jQuery(el).parent().children('.erroritem').text(korot);
				
				 errors = 1; 
			}
		}
    });
	if(errors == 1) {
		return false ;
	} else {
		  return true;
	}
}	
</script> 
		<?php
		$out2 = ob_get_contents();
		ob_end_clean();
		return $out2;
		 
} 
function sendMailNew() { 
	 $filename = $_FILES['file']['name'];
	 
	 /* Location */
	$location = __DIR__."/cvuploads/".$filename;
	//var_dump($location); echo '<hrhrh>';
	
	$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
	$imageFileType = strtolower($imageFileType);
	 
    /* Valid extensions */
	$valid_extensions =  array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'); 
    $response = 0;
	 
	/* Check file extension */
	if(in_array(strtolower($imageFileType), $valid_extensions)) { //echo 'yes';
	   	/* Upload file */
		//var_dump(move_uploaded_file($_FILES['file']['tmp_name'],$location)) ;
	 
	   	if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	     	$response = $location;
	   	}  
	}
    if($response != 0 ){
		$response = $location;
	}
	  echo $response; // location uploaded to server
 
/////////////////

//header("Access-Control-Allow-Origin: *");
 header("Content-Type: text/html; charset=UTF-8");
 
 //var_dump($_POST);
         $fname =  $_POST['fname'];
        // $lname =  $_POST['lname'];
         $email =  $_POST['email'];
         $phone =  $_POST['phone'];
        // $city =  $_POST['city'];
         $teze =  $_POST['teze'];
         $cvfile =  $response;
         $courceid =  $_POST['courceid'];
		 
$subject = "Lead from comblack.co.il ". $courceid ;

$body .= "שם:  " . $fname  . "\n"; 
//if($lname != 'undefined') 	$body .= "שם משפחה:  " . $lname  . "\n" ; 
if($phone != 'undefined')
	$body .= "טלפון:  " . $phone . "\n" ; 
$body .= "אימייל/מייל:  " . $email . "\n"; 
// if($teze != 'undefined' && false) 	$body .= "תעודת זהות:  " . $teze . "\n";
// if($city != 'undefined') 	$body .= "עיר:  " . $city . "\n"; 
$body .= "נושא:  " . $courceid . "\n"; 
$body .= "REFERID=510 \n"; 
//$body .= $movefile['url'] . "\n"; 
//$body .= "נשלח מעמוד:" .  $_SERVER['HTTP_REFERER'] . "\n" . "\n";
$body .= "\n";

$attachments = array($response);

   // var_dump($_POST);
// wp_mail( "michaelzait@gmail.com", $subject, $body, 'From: comblack.co.il website <noreply@comblack.co.il>' , $attachments );
   
      wp_mail( "yotamizakov@gmail.com", $subject, $body, 'From: comblack.co.il website <noreply@comblack.co.il>' , $attachments );
	
       wp_mail( "jobs@comblack.co.il", $subject, $body, 'From: comblack.co.il website <noreply@comblack.co.il>' , $attachments );

   
} 
 
//
function review_vote_ajax_request() {
        sendMailNew();		  
wp_die();
}
 
add_action( 'wp_ajax_nopriv_review_vote_ajax_request', 'review_vote_ajax_request' );
add_action( 'wp_ajax_review_vote_ajax_request', 'review_vote_ajax_request' );















