<?php
/**
 * @file
 * Order-short-text component's template
 */
?>

<div class="ccb-order-short-text" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-short-text__wrapper" style="position: relative; padding-bottom: 10px">
		<label :for="field.id">
			{{ label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</label>
		<input :name="field.type" type="text" :id="field.id" v-model="value" :maxlength="limit" cols="2" rows="1" :placeholder="placeholder""></input>
		<span class="ccb-order-text-counter" style="bottom: -7px;" v-if="parseInt(limit) > 0">{{value.length}} / {{limit}}</span>
		<div class="ccb-order-field-required" v-if="field.requiredStatus">
			<div class="ccb-order-field-required__tooltip">
				<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
</div>
