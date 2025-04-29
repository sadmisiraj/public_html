<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Group', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save(groupField, id, index, groupField.alias)"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>

	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-9">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Group name', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="groupField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col-3" style="margin-top: 35px;">
					<div class="ccb-checkbox">
						<input type="checkbox" id="showTitle" v-model="groupField.showTitle">
						<label for="showTitle"><?php esc_html_e( 'Show Name', 'cost-calculator-builder-pro' ); ?></label>
					</div>
				</div>
				<div class="col-12 ccb-p-t-20">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="groupField.collapsible">
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Make this group collapsible', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-12 ccb-p-t-20" v-if="groupField.collapsible">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="groupField.collapse">
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Collapse this group by default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-12 ccb-p-t-20">
					<div class="list-header group-field-setting">
						<div class="ccb-switch">
							<input type="checkbox" v-model="groupField.hidden">
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Show this group based on condition', 'cost-calculator-builder-pro' ); ?></h6>
						<p>
							<?php esc_html_e( 'This makes the group hidden by default. Open "Conditions" tab and create a condition with this field so users can reveal it.', 'cost-calculator-builder-pro' ); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
