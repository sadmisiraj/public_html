<?php
use cBuilder\Classes\CCBSettingsData;

$general_settings = CCBSettingsData::get_calc_global_settings();
?>
<div class="calc-form-wrapper <?php echo esc_attr( apply_filters( 'ccb_contact_form_style_class', '', $settings ) ); ?>">
	<div v-show="isFormAccessibleByEmail" class="calc-buttons <?php echo $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ? esc_attr( 'pdf-enable' ) : ''; ?> <?php echo $general_settings['invoice']['use_in_all'] && ! $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] ? esc_attr( 'no-quote-button' ) : ''; ?>">
		<button @click.prevent="toggleOpen" class="calc-btn-action ispro-wrapper success" style="pointer-events: auto !important; opacity: 1 !important;">
			<?php if ( $general_settings['form_fields']['use_in_all'] && ! empty( $general_settings['form_fields']['openModalBtnText'] ) ) { ?>
				<span><?php echo esc_html( $general_settings['form_fields']['openModalBtnText'] ); ?></span>
				<?php } else { ?>
			<span v-if="formData.openModalBtnText">{{ formData.openModalBtnText | to-short }}</span>
			<span v-else="formData.openModalBtnText"><?php esc_html_e( 'Make order', 'cost-calculator-builder-pro' ); ?></span>
			<span class="is-pro">
				<span class="pro-tooltip">
					pro
					<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
				</span>
			</span>
			<?php } ?>
		</button>
		<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
			<button class="calc-btn-action" @click="getInvoice">
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
	</div>

	<div :class="['ccb-cf-wrap', {'disabled': loader}]" v-show="canAccessOpenFormByEmail" style="position: relative">
		<div class="pro-border" style="z-index: 0 !important;"></div>
		<span class="is-pro">
			<span class="pro-tooltip">
				pro
				<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
			</span>
		</span>

		<template v-if="getSettings.formFields.contactFormId">
			<div class="ccb-contact-form7" v-show="canShowContactFormOnly" :class="{'calc-cf7-disabled': ['finish', 'show_summary'].includes(getStep)}">
				<div class="ccb-contact-form7-container" v-html="getCf7Content"></div>
				<div class="ccb-btn-container calc-buttons <?php echo ! empty( $general_settings['invoice']['emailButton'] ) && ! empty( $general_settings['invoice']['use_in_all'] ) ? esc_attr( 'pdf-enable' ) : ''; ?>" v-if="!stripe && !loader">
					<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! empty( $general_settings['invoice']['use_in_all'] ) ) : ?>
						<template v-if="getInvoiceBtnStatuses">
							<button class="calc-btn-action invoice-button ispro-wrapper" style="width: <?php echo esc_attr( empty( $general_settings['invoice']['emailButton'] ) ? '100%' : '48.5%' ); ?>" @click="getInvoice">
								<span class="ccb-ellipsis"><?php echo isset( $general_settings['invoice']['buttonText'] ) && ! empty( $general_settings['invoice']['buttonText'] ) ? esc_html( ccb_truncate_string( $general_settings['invoice']['buttonText'] ) ) : esc_html__( 'PDF Download', 'cost-calculator-builder-pro' ); ?></span>
								<div class="invoice-btn-loader"></div>
								<span class="is-pro">
									<span class="pro-tooltip">
										pro
										<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
									</span>
								</span>
							</button>

							<?php if ( ! empty( $general_settings['invoice']['emailButton'] ) ) : ?>
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
		</template>
		<div class="calc-form-wrapper" v-if="shouldHideContactFormAndPayments" style="display:flex; flex-direction: column; gap: 10px; padding-bottom: 20px;">
			<div class="ccb-order-layout" v-if="!getHideCalc" style="padding: 0 1px;">
				<template v-for="(field, index) in orderFormFieldsFront" :key="field.id">
					<component
						:is="'order-' + field.type"
						:field="field"
						class="ccb-order-field"
					>
					</component>
				</template>
			</div>
		</div>

		<div class="calc-form-wrapper" v-if="shouldHideContactFormAndPayments">
			<div class="calc-default-form">
				<div :class="{requiredterms: getRequiredMessage('terms_and_conditions_field')}" class="calc-item ccb-terms-wrapper" v-if="formData.accessTermsEmail">
					<span :class="{active: getRequiredMessage('terms_and_conditions_field')}" class="ccb-error-tip front default-terms" v-text="getRequiredMessage('terms_and_conditions_field')"></span>
					<div class="ccb-terms calc-checkbox calc-is-vertical default">
						<div class="ccb-input-wrapper ccb-terms-check calc-checkbox-item">
							<input type="checkbox" :disabled="loader" @input="clearRequired('terms_and_conditions_field')" v-model="formData.terms_and_conditions.checkbox" :id="checkTermsLabel">
							<label :for="checkTermsLabel">
								<span class="calc-checkbox-title">{{ formData.terms_and_conditions.text }}</span>
								<a class="calc-terms-link" :href="formData.terms_and_conditions.link" target="_blank">{{ formData.terms_and_conditions.link_text }} <i class="ccb-icon-click-out"></i></a>
							</label>
						</div>
					</div>
				</div>
				<div :id="getSettings.calc_id" class="g-rec" v-if="getSettings.recaptcha.enable"></div>

				<div v-if="loader" style="position: relative; min-height: 50px">
					<loader-wrapper :form="true" :idx="getPreloaderIdx" width="60px" height="60px" scale="0.8" :front="true"></loader-wrapper>
				</div>
				<div class="ccb-btn-container calc-buttons <?php echo $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ? esc_attr( 'pdf-enable' ) : ''; ?> <?php echo $general_settings['invoice']['use_in_all'] && ! $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] ? esc_attr( 'no-quote-button' ) : ''; ?>" v-else-if="!stripe && !loader">
					<?php do_action( 'ccb_contact_form_submit_action', $settings ); ?>
					<button class="calc-btn-action ispro-wrapper success <?php echo esc_attr( apply_filters( 'ccb_contact_form_submit_class', '', $settings ) ); ?>" :disabled="loader" @click.prevent="sendData">
						<?php if ( $general_settings['form_fields']['use_in_all'] && ! empty( $general_settings['form_fields']['submitBtnText'] ) ) { ?>
							<span><?php echo esc_html( $general_settings['form_fields']['submitBtnText'] ); ?></span>
							<?php } else { ?>
						<span v-if="formData.summary_display.enable">{{ formData.summary_display?.submit_btn_text | to-short }}</span>
						<span v-else-if="formData.submitBtnText">{{ formData.submitBtnText | to-short }}</span>
						<span v-else><?php esc_html_e( 'Submit order', 'cost-calculator-builder-pro' ); ?></span>
						<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
						<?php } ?>
					</button>

					<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! empty( $general_settings['invoice']['use_in_all'] ) ) : ?>
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

							<?php if ( ! empty( $general_settings['invoice']['emailButton'] ) ) : ?>
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
		<form-payments v-if="showPayments"></form-payments>
	</div>
</div>
