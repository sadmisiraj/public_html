<?php
/**
 * @file
 * Order-number component's template
 */
?>

<div class="ccb-order-number" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-number__title ccb-order-field__title">
		{{ label }}
		<span class="ccb-order-required-mark" v-if="required">*</span>
	</div>
	<div class="ccb-order-number__wrapper" style="position: relative;">
		<input name="number" type="number" v-model="value" @input="updateValue" :placeholder="placeholder">
		<span @click="increment" class="input-number-counter up">
			<i class="ccb-icon-Path-3486"></i>
		</span>
		<span @click="decrement" class="input-number-counter down">
			<i class="ccb-icon-Path-3485"></i>
		</span>
	</div>

	<div class="ccb-order-field-required" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
