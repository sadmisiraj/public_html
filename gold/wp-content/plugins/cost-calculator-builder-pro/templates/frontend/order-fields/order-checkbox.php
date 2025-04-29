<?php
/**
 * @file
 * Order-checkbox component's template
 */
?>

<div class="ccb-order-checkbox" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-radio__title ccb-order-field__title">
		{{ label }}
		<span class="ccb-order-required-mark" v-if="required">*</span>
	</div>
	<div class=ccb-order-checkbox__wrapper :class="boxStyle">
		<div class="calc-checkbox-item" v-for="( element, index ) in getOptions">
			<input :checked="element.isChecked" type="checkbox" :id="label + index + field.id " v-model="checkboxValue" :value="element.optionText" style="display: none;">
			<label :for="label + index + field.id">
				<span>
					<span class="calc-checkbox-title">{{ element.optionText }}</span>
				</span>
				</span>
			</label>
		</div>
	</div>

	<div class="ccb-order-field-required left" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
