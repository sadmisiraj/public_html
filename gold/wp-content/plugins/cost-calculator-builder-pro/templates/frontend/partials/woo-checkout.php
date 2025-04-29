<?php
$invoice = isset( $general_settings['invoice'] ) ? $general_settings['invoice'] : array();
?>
<div class="calc-buttons woo-checkout-buttons <?php echo ! empty( $invoice ) && $invoice['emailButton'] && $invoice['use_in_all'] && ! $invoice['showAfterPayment'] ? esc_attr( 'pdf-enable' ) : ''; ?> <?php echo $general_settings['invoice']['use_in_all'] && ! $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] ? esc_attr( 'no-quote-button' ) : ''; ?>" style="min-height: 50px; margin-top: 20px; position: relative" v-if="getWooCheckoutSettings.enable">
	<loader-wrapper v-if="loader" :form="true" :idx="getPreloaderIdx" width="60px" height="60px" scale="0.8" :front="true"></loader-wrapper>
	<template v-else>
	<button class="calc-btn-action success ispro-wrapper" @click="applyWoo(<?php the_ID(); ?>)">
		<?php esc_html_e( 'Add To Cart', 'cost-calculator-builder-pro' ); ?>
		<span class="is-pro" v-if="!loader">pro</span>
	</button>
	<?php if ( empty( $general_settings ) && ! empty( $invoice ) && $invoice['use_in_all'] && ! $invoice['showAfterPayment'] ) : ?>
		<button class="calc-btn-action ispro-wrapper">
			<?php echo isset( $invoice['buttonText'] ) ? esc_html( $invoice['buttonText'] ) : 'PDF download'; ?>
		</button>
		<?php if ( $invoice['emailButton'] ) : ?>
			<button class="calc-btn-action" @click="showSendPdf">
				<span class="ccb-ellipsis"><?php echo isset( $invoice['btnText'] ) ? esc_html( ccb_truncate_string( $invoice['btnText'] ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
			</button>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
		<button class="calc-btn-action invoice-button" @click="getInvoice">
			<span class="ccb-ellipsis"><?php echo isset( $general_settings['invoice']['buttonText'] ) && ! empty( $general_settings['invoice']['buttonText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['buttonText'] ) ) : esc_html__( 'PDF Download', 'cost-calculator-builder-pro' ); ?></span>
			<div class="invoice-btn-loader"></div>
			<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
		</button>
		<?php if ( isset( $general_settings['invoice']['emailButton'] ) && $general_settings['invoice']['emailButton'] ) : ?>
			<button class="calc-btn-action" @click="showSendPdf">
				<span class="ccb-ellipsis"><?php echo isset( $general_settings['invoice']['btnText'] ) && ! empty( $general_settings['invoice']['btnText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['btnText'] ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
				<span class="is-pro">
							<span class="pro-tooltip">
								pro
							<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
						</span>
					</span>
			</button>
		<?php endif; ?>
	<?php endif; ?>
	</template>
</div>
