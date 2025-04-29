<div class="ccb-grid-box cards">
	<div class="container">
		<div class="row">
			<div class="col-12" style="display: flex; justify-content: flex-start; column-gap: 9px">
				<span class="ccb-tab-title" style="max-width: max-content"><?php esc_html_e( 'Card Payments', 'cost-calculator-builder-pro' ); ?></span>
				<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/card_payments.svg' ) ); ?>" alt="">
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.payment_gateway.cards.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.payment_gateway.cards.use_in_all}">
			<div class="row">
				<div class="col col-12">
					<div class="ccb-card-payments">
						<div class="ccb-card-payment" v-for="(payment, key) in generalSettings.payment_gateway.cards.card_payments">
							<div class="ccb-card-payment-title">
								<div class="list-header">
									<div class="ccb-switch">
										<input type="checkbox" v-model="payment.enable"/>
										<label></label>
									</div>
									<h6 class="ccb-heading-5">{{ payment.label }}</h6>
								</div>
							</div>
							<div class="ccb-card-payment-border"></div>
							<div class="ccb-card-payment-status">
								<div class="ccb-card-payment-status__item" :style="{paddingLeft: payment.slug === 'razorpay' ? '10px' : ''}">
									<img :src="payment.logo" :style="{maxWidth: payment.payment_logo_width}" alt="">
								</div>
								<div class="ccb-card-payment-status__item" v-show="payment.enable">
									<span class="ccb-not-integrated" :style="{fontWeight: paymentStatus(key) === 'Integrated' ? 700 : ''}">{{ paymentStatus(key) }}</span>
									<button type="button" class="ccb-button success ccb-settings" @click.prevent="() => setPaymentMethod(key)">
										<i class="ccb-icon-Maintenance-Service"></i>
										<span><?php esc_html_e( 'Setup', 'cost-calculator-builder-pro' ); ?></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box paypal">
	<div class="container">
		<div class="row">
			<div class="col-12" style="display: flex; justify-content: flex-start; column-gap: 13px">
				<span class="ccb-tab-title" style="max-width: max-content"><?php esc_html_e( 'PayPal Payment', 'cost-calculator-builder-pro' ); ?></span>
				<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/paypal.svg' ) ); ?>" alt="" style="max-width: 93px">
			</div>
			<div class="col">
				<span class="ccb-tab-description-with-link">
					<?php esc_html_e( 'Read more about integration here', 'cost-calculator-builder-pro' ); ?>
					<a href="https://developer.paypal.com/" target="_blank"> developer.paypal.com</a>
				</span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15 ccb-p-b-15" style="border-bottom: 1px solid #dddddd">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.payment_gateway.paypal.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.payment_gateway.paypal.use_in_all}">
			<div class="row ccb-p-t-15">
				<div class="col col-12">
					<div class="ccb-short-code">
					<span class="ccb-short-code-label">
						<span class="ccb-tab-description-with-link"><?php esc_html_e( 'PayPal IPN Setup:', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-short-code-copy" style="max-width: 100%">
							<span class="code"><?php echo esc_url( get_site_url() ); ?>/?stm_ccb_check_ipn=1</span>
							<span class="ccb-copy-icon ccb-icon-Path-3400 ccb-tooltip" @click.prevent="copyShortCode('paypal-ipn')" @mouseleave="resetCopy">
								<span class="ccb-tooltip-text" style="right: 0; left: -100px">{{ shortCode.text }}</span>
								<input type="hidden" class="calc-short-code" data-id="paypal-ipn" value="<?php echo esc_url( get_site_url() ); ?>/?stm_ccb_check_ipn=1">
							</span>
						</span>
					</span>
						<span class="ccb-default-description"><?php esc_html_e( 'Use the URL for IPN listener settings', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15 paypal-fields">
				<div class="paypal-fields-item">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Integration type', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="generalSettings.payment_gateway.paypal.integration_type">
								<option value="legacy"><?php esc_html_e( 'PayPal Legacy Integration', 'cost-calculator-builder-pro' ); ?></option>
								<option value="rest"><?php esc_html_e( 'PayPal REST API Integration', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>

				<template v-if="generalSettings.payment_gateway.paypal.integration_type === 'legacy'">
					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="generalSettings.payment_gateway.paypal.paypal_email" placeholder="<?php esc_attr_e( 'Enter PayPal email', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</template>
				<template v-else>
					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Client ID', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="generalSettings.payment_gateway.paypal.client_id" placeholder="<?php esc_attr_e( 'Enter client ID', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>

					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Client secret', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="generalSettings.payment_gateway.paypal.client_secret" placeholder="<?php esc_attr_e( 'Enter client secret', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</template>

				<div class="paypal-fields-item">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="generalSettings.payment_gateway.paypal.currency_code">
								<option value="" disabled><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></option>
								<option v-for="(element, index) in currencies" :key="index" :value="element.value">{{ element.alias }}</option>
							</select>
						</div>
					</div>
				</div>

				<div class="paypal-fields-item">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Account type', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="generalSettings.payment_gateway.paypal.paypal_mode">
								<option value="" disabled><?php esc_html_e( 'Not selected', 'cost-calculator-builder-pro' ); ?></option>
								<option value="live"><?php esc_html_e( 'Live', 'cost-calculator-builder-pro' ); ?></option>
								<option value="sandbox"><?php esc_html_e( 'Sandbox', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box cards">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<span class="ccb-tab-title"><?php esc_html_e( 'Cash Payment', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="col-12">
				<span class="ccb-tab-description-with-link"><?php esc_html_e( 'Your client can pay in cash for your service or product', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.payment_gateway.cash_payment.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.payment_gateway.cash_payment.use_in_all}">
			<div class="row ccb-p-t-20">
				<div class="col col-4" style="padding-right: 5px;">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Cash payment label', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.payment_gateway.cash_payment.label" placeholder="<?php esc_attr_e( 'Enter Label', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-4" style="padding-left: 5px;">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Information to user (optional)', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.payment_gateway.cash_payment.type" placeholder="<?php esc_attr_e( 'Enter Info', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>

<ccb-modal-window @on-close="closeModel">
	<template v-slot:content>
		<template v-if="$store.getters.getModalType === 'payment-settings'">
			<?php require CALC_PATH . '/templates/admin/single-calc/modals/payment-settings.php'; ?>
		</template>
	</template>
</ccb-modal-window>
