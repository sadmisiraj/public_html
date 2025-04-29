<?php
/**
 * @file
 * Cost-date-picker component's template
 */

	$lang = get_bloginfo( 'language' );
?>
<div :style="additionalCss" class="calc-item ccb-field" :class="{rtl: rtlClass('<?php echo esc_attr( $lang ); ?>'),required: requiredActive, [multiRange.additionalStyles]: multiRange.additionalStyles}" :data-id="multiRange.alias" :data-repeater="repeater">
	<div class="calc-range" :class="['calc_' + multiRange.alias]">
		<div class="calc-item__title ccb-range-field">
			<div class="ccb-range-label">
				<span v-if="multiRange.required" class="calc-required-field">
					<div class="ccb-field-required-tooltip">
						<span class="ccb-field-required-tooltip-text" :class="{active: requiredActive}" style="display: none;">
							{{ $store.getters.getTranslations.required_field }}
						</span>
					</div>
				</span>
				{{ multiRange.label }}
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
				<span class="ccb-required-mark" v-if="multiRange.required">*</span>
			</div>
			<div class="ccb-range-value"> {{ getFormatedValue }}</div>
		</div>

		<div class="calc-item__description before">
			<span v-text="multiRange.description"></span>
		</div>

		<div :class="['range_' + multiRange.alias]" class="calc-range-slider" data-ticks-position="top" :style="getStyles">
			<input type="range" :min="min" :max="max" v-model="leftVal" :step="step" v-model="leftVal" @input="change">
			<output class="cost-calc-range-output-pro"></output>
			<input type="range" :min="min" :max="max" v-model="rightVal" :step="step" v-model="rightVal" @input="change">
			<output class="cost-calc-range-output-pro"></output>
			<div class='calc-range-slider__progress'></div>
		</div>

		<div class="calc-range-slider-min-max">
			<span>{{ minText }}</span>
			<span>{{ maxText }}</span>
		</div>

		<div class="calc-item__description after">
			<span v-text="multiRange.description"></span>
		</div>
	</div>
</div>
