<div class="wrap">
	<h1>Careerist Plugin</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Settings</a></li>
		<li><a href="#tab-2">Monitoring</a></li>
		<li><a href="#tab-3">Docs</a></li>
	</ul>

	<div class="tab-content u-relative">
		<div id="tab-1" class="tab-pane active">
			<div class="text-right u-absolute-right">
				<form id="careerist-sync-trigger-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

					<div class="field-container u-relative">
						<div>
										<button type="submit" class="button-modern" role="button">Trigger sync</button>
								</div>
					</div>
					<div>
						<small class="field-msg js-form-submission">Sending...h</small>
						<small class="field-msg success js-form-success">Yay!</small>
						<small class="field-msg error js-form-error">There was a problem with this action</small>
					</div>

					<input type="hidden" name="action" value="careerist_sync_trigger">
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("sync-trigger-nonce") ?>">

				</form>
			</div>

			<form method="post" action="options.php">
				<?php 
					settings_fields( 'careerist_plugin_settings' );
					do_settings_sections( 'careerist_plugin' );
					submit_button();
				?>
			</form>
			
		</div>

		<div id="tab-2" class="tab-pane">
			<h3>Monitoring</h3>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Documentation</h3>
		</div>
	</div>
</div>
