<?php
/**
 * @file
 * Order-textarea component's template
 */
?>

<div class="ccb-order-textarea" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-name__wrapper" style="position: relative; padding-bottom: 10px">
		<label :for="field.id">
			{{ label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</label>
		<textarea :name="field.type" :id="field.id" cols="6" rows="5" maxlength="500" v-model="value" :placeholder="placeholder"></textarea>
		<span class="ccb-order-text-counter" style="bottom: -7px;" v-if="parseInt(limit) > 0">{{value.length}} / {{limit}}</span>
		<div class="ccb-order-field-required" v-if="field.requiredStatus">
			<div class="ccb-order-field-required__tooltip">
				<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
</div>
