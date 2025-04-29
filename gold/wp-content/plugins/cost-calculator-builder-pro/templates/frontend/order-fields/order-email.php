<?php
/**
 * @file
 * Order-email component's template
 */
?>

<div class="ccb-order-email" :class="[width, confirmAtionPosition, {'error': field.requiredStatus}]">
	<div class="ccb-order-email__wrapper relative">
		<label :for="field.id">
			{{ label }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</label>
		<input type="text" :id="field.id" :placeholder="placeholder" @input="updateValue" @blur="checkValid" v-model="value">
		<div class="ccb-order-field-required" v-if="field.requiredStatus">
			<div class="ccb-order-field-required__tooltip">
				<span >{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="ccb-order-field-required" v-if="invalidEmail">
			<div class="ccb-order-field-required__tooltip" style="right: -1px;">
				<span ><?php esc_html_e( 'Incorrect email format', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="ccb-order-email__wrapper confirmation" v-if="confirmation">
		<label :for="field.id">
			{{ confirmLabel }}
			<span class="ccb-order-required-mark" v-if="required">*</span>
		</label>
		<input type="text" :id="field.id" :class="{'error': validConfirmEmail}" :placeholder="confirmationPlaceholder" @input="checkConfirmEmail" v-model="confirmEmail">
		<div class="confirmation-error" v-if="validConfirmEmail"><?php esc_html_e( 'The email addresses do not match', 'cost-calculator-builder-pro' ); ?></div>
	</div>
</div>
