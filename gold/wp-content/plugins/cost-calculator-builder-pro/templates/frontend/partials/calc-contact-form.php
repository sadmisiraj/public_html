<?php
$invoice = $general_settings['invoice'];
?>
<div>
	<?php if ( ! empty( $settings ) && ! empty( $general_settings ) ) : ?>
		<template>
			<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/calc-form', array( 'settings' => $settings, 'general_settings' => $general_settings ) ); // phpcs:ignore ?>
		</template>
	<?php elseif ( empty( $settings ) && empty( $general_settings ) ) : ?>
		<template>
			<div class="calc-form-wrapper">
				<div class="ccb-btn-wrap calc-buttons <?php echo isset( $invoice['showAfterPayment'] ) && $invoice['emailButton'] && ! $invoice['showAfterPayment'] ? 'pdf-enable' : ''; ?>" v-if="getSettings">
					<button class="calc-btn-action success"><?php esc_html_e( 'Submit', 'cost-calculator-builder-pro' ); ?></button>
					<?php if ( isset( $invoice['showAfterPayment'] ) && $invoice['use_in_all'] && ! $invoice['showAfterPayment'] ) : ?>
						<button class="calc-btn-action" @click="getInvoice">
							<span class="ccb-ellipsis"><?php echo isset( $invoice['buttonText'] ) ? esc_html( ccb_truncate_string( $invoice['buttonText'] ) ) : ''; ?></span>
							<div class="invoice-btn-loader"></div>
						</button>
						<?php if ( isset( $invoice['emailButton'] ) && $invoice['emailButton'] ) : ?>
							<button class="calc-btn-action" @click="showSendPdf">
								<span class="ccb-ellipsis"><?php echo isset( $invoice['btnText'] ) ? esc_html( ccb_truncate_string( $invoice['btnText'] ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
							</button>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</template>
	<?php endif; ?>
</div>
