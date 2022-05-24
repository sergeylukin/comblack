<?php $datacats = ParentOrChildCategoryOfJob(get_the_id() , 'yes' , false ,  true) ;
$currenttermid  = $parentcat = $datacats['parentcat'];
$chilrencatids = $datacats['chilrencatids'];
$chilrencatids = $chilrencatids[0]; // get first id from array
/*var_dump($datacats);
echo '<br>';
var_dump($parentcat);
echo '<br>';
var_dump($chilrencatids);
*/
 ?>

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
								if($chilrencatids == $tid) {
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
</div><!-- mz subcatsallcareer-->