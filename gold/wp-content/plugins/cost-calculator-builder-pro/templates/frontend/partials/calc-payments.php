<?php

use cBuilder\Classes\CCBSettingsData;

$is_admin         = ( isset( $_GET['page'] ) && 'cost_calculator_builder' === $_GET['page'] );
$general_settings = CCBSettingsData::get_calc_global_settings();

if ( $is_admin ) {
	wp_enqueue_script( 'calc-stripe', 'https://js.stripe.com/v3/', array(), CALC_VERSION, false );
	wp_enqueue_script( 'calc-twoCheckout', CALC_URL . '/frontend/dist/libs/2co.min.js', array(), CALC_VERSION, false );
}

$btn_width = '100%';

if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) {
	$btn_width = '';
}

?>
<div v-if="paymentAvailable">
	<div class="calc-item">
		<div class="calc-item-title" style="margin-bottom: 10px" v-if="!form" :class="{'calc-disabled': getStep === 'finish'}">
			<span class="ccb-pro-feature-header"><?php esc_html_e( 'Payment methods', 'cost-calculator-builder-pro' ); ?></span>
			<span class="is-pro">
				<span class="pro-tooltip">
					pro
					<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
				</span>
			</span>
		</div>

		<div class="calc-item-title" style="margin-bottom: 25px" v-if="getHideCalc">
			<h4>
				<?php esc_html_e( 'Stripe details', 'cost-calculator-builder-pro' ); ?>
			</h4>
			<span class="is-pro">
				<span class="pro-tooltip">
					pro
					<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
				</span>
			</span>
		</div>

		<div class="calc-item ccb-field calc-payments" :class="{'calc-disabled': getStep === 'finish'}">
			<div class="calc-radio-wrapper default">
				<template v-for="payment in getStaticPayments">
					<label style="margin-right: 15px" v-if="isPaymentEnabled(payment.slug)">
						<div class="calc-payment-header">
							<div class="calc-payment-header--label">
								<input type="radio" name="paymentMethods" :value="payment.value" v-model="getMethod">
								<span class="calc-radio-label">{{ payment.label }}</span>
								<span class="is-pro">
								<span class="pro-tooltip">
									pro
									<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
								</span>
							</span>
							</div>
							<div class="calc-payment_header__img">
								<img :src="payment.image" alt="card-payment-image" :style="{'max-width': payment.width}">
							</div>
						</div>
						<div class="calc-payment-body" v-show="isValidPaymentMethod(payment)">
							<div v-show="getMethod === 'stripe'" style="background: transparent;" :id="'ccb_stripe_' + getSettings.calc_id" class="calc-stripe-wrapper"></div>
							<div v-show="getMethod === 'twoCheckout'" style="background: transparent;" class="calc-two-checkout-wrapper">
								<div class="calc-payment-input ccb-two-checkout-card" :class="{'hide-card': !twoCheckout.hideCard}" @click="focusOnCard">
									<div class="calc-payment-image-wrapper">
										<img src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/payments/visa.svg' ); ?>" alt="card">
									</div>
									<input type="text" v-model="twoCheckout.cardNumber" :style="twoCheckout.cardStyle" @blur="cardBlur" @focusout="cardFocusOut" ref="card" placeholder="<?php esc_html_e( 'Card Number', 'cost-calculator-builder-pro' ); ?>">
								</div>
								<div class="calc-payment-details" :class="{'show-card': isCardNumberValid}">
									<div class="calc-payment-input ccb-two-checkout-month-and-year">
										<input type="text" v-model="twoCheckout.month_and_year" ref="month_and_year" placeholder="<?php esc_html_e( 'MM / YY', 'cost-calculator-builder-pro' ); ?>">
									</div>
									<div class="calc-payment-input ccb-two-checkout-cvv">
										<input type="text" v-model="twoCheckout.cvv" ref="cvv" placeholder="<?php esc_html_e( 'CVV', 'cost-calculator-builder-pro' ); ?>">
									</div>
									<div class="calc-payment-input ccb-two-checkout-zip-code">
										<input type="text" :data-length="twoCheckout.cardNumber.length" v-model="twoCheckout.zip_code" ref="zip_code" placeholder="<?php esc_html_e( 'Zip', 'cost-calculator-builder-pro' ); ?>">
									</div>
								</div>
							</div>
							<template v-if="payment?.description?.length">
								<span class="ccb-payment-description">{{ payment.description }}</span>
							</template>
						</div>
					</label>
				</template>
			</div>
		</div>

		<div class="calc-form-wrapper"  v-if="shouldProcessPaymentMethod" style="display:flex; flex-direction: column; gap: 10px; padding-bottom: 20px;">
			<div class="ccb-order-layout" v-if="!getHideCalc" style="padding: 0 1px;">
				<template v-for="(field, index) in paymentOrderFormFields" :key="field.id">
					<component
						:is="'order-' + field.type"
						:field="field"
						class="ccb-order-field"
					>
					</component>
				</template>
			</div>
		</div>

		<!-- <div class="calc-form-wrapper" :style="{'margin-top': paymentDetailsList.includes(getMethod) ? '25px' : ''}">
			<div class="ccb-pro-feature-header" v-if="isPaymentMethodAvailable" style="margin-bottom: 10px"><?php esc_html_e( 'Order Details', 'cost-calculator-builder-pro' ); ?></div>
			<div class="calc-default-form">
				<template v-if="shouldProcessPaymentMethod">
					<div class="calc-item ccb-field ccb-field-quantity" :class="{required: getRequiredMessage('name_field'), 'calc-disabled': getStep === 'finish'}">
						<span :class="{active: getRequiredMessage('name_field')}" class="ccb-error-tip front default" v-text="getRequiredMessage('name_field')"></span>
						<div class="calc-item__title">
							<span><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<div class="calc-input-wrapper ccb-field">
							<input type="text" v-model="paymentForm.sendFields[0].value" @input="clearRequired('name_field')" :disabled="loader" class="calc-input ccb-field ccb-appearance-field">
						</div>
					</div>

					<div class="calc-item ccb-field ccb-field-quantity" :class="{required: getRequiredMessage('email_field'), 'calc-disabled': getStep === 'finish'}">
						<span :class="{active: getRequiredMessage('email_field')}" class="ccb-error-tip front default" v-text="getRequiredMessage('email_field')"></span>
						<div class="calc-item__title">
							<span><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<div class="calc-input-wrapper ccb-field">
							<input type="email" v-model="paymentForm.sendFields[1].value" @input="clearRequired('email_field')" :disabled="loader" class="calc-input ccb-field ccb-appearance-field">
						</div>
					</div>

					<div class="calc-item ccb-field ccb-field-quantity" :class="{required: getRequiredMessage('phone_field'), 'calc-disabled': getStep === 'finish'}">
						<span :class="{active: getRequiredMessage('phone_field')}" class="ccb-error-tip front default" v-text="getRequiredMessage('phone_field')"></span>
						<div class="calc-item__title">
							<span><?php esc_html_e( 'Phone', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<div class="calc-input-wrapper ccb-field">
							<input type="number" :disabled="loader" v-model="paymentForm.sendFields[2].value" @input="clearRequired('phone_field')" class="calc-input ccb-field ccb-appearance-field">
						</div>
					</div>

					<div class="calc-item ccb-field ccb-field-quantity" :class="{'calc-disabled': getStep === 'finish'}">
						<div class="calc-item__title">
							<span :class="{'require-fields': paymentForm.requires[3].required}"><?php esc_html_e( 'Message', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<div class="calc-input-wrapper ccb-field">
							<textarea v-model="paymentForm.sendFields[3].value" class="calc-input ccb-field ccb-appearance-field"></textarea>
						</div>
					</div>
				</template>
			</div>
		</div> -->
	</div>

	<div class="ccb-btn-wrap" style="margin-top: 20px; position: relative">
		<loader-wrapper v-if="loader" :form="true" :idx="getPreloaderIdx" width="60px" height="60px" scale="0.8" :front="true"></loader-wrapper>
		<div class="ccb-btn-container calc-buttons <?php echo $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ? esc_attr( 'pdf-enable' ) : ''; ?> <?php echo $general_settings['invoice']['use_in_all'] && ! $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] ? esc_attr( 'no-quote-button' ) : ''; ?>" v-else>
			<button style="width: <?php echo esc_attr( $btn_width ); ?>" class="calc-btn-action success calc-make-payment" v-if="getMethod === 'woocommerce_checkout'" @click="applyWoo(<?php the_ID(); ?>)" :class="purchaseBtnClass">
				<?php esc_html_e( 'Add To Cart', 'cost-calculator-builder-pro' ); ?>
			</button>
			<button style="width: <?php echo esc_attr( $btn_width ); ?>" class="calc-btn-action success calc-make-payment" v-else @click.prevent="() => OrderPayment()" :class="purchaseBtnClass">
				<span><?php esc_html_e( 'Make payment', 'cost-calculator-builder-pro' ); ?></span>
				<i class="ccb-icon-click-out"></i>
			</button>

			<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && $general_settings['invoice']['use_in_all'] ) : ?>
				<template v-if="getInvoiceBtnStatuses">
					<button class="calc-btn-action invoice-button ispro-wrapper" @click="getInvoice">
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
						<button class="calc-btn-action ispro-wrapper" @click="showSendPdf">
							<span class="ccb-ellipsis"><?php echo isset( $general_settings['invoice']['btnText'] ) && ! empty( $general_settings['invoice']['btnText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['btnText'] ) ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
							<span class="is-pro">
								<span class="pro-tooltip">
									pro
									<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
								</span>
							</span>
						</button>
					<?php endif; ?>
				</template>
			<?php endif; ?>
		</div>
	</div>
</div>
