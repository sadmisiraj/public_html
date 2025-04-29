<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
	<div class="ccb-btn-wrap calc-buttons <?php echo $general_settings['invoice']['emailButton'] ? esc_attr( 'no-quote-button' ) : ''; ?>">
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
