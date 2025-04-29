<?php
$desc_url = 'https://docs.stylemixthemes.com/cost-calculator-builder/cost-calculator-settings/calculator-settings/payments';
?>

<div class="ccb-success-row" v-if="settingsField.formFields.accessEmail">
	<span class="ccb-icon-Path-3484 ccb-success-sign"></span>
	<span class="ccb-success-text"><?php esc_html_e( 'Order Form is enabled and set up', 'cost-calculator-builder-pro' ); ?></span>
</div>

<div class="ccb-grid-box" v-if="!settingsField.formFields.accessEmail">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title" style="max-width: max-content"><?php esc_html_e( 'Form for Payments', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="col-12">
				<span class="ccb-tab-description-with-link">
					<?php esc_html_e( 'If the Order Form is disabled, this form will be used. You can edit the form anytime in the ', 'cost-calculator-builder-pro' ); ?>
					<a @click="tab = 'form-manager'" target="_blank">"<?php esc_html_e( 'Form Manager', 'cost-calculator-builder-pro' ); ?>"</a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="col col-4 ccb-m-t-15 ccb-forms-list-wrapper">
					<div class="ccb-select-box ccb-forms-list" >
						<span class="ccb-select-label"><?php esc_html_e( 'Forms', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<!-- <select style="padding-right: 34px;" class="ccb-select" v-model="settingsField.payment_gateway.paymentFormId">
								<option v-for="(value, index) in $store.getters.getFormsExisting" :key="index" :value="value['id']">{{ value['name'] }}</option>
							</select> -->
							<select v-if="settingsField.formFields.formType === 'cost-calculator'" style="padding-right: 34px;" class="ccb-select" v-model="settingsField.formFields.applyFormId">
								<option v-for="(value, index) in $store.getters.getFormsExisting" :key="index" :value="value['id']">{{ value['name'] }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box paypal">
	<div class="container">
		<div class="row">
			<div class="col" style="display: flex; justify-content: flex-start; column-gap: 13px">
				<span class="ccb-tab-title" style="max-width: max-content"><?php esc_html_e( 'PayPal Payment', 'cost-calculator-builder-pro' ); ?></span>
				<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/paypal.svg' ) ); ?>" alt="" style="max-width: 93px">
			</div>
			<div class="col-12">
				<span class="ccb-tab-description-with-link">
					<?php esc_html_e( 'Read more about integration here', 'cost-calculator-builder-pro' ); ?>
					<a href="https://developer.paypal.com/" target="_blank"> developer.paypal.com</a>
				</span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15 ccb-p-b-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="settingsField.payment_gateway.paypal.enable"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable PayPal payment', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="row" v-if="paypalExtended && settingsField.payment_gateway.paypal.enable">
			<div class="col-12">
				<div class="ccb-extended-general">
					<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
					<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to Settings → Payment Gateway and turn off the setting “Apply for all calculators”', 'cost-calculator-builder-pro' ); ?></span>
					<span class="ccb-extended-general-action">
						<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=payment-gateway' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
					</span>
				</div>
			</div>
		</div>

		<div class="ccb-settings-property" v-if="settingsField.payment_gateway.paypal.enable && !paypalExtended" style="border-top: 1px solid #dddddd;">
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
							<select class="ccb-select" v-model="settingsField.payment_gateway.paypal.integration_type">
								<option value="legacy"><?php esc_html_e( 'PayPal Legacy Integration', 'cost-calculator-builder-pro' ); ?></option>
								<option value="rest"><?php esc_html_e( 'PayPal REST API Integration', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>

				<template v-if="settingsField.payment_gateway.paypal.integration_type === 'legacy'">
					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.payment_gateway.paypal.paypal_email" placeholder="<?php esc_attr_e( 'Enter PayPal email', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</template>
				<template v-else>
					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Client ID', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.payment_gateway.paypal.client_id" placeholder="<?php esc_attr_e( 'Enter client ID', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>

					<div class="paypal-fields-item">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Client secret', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.payment_gateway.paypal.client_secret" placeholder="<?php esc_attr_e( 'Enter client secret', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</template>

				<div class="paypal-fields-item">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="settingsField.payment_gateway.paypal.currency_code">
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
							<select class="ccb-select" v-model="settingsField.payment_gateway.paypal.paypal_mode">
								<option value="" disabled><?php esc_html_e( 'Not selected', 'cost-calculator-builder-pro' ); ?></option>
								<option value="live"><?php esc_html_e( 'Live', 'cost-calculator-builder-pro' ); ?></option>
								<option value="sandbox"><?php esc_html_e( 'Sandbox', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box cards">
	<div class="container">
		<div class="row">
			<div class="col-12" style="display: flex; justify-content: flex-start; column-gap: 9px">
				<span class="ccb-tab-title" style="max-width: max-content"><?php esc_html_e( 'Card payments', 'cost-calculator-builder-pro' ); ?></span>
				<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/card_payments.svg' ) ); ?>" alt="">
			</div>
		</div>
	</div>
	<div class="container">
		<div class="ccb-settings-property">
			<div class="row">
				<div class="col col-12">
					<div class="ccb-card-payments">
						<div class="ccb-card-payment" v-for="(payment, key) in settingsField.payment_gateway.cards.card_payments">
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
									<img :src="cardPaymentsLogo(payment.slug)" :style="{maxWidth: payment.payment_logo_width}" alt="">
								</div>
								<div class="ccb-card-payment-status__item" v-show="payment.enable">
									<template v-if="payment.slug === 'razorpay' && razorPayExtended">
										<span class="ccb-help-tip-block" style="margin: 0;">
											<span class="ccb-card-global-settings">
												<i class="ccb-icon-Octicons"></i>
												<span><?php esc_html_e( 'Global settings are applied', 'cost-calculator-builder-pro' ); ?></span>
											</span>
											<span class="ccb-help ccb-help-settings payments-hint">
												<span class="payments-hint--header"><?php esc_html_e( 'Global settings are applied', 'cost-calculator-builder-pro' ); ?></span>
												<span class="payments-hint--body"><?php esc_html_e( 'Turn off "Apply for all calculators" from Global settings -> Payments', 'cost-calculator-builder-pro' ); ?></span>
												<span class="payments-hint--footer">
													<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=payment-gateway' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Global settings', 'cost-calculator-builder-pro' ); ?></a>
												</span>
											</span>
										</span>
									</template>
									<template v-else-if="payment.slug === 'stripe' && stripeExtended">
										<span class="ccb-help-tip-block" style="margin: 0;">
											<span class="ccb-card-global-settings">
												<i class="ccb-icon-Octicons"></i>
												<span><?php esc_html_e( 'Global settings are applied', 'cost-calculator-builder-pro' ); ?></span>
											</span>
											<span class="ccb-help ccb-help-settings payments-hint">
												<span class="payments-hint--header"><?php esc_html_e( 'Global settings are applied', 'cost-calculator-builder-pro' ); ?></span>
												<span class="payments-hint--body"><?php esc_html_e( 'Turn off "Apply for all calculators" from Global settings -> Payments', 'cost-calculator-builder-pro' ); ?></span>
												<span class="payments-hint--footer">
													<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=payment-gateway' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Global settings', 'cost-calculator-builder-pro' ); ?></a>
												</span>
											</span>
										</span>
									</template>
									<template v-else>
										<span class="ccb-not-integrated" :style="{fontWeight: paymentStatus(key) === 'Integrated' ? 700 : ''}">{{ paymentStatus(key) }}</span>
										<button type="button" class="ccb-button success ccb-settings" @click.prevent="() => setPaymentMethod(key)">
											<i class="ccb-icon-Maintenance-Service"></i>
											<span><?php esc_html_e( 'Setup', 'cost-calculator-builder-pro' ); ?></span>
										</button>
									</template>
								</div>
							</div>
						</div>
					</div>
				</div>
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
						<input type="checkbox" v-model="settingsField.payment_gateway.cash_payment.enable"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable cash payments', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" v-if="settingsField.payment_gateway.cash_payment.enable">
			<div class="row ccb-p-t-15" v-if="cashPaymentExtended">
				<div class="col-12">
					<div class="ccb-extended-general">
						<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to Settings → Payment Gateway and turn off the setting “Apply for all calculators”', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-action">
							<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=payment-gateway' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20" v-else>
				<div class="col col-4" style="padding-right: 5px">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Cash payment label', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.payment_gateway.cash_payment.label" placeholder="<?php esc_attr_e( 'Enter Label', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-4" style="padding-left: 5px">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Information to user (optional)', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.payment_gateway.cash_payment.type" placeholder="<?php esc_attr_e( 'Enter Info', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box">
	<div class="container">
		<div class="row">
			<div class="col col-9">
				<span class="ccb-field-title">
					<?php esc_html_e( 'Total Field Element', 'cost-calculator-builder-pro' ); ?>
				</span>
				<span class="ccb-field-totals">
					<label class="ccb-field-totals-item ccb-default-title" v-for="formula in getFormulaFields" :for="'payment_gateway' + formula.idx">{{ formula.title | to-short-description }}</label>
				</span>
				<span class="ccb-multiselect-overlay"></span>
				<div class="ccb-select-box" style="position: relative">
					<div class="multiselect">
						<span v-if="formulas.length > 0" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click.prevent="multiselectShow(event)" style="padding-right: 25px">
							<span class="ccb-multi-select-icon">
								<i class="ccb-icon-Path-3483"></i>
							</span>
							<template v-for="formula in formulas">
								<span class="selected-payment">
									<i class="ccb-icon-Path-3516"></i>
									{{ formula.title | to-short-input  }}
									<i class="ccb-icon-close" @click.self="removeIdx( formula )" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}"></i>
								</span>
								<span class="ccb-formula-custom-plus">+</span>
							</template>
						</span>
						<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
							<?php esc_html_e( 'Select totals', 'cost-calculator-builder-pro' ); ?>
						</span>
						<input name="options" type="hidden" />
					</div>
					<ul class="items row-list settings-list totals custom-list" style="max-width: 100% !important; left: 0; right: 0;">
						<li class="option-item settings-item" v-for="formula in getFormulaFields" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}" @click="(e) => autoSelect(e, formula)">
							<input :id="'payment_gateway' + formula.idx" :checked="getTotalsIdx.includes(+formula.idx)" name="paymentGatewayTotals" class="index" type="checkbox" @change="multiselectChooseTotals(formula)"/>
							<label :for="'payment_gateway' + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
						</li>
					</ul>
					<div class="ccb-select-description ccb-tab-subtitle" style="margin-top: 20px">
						<?php esc_html_e( "Choose the formula element(s) to show as the total cost in Orders and Payment gateways. If you choose several elements, the sum of these elements will be shown as ‘Total'.", 'cost-calculator-builder-pro' ); ?>
						<a href="<?php echo esc_attr( $desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn More', 'cost-calculator-builder-pro' ); ?></a>
					</div>
				</div>
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
