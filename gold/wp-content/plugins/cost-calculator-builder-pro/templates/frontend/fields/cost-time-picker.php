<?php
/**
 * @file
 * Cost-time-picker component's template
 */
?>

<div :style="additionalCss" class="calc-item ccb-fields-tooltip ccb-field" :class="[timePickerField.additionalStyles, {required: requiredActive}]" :data-id="timePickerField.alias" :data-repeater="repeater">
	<div class="calc-item__title">
		<span v-if="timePickerField.required" class="calc-required-field">
			<div class="ccb-field-required-tooltip">
				<span class="ccb-field-required-tooltip-text" :class="{active: requiredActive}" style="display: none;">{{ $store.getters.getTranslations.required_field }}</span>
			</div>
		</span>
		<span> {{ timePickerField.label }} </span>
		<span class="ccb-required-mark" v-if="timePickerField.required">*</span>
		<span class="is-pro">
			<span class="pro-tooltip">
				pro
				<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
			</span>
		</span>
	</div>

	<div class="calc-item__description before">
		<span>{{ timePickerField.description }}</span>
	</div>
	<div :class="['calc_' + timePickerField.alias] " :style="getStyles">
		<div :class="['ccb-datetime', 'datetime', 'ccb-time-picker', timePickerField.alias, timePickerField.alias + '_datetime']">
			<div class="ccb-time-picker-wrapper " :class="getTimePickerClasses">
				<div v-if="!timePickerField.range" class="ccb-time-picker-basic">
					<vue-timepicker
						v-model="selectedTime.basic"
						:placeholder="this.placeholderText"
						:format="format"
						:minute-interval="5"
						drop-direction="auto"
						:class="getPickerControlBasic"
						:manual-input="manualInput"
						ref="timePickerBasic"
						@focus="basicFocusPicker = 'focused'"
						@close="closeHandler"
						fixed-dropdown-button
						@input="updateSelectedTime($event,'basic')"
					>
						<template v-slot:dropdownButton>
							<i class="ccb-icon-timepicker-light-clock"></i>
						</template>

					</vue-timepicker>
				</div>
				<div v-else class="ccb-time-picker-range">
					<div class="start">
						<vue-timepicker
							v-model="selectedTime.start"
							:placeholder="this.placeholderText"
							:class="getPickerControlStart"
							fixed-dropdown-button
							drop-direction="auto"
							:format="format"
							ref="timePickerStart"
							:manual-input="manualInput"
							@focus="basicFocusPicker = 'focused'"
							@close="basicFocusPicker = ''"
							:minute-interval="5"
							@input="updateSelectedTime($event,'start')"
						>
							<template v-slot:dropdownButton>
								<i class="ccb-icon-timepicker-light-clock"></i>
							</template>

						</vue-timepicker>
					</div>
					<span class="separator"><?php esc_html_e( 'to', 'cost-calculator-builder-pro' ); ?></span>
					<div class="end">
						<vue-timepicker
							v-model="selectedTime.end"
							:placeholder="placeholderText"
							:class="getPickerControlEnd"
							fixed-dropdown-button
							drop-direction="auto"
							ref="timePickerEnd"
							@focus="basicFocusPicker = 'focused'"
							@close="basicFocusPicker = ''"
							:format="format"
							:minute-interval="5"
							:manual-input="manualInput"
							@input="updateSelectedTime($event, 'end')"
						>
							<template v-slot:dropdownButton>
								<i class="ccb-icon-timepicker-light-clock"></i>
							</template>
						</vue-timepicker>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="calc-item__description after">
		<span>{{ timePickerField.description }}</span>
	</div>
</div>
