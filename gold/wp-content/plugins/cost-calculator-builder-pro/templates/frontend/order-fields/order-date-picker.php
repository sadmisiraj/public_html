<?php
/**
 * @file
 * Order-date-picker component's template
 */
?>


<div class="ccb-order-date-picker" :class="[width, {'error': field.requiredStatus}]">
	<div class="calc-item ccb-field">
		<div class="ccb-order-radio__title ccb-order-field__title">
			{{ label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</div>
		<div>
			<customDateCalendarField v-model="datePickerValue" @setDatetimeField="setDatetimeField" :dateField="config"></customDateCalendarField>
		</div>
	</div>

	<div class="ccb-order-field-required" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
