<div class="ccb-field-setting-wrapper">
  <div class="ccb-field-setting">
	<div class="ccb-field-setting-right">
	  <span class="ccb-field-setting-title"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
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
				<input type="checkbox" v-model="field.attributes.required" true-value="1" false-value="0" :disabled="field.attributes.primary === '1' || field.attributes.primary === true"> 
				<label></label>
			</div>
		</div>
	</div>
  <div class="ccb-field-setting-text">
	<div class="ccb-field-setting-title">
	  <span><?php esc_html_e( 'Field Label', 'cost-calculator-builder-pro' ); ?></span>
	</div>
	<div class="ccb-field-setting-input">
	  <input type="text" v-model="field.attributes.label" class="ccb-input-setting">
	</div>
  </div>
	<div class="ccb-field-setting-text">
	  <div class="ccb-field-setting-title">
		  <span><?php esc_html_e( 'Field Placeholder', 'cost-calculator-builder-pro' ); ?></span>
	  </div>
	  <div class="ccb-field-setting-input">
		  <input type="text" v-model="field.attributes.placeholder" class="ccb-input-setting">
	  </div>
	</div>
	<div class="ccb-field-setting">
		<div class="ccb-field-setting-right">
			<span class="ccb-field-setting-confirmation-title"><?php esc_html_e( 'Email confirmation', 'cost-calculator-builder-pro' ); ?></span>
			<span class="ccb-options-tooltip"><i class="ccb-icon-circle-question"></i> <span class="ccb-options-tooltip__text"><?php esc_html_e( 'Users will enter their email to verify their email address.', 'cost-calculator-builder-pro' ); ?></span></span>
		</div>
		<div class="ccb-field-setting-left">
			<div class="ccb-switch" @click="emailPositionAdjust"><input type="checkbox" v-model="field.attributes.confirmation" :true-value="'1'" :false-value="'0'"> <label></label></div>
		</div>
	</div>

	<div class="ccb-field-setting-text" v-if="field.attributes.confirmation ==='1' || field.attributes.confirmatino === true">
		<div class="ccb-field-setting-title">
		<span><?php esc_html_e( 'Field Label', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-input">
		<input type="text" v-model="field.attributes.confirmation_label" class="ccb-input-setting">
		</div>
	</div>
	<div class="ccb-field-setting-text" v-if="field.attributes.confirmation ==='1' || field.attributes.confirmatino === true">
		<div class="ccb-field-setting-title">
			<span><?php esc_html_e( 'Field Placeholder', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-field-setting-input">
			<input type="text" v-model="field.attributes.confirmation_placeholder" class="ccb-input-setting">
		</div>
	</div>

	<div class="ccb-field-width-setting">
	  <div class="ccb-select-wrapper">
		<span class="ccb-prefix"><?php esc_html_e( 'Width', 'cost-calculator-builder-pro' ); ?></span>
		<select v-model="field.field_width">
		  <option label="col-4" value="4" disabled>4</option>
		  <option label="col-6" value="6" :disabled="field.attributes.position==='Right'">6</option>
		  <option label="col-8" value="8" :disabled="field.attributes.position==='Right'">8</option>
		  <option label="col-10" value="10" :disabled="field.attributes.position==='Right'">10</option>
		  <option label="col-12" value="12">12</option>
		</select>
	  </div>
	  </div>
	<div class="ccb-field-width-setting" v-if="field.attributes.confirmation === '1' || field.attributes.confirmation === true">
		<div class="ccb-select-wrapper ccb-position">
			<span class="ccb-prefix"><?php esc_html_e( 'Position', 'cost-calculator-builder-pro' ); ?></span>
			<select v-model="field.attributes.position" @click="adjustWidthToMax">
				<option label="<?php echo esc_attr( 'Bottom', 'cost-calculator-bulider-pro' ); ?>" value="Vertical"><?php esc_html_e( 'Vertical', 'cost-calculator-builder-pro' ); ?></option>
				<option label="<?php echo esc_attr( 'Right', 'cost-calculator-bulider-pro' ); ?>" value="Right"><?php esc_html_e( 'Right', 'cost-calculator-builder-pro' ); ?></option>
			</select>
		</div>
	</div>
</div>
