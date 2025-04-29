<?php
$general_settings = $general_settings ?? array();
$settings         = $settings ?? array();
$invoice          = $general_settings['invoice'] ?? array();
$marginTop        = is_admin() ? '20px' : '0';
?>

<div class="sub-list-item next-btn" :style="{'margin-top': summaryDisplay ? '<?php echo esc_attr( $marginTop ); ?>' : ''}">
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

			<invoice-btn inline-template v-if="type === 'invoiceBtn'">
				<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
					<div class="ccb-btn-wrap calc-buttons">
						<button class="calc-btn-action success ispro-wrapper" @click="getInvoice">
							<span class="ccb-ellipsis"><?php echo ! empty( $general_settings['invoice']['buttonText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['buttonText'] ) ) : esc_html__( 'PDF Download', 'cost-calculator-builder-pro' ); ?></span>
							<div class="invoice-btn-loader"></div>
							<span class="is-pro">
								<span class="pro-tooltip">
									pro
									<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
								</span>
							</span>
						</button>
						<?php if ( isset( $general_settings['invoice']['emailButton'] ) && $general_settings['invoice']['emailButton'] ) : ?>
							<button class="calc-btn-action ispro-wrapper" @click="showSendPdf">
								<span class="ccb-ellipsis"><?php echo ! empty( $general_settings['invoice']['btnText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['btnText'] ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
								<span class="is-pro">
									<span class="pro-tooltip">
										pro
										<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
									</span>
								</span>
							</button>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</invoice-btn>
			<calc-payments  inline-template v-if="type === 'payment'">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/calc-payments', array( 'settings' => $settings, 'general_settings' => $general_settings ) ); // phpcs:ignore ?>
			</calc-payments>
			<calc-woo-checkout inline-template v-if="type === 'woo_checkout'">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/woo-checkout', array( 'general_settings' => $general_settings, 'invoice' => $invoice ) ); // phpcs:ignore ?>
			</calc-woo-checkout>

			<template v-if="settings.woo_products?.enable">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/woo-products' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</template>

			<calc-form inline-template v-if="type === 'form'" :settings="settings">
				<div>
					<template>
						<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/calc-form', array( 'settings' => $settings, 'general_settings' => $general_settings ) ); // phpcs:ignore ?>
					</template>
				</div>
			</calc-form>
		</div>
	</div>
</div>
