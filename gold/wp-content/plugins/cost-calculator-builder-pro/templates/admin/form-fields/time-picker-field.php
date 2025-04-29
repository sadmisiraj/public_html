<div class="ccb-field-setting-wrapper">
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-title"><?php esc_html_e( 'Time picker', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-close-setting" @click="closeSetting">
				<i class="ccb-icon-close"></i>
			</div>
		</div>
	</div>
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-confirmation-title"><?php esc_html_e( 'Make field required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-switch">
				<input type="checkbox" v-model="field.attributes.required" true-value="1" false-value="0"> 
				<label></label>
			</div>
		</div>
	</div>
	<div class="ccb-field-setting-text">
		<div class="ccb-field-setting-title">
			<span><?php esc_html_e( 'Label', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-input">
			<input type="text" v-model="field.attributes.label" class="ccb-input-setting">
		</div>
	</div>
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-confirmation-title"><?php esc_html_e( '24-hour format', 'cost-calculator-builder-pro' ); ?></span>
			<span class="ccb-options-tooltip"><i class="ccb-icon-circle-question"></i> <span class="ccb-options-tooltip__text"><?php esc_html_e( 'Set time in 24-hour format for precision', 'cost-calculator-builder-pro' ); ?></span></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-switch"><input type="checkbox" v-model="field.attributes.format" :true-value="'1'" :false-value="'0'"> <label></label></div>
		</div>
	</div>
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-confirmation-title"><?php esc_html_e( 'Range Time', 'cost-calculator-builder-pro' ); ?></span>
			<span class="ccb-options-tooltip"><i class="ccb-icon-circle-question"></i> <span class="ccb-options-tooltip__text" style="width: 200px !important; left: 33px;"><?php esc_html_e( 'Select a start and end time', 'cost-calculator-builder-pro' ); ?></span></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-switch"><input type="checkbox" v-model="field.attributes.range" :true-value="'1'" :false-value="'0'"> <label></label></div>
		</div>
	</div>
	<div class="ccb-field-width-setting">
		<div class="ccb-select-wrapper">
			<span class="ccb-prefix"><?php esc_html_e( 'Width', 'cost-calculator-builder-pro' ); ?></span>
			<select v-model="field.field_width">
				<option label="col-4" value="4">4</option>
				<option label="col-6" value="6">6</option>
				<option label="col-8" value="8">8</option>
				<option label="col-10" value="10">10</option>
				<option label="col-12" value="12">12</option>
			</select>
		</div>
	</div>
</div>
