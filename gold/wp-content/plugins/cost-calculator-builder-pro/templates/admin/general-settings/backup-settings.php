<div class="ccb-grid-box">
	<div class="container">
		<div class="row ccb-p-b-15">
			<div class="col-12">
				<span class="ccb-tab-title"><?php esc_html_e( 'Backup Settings', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="col-12 ccb-p-t-5">
				<span class="ccb-tab-subtitle">
					<?php printf('%s<br>%s', __( 'Turn this feature on if you want to back up the latest 3 versions of the calculator once you save them.', 'cost-calculator-builder-pro' ), __( 'Restore them by clicking the “Clock” button next to the “Preview” button on the right top.', 'cost-calculator-builder-pro' ) ); // phpcs:ignore ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="list-header ccb-tab-mobile-switcher">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.backup_settings.auto_backup"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Back up the latest 3 versions', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
