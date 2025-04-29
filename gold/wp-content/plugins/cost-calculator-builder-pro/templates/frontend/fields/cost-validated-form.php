<?php
/**
 * @file
 * Cost-text component's template
 */
?>

<div :style="additionalCss" class="calc-item ccb-field" :class="{required: requiredWrapperActive && value.length <= 0, [formElementField.additionalStyles]: formElementField.additionalStyles, invalid: value.length > 0 && !validateField}" :data-id="formElementField.alias" :data-repeater="repeater">
	<div class="calc-item__title">
		<span v-if="formElementField.required && value.length <= 0" class="calc-required-field">
			<div class="ccb-field-required-tooltip">
				<span class="ccb-field-required-tooltip-text" :class="{active: requiredWrapperActive && value.length <= 0}" style="display: none;">{{ $store.getters.getTranslations.required_field }}</span>
			</div>
		</span>
		<span v-else-if="value.length > 0 && !validateField" class="calc-invalid-field">
			<div class="ccb-field-invalid-tooltip">
				<span class="ccb-field-invalid-tooltip-text" :class="{active: !validateField}" style="display: none;"><?php esc_html_e( 'Invalid input', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</span>
		<span>{{ formElementField.label }}</span>
		<span class="ccb-required-mark" v-if="formElementField.required">*</span>
	</div>

	<div class="calc-item__description before">
		<span v-text="formElementField.description"></span>
	</div>
	<div class="calc-form-element-field-wrapper">
		<component :is="getComponent" :value="value" :repeater="repeater" :field="formElementField" @update-value="updateValue" @update-error="updateError"></component>
	</div>

	<div class="calc-item__description after">
		<span v-text="formElementField.description"></span>
	</div>
</div>
