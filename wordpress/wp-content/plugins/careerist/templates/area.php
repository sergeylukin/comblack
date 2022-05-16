<div class="wrap">
	<h1>Job areas manager</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">List</a></li>
		<li><a href="#tab-2">Add / Edit</a></li>
		<li><a href="#tab-3">Export</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<h3>Job Areas</h3>

			<?php 
$areas = Database::getAllAreas();
print_r($areas);
die();

echo '<div id="dt_example"><div id="container"><form><div id="demo">';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"><thead><tr>';

foreach ($arr[0] as $k => $v) {
    echo "<td>".$k."</td>";
}

echo '</tr></thead><tbody>';

foreach($arr as $i=>$j){
	echo "<tr>";
	foreach ($arr[$i] as $k => $v) {
	    echo "<td>".$v."</td>";
	}
	echo "</tr>";
}

				echo '</table>';
			?>
			
		</div>

		<div id="tab-2" class="tab-pane">
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'careerist_plugin_area_edit' );
					do_settings_sections( 'careerist_area' );
					submit_button();
				?>
			</form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Export areas</h3>
		</div>
	</div>
</div>
