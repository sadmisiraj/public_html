<?php
$general_settings = $general_settings ?? array();
$invoice          = $general_settings['invoice'] ?? array();
$marginTop        = is_admin() ? '' : '0';
?>

<div class="sub-list-item next-btn" :style="{'margin-top': !(!summaryDisplay || showAfterSubmit) ? '<?php echo esc_attr( $marginTop ); ?>' : ''}">
	<div class="ccb-next-content">
		<div class="payment-methods">
			<?php if ( empty( $general_settings ) && ! empty( $invoice['use_in_all'] ) && ! empty( $invoice['showAfterPayment'] ) ) : ?>
				<div class="calc-form-wrapper">
					<div class="ccb-btn-wrap calc-buttons" v-if="type === 'invoiceBtn'">
						<button class="calc-btn-action success ispro-wrapper">
							<span><?php echo isset( $invoice['buttonText'] ) ? esc_html( ccb_truncate_string( $invoice['buttonText'], 20 ) ) : ''; ?></span>
						</button>
						<?php if ( isset( $invoice['emailButton'] ) && $invoice['emailButton'] ) : ?>
							<button class="calc-btn-action" @click="showSendPdf">
								<span><?php echo isset( $invoice['btnText'] ) ? esc_html( ccb_truncate_string( $invoice['btnText'], 20 ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
							</button>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<invoice-btn v-if="type === 'invoiceBtn'"></invoice-btn>
			<calc-payments v-if="type === 'payment'"></calc-payments>
			<calc-woo-checkout ref="woo_checkout" v-show="type === 'woo_checkout'"></calc-woo-checkout>

			<template v-if="settings.woo_products?.enable && !settings.page_break?.summary_after_last_page">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/woo-products' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</template>

			<calc-form v-if="type === 'form'" @submit="submit" :settings="settings"></calc-form>
		</div>
	</div>
</div>
