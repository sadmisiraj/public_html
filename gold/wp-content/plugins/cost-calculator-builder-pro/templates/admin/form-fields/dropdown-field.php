<div class="ccb-field-setting-wrapper">
  <div class="ccb-field-setting">
	<div class="ccb-field-setting-right">
	  <span class="ccb-field-setting-title"><?php esc_html_e( 'Dropdown', 'cost-calculator-builder-pro' ); ?></span>
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
	  <span><?php esc_html_e( 'Title of Dropdown Group', 'cost-calculator-builder-pro' ); ?></span>
	</div>
	<div class="ccb-field-setting-input">
	  <input type="text" v-model="field.attributes.label" class="ccb-input-setting">
	</div>
  </div>
	<div class="row ccb-p-t-15">
		<div class="col-12">
			<div class="ccb-options-container checkbox">
				<draggable
						v-model="field.attributes.options"
						class="ccb-options"
						draggable=".ccb-option"
						:animation="200"
						handle=".ccb-option-drag"
				>
					<div class="ccb-option" v-for="(option, index) in field.attributes.options" :key="index">
						<div class="ccb-option-drag" :class="{disabled: field.attributes.options?.length === 1}">
							<i class="ccb-icon-drag-dots"></i>
						</div>
						<div class="ccb-option-delete" @click.prevent="removeOption(index, option.optionValue)" :class="{disabled: field.attributes.options?.length?.length === 1}">
							<i class="ccb-icon-close"></i>
						</div>
						<div class="ccb-option-inner label-input">
							<div class="ccb-input-wrapper">
								<input type="text" class="ccb-heading-5" v-model="option.optionText" placeholder="<?php esc_attr_e( 'Option label', 'cost-calculator-builder' ); ?>">
							</div>
						</div>
					</div>
				</draggable>
				<div class="ccb-add-option-button-wrapper">
					<button class="ccb-add-option-button" @click.prevent="addOption">
						<span class="ccb-plus-sign">+</span>
						<span class="ccb-add-button-text"><?php esc_html_e( 'Add new', 'cost-calculator-builder' ); ?></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="ccb-field-setting" style="margin-top: 0px; margin-bottom: 5px;">
		<div class="ccb-field-setting-multiselect">
			<div class="ccb-switch"><input type="checkbox" v-model="field.attributes.multiselect"> <label></label></div>
			<span class="ccb-field-setting-multiselect-title"><?php esc_html_e( 'Multiselect', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>

	<div class="ccb-field-default-value ccb-p-t-10" v-if="!field.attributes.multiselect">
		<div class="ccb-select-box">
			<div class="ccb-field-setting-title">
				<span><?php esc_html_e( 'Default value', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="ccb-select-wrapper">
				<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
				<select class="ccb-select" @input="setDefVal">
					<option value="" default><?php esc_html_e( 'Not selected', 'cost-calculator-builder' ); ?></option>
					<option v-for="(value, index) in field.attributes.options" :selected="Array.isArray(field.attributes.default_value) && field.attributes.default_value[0] == value.optionText + '_' + index" :key="index" :value="value.optionText + '_' + index">{{ value.optionText }}</option>
				</select>
			</div>
		</div>
	</div>

	<div class="ccb-field-default-value ccb-p-t-10" v-else>
		<div class="ccb-field-setting-title">
			<span><?php esc_html_e( 'Default value', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="ccb-select-box" style="position: relative;">
			<div class="ccb-multi-select" tabindex="100" @click.prevent="multiselectShow(event)" :class="{ 'visible': multiselectOpened }">
				<i :class="['ccb-icon-Path-3485 ccb-select-arrow', {'ccb-arrow-up': multiselectOpened}]"></i>
				<span v-if="selectedOptions.length && selectedOptions.length < 3" class="anchor ccb-heading-5 ccb-light-3 ccb-selected">
					<span class="selected" v-for="(choosenOption, index) in selectedOptions" >
						{{ choosenOption.split('_')[0] }}
						<i class="ccb-icon-close" @click="deleteOption(index)"></i>
					</span>
				</span>
				<span v-else-if="selectedOptions.length >= 3" class="anchor ccb-heading-5 ccb-light ccb-selected">
					{{ selectedOptions.length }} <?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
				</span>
				<span v-else class="anchor ccb-heading-5 ccb-light-3">
						<?php esc_html_e( 'Select values', 'cost-calculator-builder' ); ?>
				</span>
			</div>
			<div class="ccb-order-checkbox" v-if="multiselectOpened">
				<div class="ccb-order-checkbox-overlay" @click="multiselectOpened = false"></div>
				<div class=ccb-order-checkbox__wrapper>
					<div class="calc-checkbox-item" v-for="( element, index ) in field.attributes.options">
						<input :checked="element.isChecked" type="checkbox" :id="element.optionText" v-model="selectedOptions" :value="element.optionText + '_' + index" style="display: none;">
						<label :for="element.optionText">
							<span>
								<span class="calc-checkbox-title">{{ element.optionText }}</span>
							</span>
							</span>
						</label>
					</div>
				</div>
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
