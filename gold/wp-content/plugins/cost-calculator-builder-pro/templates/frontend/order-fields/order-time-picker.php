<?php
/**
 * @file
 * Order-time-picker component's template
 */
?>
<div class="ccb-order-time-picker" :class="[width, {'error': field.requiredStatus}]">
	<div class="calc-item ccb-field">
		<div class="ccb-order-radio__title ccb-order-field__title">
			{{ label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</div>
		<div class="ccb-order-time-picker__wrapper" :class="{ 'range-time': range }">
			<div class="ccb-order-time-picker__start">
				<vue-timepicker
					fixed-dropdown-button
					v-model="startValue"
					:class="getStartTimeClass"
					:format="getFormat"
					:placeholder="placeHolder"
					:minute-interval="5"
				>
					<template v-slot:dropdownButton>
						<i class="ccb-icon-timepicker-light-clock"></i>
					</template>
				</vue-timepicker>
			</div>
			<div class="separator" v-if="range"><?php esc_html_e( 'to', 'cost-calculator-builder-pro' ); ?></div>
			<div class="ccb-order-time-picker__end" v-if="range">
				<vue-timepicker
					fixed-dropdown-button
					v-model="endValue"
					:class="getEndTimeClass"
					:format="getFormat"
					:placeholder="placeHolder"
					:minute-interval="5"
				>
					<template v-slot:dropdownButton>
						<i class="ccb-icon-timepicker-light-clock"></i>
					</template>
				</vue-timepicker>
			</div>
		</div>
	</div>
	<div class="ccb-order-field-required" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
