<?php
/**
 * @file
 * Order-name component's template
 */
?>

<div class="ccb-order-name" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-name__wrapper">
		<label :for="field.id">
			{{ field.attributes.label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</label>
		<input type="text" :id="field.id" :placeholder="placeholder" @input="updateValue">
		<div class="ccb-order-field-required" v-if="field.requiredStatus">
			<div class="ccb-order-field-required__tooltip">
				<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
</div>
