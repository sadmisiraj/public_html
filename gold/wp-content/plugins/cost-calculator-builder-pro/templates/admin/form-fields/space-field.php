<div class="ccb-field-setting-wrapper">
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-title"><?php esc_html_e( 'Space', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-close-setting" @click="closeSetting">
				<i class="ccb-icon-close"></i>
			</div>
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
