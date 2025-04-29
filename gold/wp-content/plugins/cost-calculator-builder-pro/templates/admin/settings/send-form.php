<div class="ccb-grid-box order-form-wrapper" v-if="showContactForm">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Order Form', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="row ccb-p-t-20 ccb-p-t-10">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="settingsField.formFields.accessEmail"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable Order Form', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20" v-if="isErrorTab('send-form-notify')">
			<div class="col">
				<div class="ccb-warn-row">
					<span class="ccb-icon-Path-3367 ccb-warn-sign"></span>
					<span class="ccb-warn-text"><?php esc_html_e( 'Important! Order form may not work correctly if all required fields are not filled in. Please double-check that every field is filled in to avoid issues.', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" v-if="settingsField.formFields.accessEmail">
			<div class="row ccb-p-t-15" v-if="extended">
				<div class="col-12">
					<div class="ccb-extended-general">
						<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to Settings → Email and turn off the setting “Apply for all calculators”', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-action">
							<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=email' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="ccb-p-t-20">
				<div class="row">
					<div class="col col-4 ccb-m-t-15">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Form Provider', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="settingsField.formFields.formType">
									<option value="cost-calculator" selected><?php esc_html_e( 'Cost Calculator', 'cost-calculator-builder-pro' ); ?></option>
									<option value="contact-form"><?php esc_html_e( 'Contact Form', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col col-4 ccb-m-t-15 ccb-forms-list-wrapper">
						<div class="ccb-select-box ccb-forms-list" >
							<span class="ccb-select-label"><?php esc_html_e( 'Forms', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-if="settingsField.formFields.formType === 'contact-form'" v-model="settingsField.formFields.contactFormId">
									<option v-for="(value, index) in $store.getters.getForms" :key="index" :value="value['id']">{{ value['title'] }}</option>
								</select>
								<select v-if="settingsField.formFields.formType === 'cost-calculator'" style="padding-right: 34px;" class="ccb-select" v-model="settingsField.formFields.applyFormId">
									<option v-for="(value, index) in $store.getters.getFormsExisting" :key="index" :value="value['id']">{{ value['name'] }}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col col-3">
						<div class="ccb-form-manager-link" v-if="settingsField.formFields.formType === 'cost-calculator'">
							<button class="ccb-buttom embed" @click="tab='form-manager'"><?php esc_html_e( 'Order Form Manager', 'cost-calculator-builder-pro' ); ?></button>
						</div>
					</div>
				</div>
				<div class="row" v-if="settingsField.formFields.formType === 'cost-calculator'">
					<div class="col col-4 ccb-m-t-15" :class="{disabled: extended}">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Open Form Button Text', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-required-mark">*</span>
							<input type="text" v-model="settingsField.formFields.openModalBtnText" maxlength="70" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col col-4 ccb-m-t-15" :class="{disabled: extended}">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Submit Button Text', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-required-mark">*</span>
							<input type="text" v-model="settingsField.formFields.submitBtnText" maxlength="70" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<template v-if="settingsField.formFields.formType === 'cost-calculator'">
					<?php do_action( 'ccb_contact_form_settings_add_email_fields' ); ?>
					<div class="row">
						<div class="col col-12" :class="{disabled: extended}">
							<span class="ccb-tab-title order-notification-email"><?php esc_html_e( 'Order Notification Email', 'cost-calculator-builder-pro' ); ?></span>
						</div>
					</div>
					<div class="row order-form-subject-row">
						<div class="col-8" :class="{disabled: extended}">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Subject', 'cost-calculator-builder-pro' ); ?></span>
								<span class="ccb-required-mark">*</span>
								<input type="text" v-model="settingsField.formFields.emailSubject" placeholder="<?php esc_attr_e( 'Enter subject', 'cost-calculator-builder-pro' ); ?>">
							</div>
						</div>
						<div class="col col-4" :class="{disabled: extended}" style="padding-top: 25px">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="settingsField.formFields.order_id_in_subject"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-5"><?php esc_html_e( 'Add an order ID to subject line', 'cost-calculator-builder-pro' ); ?></h6>
							</div>
						</div>
					</div>
				</template>
			</div>

			<div class="ccb-m-t-20" v-if="settingsField.formFields.formType === 'cost-calculator'">
				<h6 class="ccb-heading-5 send-email-heading" :class="{disabled: extended}" style="font-size: 12px !important;font-weight: 700"><?php esc_html_e( 'Send Email To Address', 'cost-calculator-builder-pro' ); ?>
					<span class="ccb-required-mark" style="font-weight: 400; font-size: 16px;">*</span>
				</h6>
				<div class="row">
					<div class="col-12" :class="{disabled: extended}">
						<div class="ccb-options-container">
						<div class="ccb-options">
							<div class="ccb-option order-form-main-email" style="padding:3px 0px !important;">
								<div class="col col-3" :class="{disabled: extended}" style="padding:0 10px !important;">
									<div class="ccb-input-wrapper">
										<input type="email" v-model="settingsField.formFields.adminEmailAddress" placeholder="<?php esc_attr_e( 'Enter your email', 'cost-calculator-builder-pro' ); ?>">
									</div>
								</div>
								<div class="ccb-option-inner" style="width: 65%;">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" placeholder="<?php esc_attr_e( 'Main email', 'cost-calculator-builder' ); ?>" disabled>
									</div>
								</div>
							</div>
							<div class="ccb-option" v-if="!extended" style="padding:3px 0px 3px 0px!important;" v-for="(option, index) in settingsField.emailOptions" :key="index" >
								<div class="ccb-option-delete" @click.prevent="removeOption(index)">
									<i class="ccb-icon-close"></i>
								</div>
								<div class="ccb-option-inner col-3" style="padding: 0px 10px">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" v-model="option.adminEmailAddress" placeholder="<?php esc_attr_e( 'Enter your email', 'cost-calculator-builder' ); ?>">
									</div>
								</div>
								<div class="ccb-option-inner" style="width: 65%;">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" v-model="option.emailDescription" placeholder="<?php esc_attr_e( 'Description', 'cost-calculator-builder' ); ?>">
									</div>
								</div>
							</div>
							<div class="ccb-option" v-if="extended" style="padding:3px 0px 3px 0px!important;" v-for="(option, index) in generalSettings.emailOptions" :key="index" >
								<div class="ccb-option-delete" @click.prevent="removeOption(index)" :class="{disabled: Object.keys(generalSettings.emailOptions).length === 1}">
									<i class="ccb-icon-close"></i>
								</div>
								<div class="ccb-option-inner col-3" style="padding: 0px 10px">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" v-model="option.adminEmailAddress" placeholder="<?php esc_attr_e( 'Enter your email', 'cost-calculator-builder' ); ?>">
									</div>
								</div>
								<div class="ccb-option-inner" style="width: 65%;">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" v-model="option.emailDescription" placeholder="<?php esc_attr_e( 'Description', 'cost-calculator-builder' ); ?>">
									</div>
								</div>
							</div>
						</div>
						</div>
						<div class="ccb-option-actions">
							<button class="ccb-button light" @click.prevent="addOption" style="padding: 12px 20px;">
								<i class="ccb-icon-Path-3453"></i>
								<?php esc_html_e( 'Add New Address', 'cost-calculator-builder' ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15" v-if="settingsField.formFields.formType === 'contact-form'">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Contact Form Content', 'cost-calculator-builder-pro' ); ?></span>
						<textarea v-model="settingsField.formFields.body" placeholder="<?php esc_attr_e( 'Enter content', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
					<span class="ccb-field-description">[ccb-total-0] <?php esc_html_e( 'will be changed into total', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="col col-4" :class="{disabled: extended}" style="padding-top: 25px">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="settingsField.formFields.order_id_in_subject"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Add an order ID to subject line', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="row">
					<div class="col col-4 ccb-m-t-15" :class="{disabled: generalSettings.form_fields.use_in_all}">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Open Form Button Text', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-required-mark">*</span>
							<input type="text" v-model="settingsField.formFields.openModalBtnText" maxlength="80" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
			</div>

			<div class="ccb-m-t-15 ccb-terms-cond-wrapper" v-if="settingsField.formFields.formType === 'cost-calculator'">
				<div class="row">
					<div class="col col-12" :class="{disabled: settingsField.page_break.total_in_page}">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.formFields.summary_display.enable"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show Summary with calculations after adding contact info', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="displaySummaryExtended">
					<div class="col-12">
						<div class="ccb-extended-general">
							<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to Settings → Email and turn off the setting “Show Summary with calculations after adding contact info”', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-extended-general-action">
								<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=email' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
							</span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="settingsField.formFields.summary_display.enable" :class="{'ccb-settings-disabled': displaySummaryExtended}">
					<div class="row" v-if="isErrorTab('summary')">
						<div class="col">
							<div class="ccb-warn-row">
								<span class="ccb-icon-Path-3367 ccb-warn-sign"></span>
								<span class="ccb-warn-text"><?php esc_html_e( 'This setting may not work properly if all necessary aren’t filled out. You can avoid errors by turning it off.', 'cost-calculator-builder-pro' ); ?></span>
							</div>
						</div>
					</div>
					<div class="col col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Contact info form title', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-if="!extended || !generalSettings.form_fields.summary_display.use_in_all" v-model="settingsField.formFields.summary_display.form_title" placeholder="<?php esc_attr_e( 'Enter title here', 'cost-calculator-builder-pro' ); ?>">
							<input type="text" v-if="extended && generalSettings.form_fields.summary_display.use_in_all" v-model="generalSettings.form_fields.summary_display.form_title" placeholder="<?php esc_attr_e( 'Enter title here', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Submit button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-if="!extended || !generalSettings.form_fields.summary_display.use_in_all" v-model="settingsField.formFields.summary_display.submit_btn_text" placeholder="<?php esc_attr_e( 'Enter text here', 'cost-calculator-builder-pro' ); ?>">
							<input type="text" v-if="extended && generalSettings.form_fields.summary_display.use_in_all" v-model="generalSettings.form_fields.summary_display.submit_btn_text" placeholder="<?php esc_attr_e( 'Enter text here', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col-12 ccb-p-t-15">
						<span class="ccb-field-title"><?php esc_html_e( 'Action options after submitting the form', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-radio-wrapper" style="margin-top: 5px; flex-direction: column; row-gap: 10px">
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;">
									<input type="radio" v-model="settingsField.formFields.summary_display.action_after_submit" name="action_after_submit" value="send_to_email" checked>
									<span class="ccb-heading-5"><?php esc_html_e( 'Send a quote and invoice to customer\'s email', 'cost-calculator-builder-pro' ); ?></span>
								</label>
							</div>
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;">
									<input type="radio" v-model="settingsField.formFields.summary_display.action_after_submit" name="action_after_submit" value="show_summary_block">
									<span class="ccb-heading-5"><?php esc_html_e( 'Show calculations on Summary block', 'cost-calculator-builder-pro' ); ?></span>
								</label>
							</div>
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;" :class="{'ccb-label-disabled': !generalSettings.invoice.use_in_all}">
									<input type="radio" :class="{'ccb-label-disabled': !generalSettings.invoice.use_in_all}" v-model="settingsField.formFields.summary_display.action_after_submit" name="action_after_submit" value="show_summary_block_with_pdf">
									<span class="ccb-heading-5"><?php esc_html_e( 'Show calculations with buttons to download PDF and share quotes on Summary block', 'cost-calculator-builder-pro' ); ?></span>
								</label>
								<span class="ccb-options-tooltip" style="display: flex; justify-content: flex-start; align-items: center" @click.prevent>
									<i class="ccb-icon-circle-question" style="margin: 0"></i>
									<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Turn on "PDF Entries" and "Email Quote Button" in the Global Settings for this to work. Go to Global Settings', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="ccb-m-t-15 ccb-terms-cond-wrapper" v-if="settingsField.formFields.formType === 'cost-calculator'">
				<div class="row">
					<div class="col col-6">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.formFields.accessTermsEmail"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5 terms-condition-preview"><?php esc_html_e( 'Enable Terms & Conditions Agreement', 'cost-calculator-builder-pro' ); ?>
								<div class="ccb-preview">
									<span class="ccb-preview__title">
										<?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?>
										<div class="ccb-preview__wrapper">
											<div class="ccb-preview__img" style="background-image: url('<?php echo esc_attr( CALC_URL . '/images/terms-and-conditions.jpg' ); ?>')"></div>
										</div>
									</span>
								</div>
							</h6>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="termsExtended">
					<div class="col-12">
						<div class="ccb-extended-general">
							<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to Settings → Email and turn off the setting “Enable Terms & Conditions Agreement”', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-extended-general-action">
								<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=email' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
							</span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="settingsField.formFields.accessTermsEmail" :class="{'ccb-settings-disabled': termsExtended}">
					<div class="col col-3">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Checkbox Label', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" maxlength="40" v-if="!extended || !generalSettings.form_fields.terms_use_in_all" v-model="settingsField.formFields.terms_and_conditions.text" placeholder="<?php esc_attr_e( 'Enter label', 'cost-calculator-builder-pro' ); ?>">
							<input type="text" maxlength="40" v-if="extended && generalSettings.form_fields.terms_use_in_all" v-model="generalSettings.form_fields.terms_and_conditions.text" placeholder="<?php esc_attr_e( 'Enter label', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col col-3">
						<div class="ccb-select-box">
							<span class="ccb-select-label">
								<?php esc_html_e( 'Choose Page to Link', 'cost-calculator-builder-pro' ); ?>
							</span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="settingsField.formFields.terms_and_conditions.page_id">
									<option value="" selected><?php esc_html_e( 'Select page', 'cost-calculator-builder-pro' ); ?></option>
									<option :value="page.id" :title="page.tooltip" v-for="page in $store.getters.getPages">{{ page.title }}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col col-3">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Linked Page Title', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" maxlength="20" v-if="!extended || !generalSettings.form_fields.terms_use_in_all" v-model="settingsField.formFields.terms_and_conditions.link_text" placeholder="<?php esc_attr_e( 'Enter title', 'cost-calculator-builder-pro' ); ?>">
							<input type="text" maxlength="20" v-if="extended && generalSettings.form_fields.terms_use_in_all" v-model="generalSettings.form_fields.terms_and_conditions.link_text" placeholder="<?php esc_attr_e( 'Enter title', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row" v-if="settingsField.formFields.accessTermsEmail">
					<div class="col-3">
						<span class="ccb-terms-span-desc"><?php esc_html_e( 'Enter no more than 40 symbols in this field' ); ?></span>
					</div>
					<div class="col-3"></div>
					<div class="col-3">
						<span class="ccb-terms-span-desc"><?php esc_html_e( 'Enter no more than 20 symbols in this field' ); ?></span>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-20">
				<div class="col-12">
					<div class="ccb-captcha-wrapper">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.recaptcha.enable"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Captcha by Google to prevent bots', 'cost-calculator-builder-pro' ); ?><span style="opacity: 0.5"> (Optional)</span></h6>
						</div>

						<div class="captcha-extended" v-if="settingsField.recaptcha.enable && getCaptchaInfo" style="margin-top: 20px">
							<div class="captcha-extended__icon-box">
								<i class="ccb-icon-Path-3484"></i>
							</div>
							<div class="captcha-extended__text-box">
								<span class="captcha-extended__title"><?php esc_html_e( 'Captcha key has been applied from Global settings.', 'cost-calculator-builder-pro' ); ?></span>
								<a class="captcha-extended__link" target="_blank" href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=captcha' ); ?>"><?php esc_html_e( 'Captcha setting', 'cost-calculator-builder-pro' ); ?></a>
							</div>
						</div>
						<div class="captcha-extended warning" v-if="settingsField.recaptcha.enable && !getCaptchaInfo" style="margin-top: 20px">
							<div class="captcha-extended__icon-box">
								<i class="ccb-icon-Path-3367"></i>
							</div>
							<div class="captcha-extended__text-box">
								<span class="captcha-extended__title"><?php esc_html_e( 'It works only if you add Recaptcha key to Global settings', 'cost-calculator-builder-pro' ); ?></span>
								<a class="captcha-extended__link" target="_blank" href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=captcha' ); ?>"><?php esc_html_e( 'Add Captcha key', 'cost-calculator-builder-pro' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15">
				<div class="col-9">
					<span class="ccb-field-title">
						<?php esc_html_e( 'Total Field Element', 'cost-calculator-builder-pro' ); ?>
					</span>
					<span class="ccb-field-totals">
						<label class="ccb-field-totals-item ccb-default-title" v-for="formula in getFormulaFields" :for="'contact_' + formula.idx">{{ formula.title | to-short-description }}</label>
					</span>
					<span class="ccb-multiselect-overlay"></span>
					<div class="ccb-select-box" style="position: relative">
						<div class="multiselect">
							<span v-if="formulas.length > 0" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click="multiselectShow(event)" style="padding-right: 25px">
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
							<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)" >
								<?php esc_html_e( 'Select totals', 'cost-calculator-builder-pro' ); ?>
							</span>
							<input name="options" type="hidden" />
						</div>
						<ul class="items row-list settings-list totals custom-list" style="max-width: 100% !important; left: 0; right: 0;">
							<li class="option-item settings-item" v-for="formula in getFormulaFields" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}" @click="(e) => autoSelect(e, formula)">
								<input :id="'contact_' + formula.idx" :checked="getTotalsIdx.includes(+formula.idx)" name="contactTotals" class="index" type="checkbox" @change="multiselectChooseTotals(formula)"/>
								<label :for="'contact_' + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ccb-grid-box">
	<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !settingsField.formFields.accessEmail}">
		<div class="container">
			<div class="row ccb-p-t-15">
				<div class="col">
					<span class="ccb-tab-title"><?php esc_html_e( 'Payment Gateways', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
			<div class="row ccb-p-t-20">
				<div class="col">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="settingsField.formFields.payment"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Payment gateways', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20" v-if="settingsField.formFields.payment">
				<div class="col-12">
					<div class="ccb-payments-getaway">
						<div class="ccb-field-title"><?php esc_html_e( 'Payment gateways', 'cost-calculator-builder-pro' ); ?></div>
						<div class="ccb-payments">
							<label class="ccb-checkboxes" v-for="payment in getPayments" :key="payment.slug" :class="{disabled: payment.disabled}">
								<input type="checkbox" :checked="!payment.disabled && getValues.includes(payment.slug)" @change="toggleGateways" :value="payment.slug">
								<span class="ccb-checkboxes-label">{{ payment.name }}</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
