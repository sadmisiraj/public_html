<?php
/**
 * @file
 * Order-Radio component's template
 */
?>

<div class="ccb-order-radio" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-radio__title ccb-order-field__title">
		{{ label }}
		<span class="ccb-order-required-mark" v-if="required">*</span>
	</div>
	<div class="ccb-order-radio__wrapper" :class="boxStyle">
		<label v-for="(element, index) in getOptions">
			<input type="radio" v-model="value" :value="element.optionText" v-model="radioValue" :value="element.optionText">
			<span>{{ element.optionText }}</span>
		</label>
	</div>
	<div class="ccb-order-field-required left" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
