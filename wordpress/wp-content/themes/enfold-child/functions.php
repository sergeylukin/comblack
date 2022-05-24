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
//
add_shortcode( 'searchjobsformtest', 'searchjobsformtest_func' ); 
function searchjobsformtest_func($atts) { 
	$categories = Database::getCategoriesWithTaxonomy();
	$category = get_queried_object();
	  $careeristCategory = ['adam_id' => 0];
	  $careeristMainCategory = ['adam_id' => 0];
	if ($category) {
		$id = 0;
		if( have_posts() ) :
			while( have_posts() ) : the_post();
				$id = get_the_ID();
			endwhile ; 
		endif;


	  $careeristCategory = Database::getCategoryByTermId($category->term_id);
		if ($id)  {
			$mainCategoryId = 0;
			$categories_terms = wp_get_object_terms( $id,  'categories' );
			if ( ! empty( $categories_terms ) ) {
				if ( ! is_wp_error( $categories_terms ) ) {
					foreach( $categories_terms as $term ) {
						// echo $term->parent . ' === ';
						if($term->parent == 0) {
							// echo "UYESSSS FOUND IT " . $term->term_id;
							$mainCategoryId = $term->term_id;
						}
					}
				}
			}
			$careeristMainCategory = Database::getCategoryByTermId($mainCategoryId);
		} else if ($careeristCategory['adam_parent_id'] != 0) {
			$cagegory_adam_id = $careeristCategory['adam_parent_id'];
			$careeristMainCategory = Database::getCategoryByAdamId($category_adam_id);
		} else {
			$category_adam_id = $careeristCategory['adam_id'];
			$careeristMainCategory = Database::getCategoryByAdamId($category_adam_id);
		}
	}
	$areas = Database::getAreasWithTaxonomy();
     ob_start(); ?>
<form name="careeristJobSearchForm" class="searchjobsformtest" method="GET" action="/">
    <div class="rowform1all99">
		<div class="rowform1">
			<select class="js-careeristCategorySelect">
				<option value="0">תחום</option>
				<?php foreach($categories as $category): if (!$category['is_parent']) continue; ?>
				<option value="<?php echo $category['adam_id'] ?>" <?php echo $category['adam_id'] != $careeristMainCategory['adam_id'] ?: 'selected' ?>><?php echo $category['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="rowform1">
			<select class="js-careeristSubcategorySelect">
				<option value="0">מקצוע</option>
        <?php if ($careeristMainCategory): ?>
				<?php foreach($categories as $category): print_r($category); if ($category['adam_parent_id'] != $careeristMainCategory['adam_id']) continue; ?>
				<option value="<?php echo $category['slug'] ?>" <?php echo $category['adam_id'] != $careeristCategory['adam_id'] ?: 'selected' ?>><?php echo $category['name'] ?></option>
				<?php endforeach ?>
				<?php endif ?>
			</select>
		</div>
		<div class="rowform1">
			<select class="js-careeristAreaSelect">
				<option value="0">איזור</option>
				<?php foreach($areas as $area): ?>
				<option value="<?php echo $area['slug'] ?>" <?php echo $_GET['area'] != $area['slug'] ?: 'selected' ?>><?php echo $area['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div><!-- mz rowform1all-->
		<input class="js-careeristAreaInput" type="hidden" name="area" value="" />
    <div class="rowform2">
	     <input type="submit" placeholder=" " value="חפש" />
	</div>

</form>
<script>
var careerist_categories = <?php echo json_encode($categories) ?>;
console.log(careerist_categories);
let careeristCategorySelect = document.querySelector('.js-careeristCategorySelect')
let careeristSubcategorySelect = document.querySelector('.js-careeristSubcategorySelect')
let careeristJobSearchForm = document.querySelector('.js-careeristJobSearchForm');
careeristCategorySelect.addEventListener('change', function(evt) {
console.log('changed')
  let catId = evt.target.value
	let subCategories = careerist_categories.filter((cat) => cat.adam_parent_id === catId)
	var i, L = careeristSubcategorySelect.options.length - 1;
	for(i = L; i >= 0; i--) {
		careeristSubcategorySelect.remove(i);
	}
	subCategories.forEach((category) => {
		var option = document.createElement("option");
		option.text = category.name;
		option.value = category.slug;
		careeristSubcategorySelect.appendChild(option);
	})
});
let careeristAreaSelect = document.querySelector('.js-careeristAreaSelect');
const formChangeClb = function(evt) {
	let selectedCategorySlug = careeristSubcategorySelect.value
	let areaInput = document.querySelector('.js-careeristAreaInput');
	areaInput.value = careeristAreaSelect.value
	document.careeristJobSearchForm.action = '/categories/' + selectedCategorySlug + '/';
console.log(document.careeristJobSearchForm.action)
};
careeristCategorySelect.addEventListener('change', formChangeClb);
careeristSubcategorySelect.addEventListener('change', formChangeClb);
careeristAreaSelect.addEventListener('change', formChangeClb);
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
			 
			$termsparentall    = get_terms(['taxonomy' => $taxonomy , 'parent' => 0, 'hide_empty' => false]);
           foreach($termsparentall as $t){ 
		         $imagebg =  get_field('topimage', 'term_' . $t->term_id);	
				 //var_dump($imagebg);
				 if($imagebg['url']) {
					$topsectioncareerstyle = '22 style = "background-image: url('.$imagebg["url"].') !important;"';
				} else {
					$topsectioncareerstyle = "11";
				}
				 ?>
                 <a class="boxmisrothiteclink" href="<?php echo get_term_link($t->term_id) ; ?>">
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
		$data3 = '<span>איזור:</span> ' . linktotermbyid($araeidarr); 
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


