<div class="ccb-grid-box email change-sender-email">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title email-quote-preview"><?php esc_html_e( 'Change WordPress Default Mail Sender', 'cost-calculator-builder-pro' ); ?>
					<div class="ccb-preview">
						<span class="ccb-preview__title">
							<?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?>
							<div class="ccb-preview__wrapper">
								<div class="ccb-preview__img" style="background-image: url('<?php echo esc_attr( CALC_URL . '/images/change-mail-sender.png' ); ?>')"></div>
							</div>
						</span>
					</div>
				</span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col col-4">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Sender Email', 'cost-calculator-builder-pro' ); ?></span>
					<input type="email" v-model="generalSettings.invoice.fromEmail" placeholder="<?php esc_attr_e( 'From Email', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
				</div>
			</div>
			<div class="col col-4">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Sender Name', 'cost-calculator-builder-pro' ); ?></span>
					<input type="text" v-model="generalSettings.invoice.fromName" placeholder="<?php esc_attr_e( 'From Name', 'cost-calculator-builder-pro' ); ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
<div class="ccb-grid-box email order-form-wrapper">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Order Form', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.form_fields.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-15" v-if="isErrorTab('email-notify')">
			<div class="col">
				<div class="ccb-warn-row">
					<span class="ccb-icon-Path-3367 ccb-warn-sign"></span>
					<span class="ccb-warn-text"><?php esc_html_e( 'Important! Order form may not work correctly if all required fields are not filled in. Please double-check that every field is filled in to avoid issues.', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.form_fields.use_in_all}">
			<div class="row ccb-p-t-15">
				<?php do_action( 'ccb_contact_form_general_add_email_fields' ); ?>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Open Form Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.form_fields.openModalBtnText" maxlength="70" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Submit Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.form_fields.submitBtnText" maxlength="70" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col col-12">
					<span class="ccb-tab-title order-notification-email"><?php esc_html_e( 'Order Notification Email', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
			<div class="row order-form-subject-row">
				<div class="col col-8">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Subject', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.form_fields.emailSubject" placeholder="<?php esc_attr_e( 'Enter subject', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-4 ccb-p-t-20">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="generalSettings.form_fields.order_id_in_subject"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Add an order ID to subject line', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="ccb-m-t-20">
				<h6 class="ccb-heading-5 order-form-send-email" style="font-size: 12px !important;font-weight: 700"><?php esc_html_e( 'Send Email To Address', 'cost-calculator-builder-pro' ); ?><span class="ccb-required-mark" style="font-size: 16px; font-weight: 500;">*</span></h6>
				<div class="row">
					<div class="col-12">
						<div class="ccb-options-container">
						<div class="ccb-options">
							<div class="ccb-option order-form-main-email" style="padding:3px 0px !important;">
								<div class="col col-3" style="padding:0 10px !important;">
									<div class="ccb-input-wrapper">
										<input type="email" v-model="generalSettings.form_fields.adminEmailAddress" placeholder="<?php esc_attr_e( 'Enter your email', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
									</div>
								</div>
								<div class="ccb-option-inner" style="width: 65%;">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5" placeholder="<?php esc_attr_e( 'Main email', 'cost-calculator-builder' ); ?>" disabled>
									</div>
								</div>
							</div>
							<div class="ccb-option" style="padding:3px 0px 3px 0px!important;" v-for="(option, index) in generalSettings.emailOptions" :key="index">
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
			<div class="ccb-m-t-15 ccb-terms-cond-wrapper">
				<div class="row">
					<div class="col col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="generalSettings.form_fields.summary_display.use_in_all"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show Summary with calculations after adding contact info', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="isErrorTab('summary')">
					<div class="col">
						<div class="ccb-warn-row">
							<span class="ccb-icon-Path-3367 ccb-warn-sign"></span>
							<span class="ccb-warn-text"><?php esc_html_e( 'This setting may not work properly if all necessary aren’t filled out. You can avoid errors by turning off it.', 'cost-calculator-builder-pro' ); ?></span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="generalSettings.form_fields.summary_display.use_in_all" :class="{'ccb-settings-disabled': !generalSettings.form_fields.summary_display.use_in_all}">
					<div class="col col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Contact info form title', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-required-mark">*</span>
							<input type="text" v-model="generalSettings.form_fields.summary_display.form_title" placeholder="<?php esc_attr_e( 'Enter title here', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Submit button text', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-required-mark">*</span>
							<input type="text" v-model="generalSettings.form_fields.summary_display.submit_btn_text" placeholder="<?php esc_attr_e( 'Enter text here', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col-12 ccb-p-t-15">
						<span class="ccb-field-title"><?php esc_html_e( 'Action options after submitting the form', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-radio-wrapper" style="margin-top: 5px; flex-direction: column; row-gap: 10px">
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;">
									<input type="radio" v-model="generalSettings.form_fields.summary_display.action_after_submit" name="action_after_submit" value="send_to_email" checked>
									<span class="ccb-heading-5"><?php esc_html_e( 'Send a quote and invoice to customer\'s email', 'cost-calculator-builder-pro' ); ?></span>
								</label>
							</div>
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;">
									<input type="radio" v-model="generalSettings.form_fields.summary_display.action_after_submit" name="action_after_submit" value="show_summary_block">
									<span class="ccb-heading-5"><?php esc_html_e( 'Show calculations on Summary block', 'cost-calculator-builder-pro' ); ?></span>
								</label>
							</div>
							<div class="ccb-radio-label-wrapper">
								<label style="column-gap: 10px;" :class="{'ccb-label-disabled': !generalSettings.invoice.use_in_all}">
									<input type="radio" :class="{'ccb-label-disabled': !generalSettings.invoice.use_in_all}" v-model="generalSettings.form_fields.summary_display.action_after_submit" name="action_after_submit" value="show_summary_block_with_pdf">
									<span class="ccb-heading-5"><?php esc_html_e( 'Add buttons to download PDF and share quotes on Summary block', 'cost-calculator-builder-pro' ); ?></span>
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
			<div class="ccb-m-t-15 ccb-terms-cond-wrapper">
				<div class="row">
					<div class="col col-6">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="generalSettings.form_fields.terms_use_in_all"/>
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
				<div class="row ccb-p-t-15" v-if="generalSettings.form_fields.terms_use_in_all" :class="{'ccb-settings-disabled': !generalSettings.form_fields.terms_use_in_all}">
					<div class="col col-3">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Checkbox Label', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" maxlength="40" v-model="generalSettings.form_fields.terms_and_conditions.text" placeholder="<?php esc_attr_e( 'Enter label', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col col-3">
						<div class="ccb-select-box">
							<span class="ccb-select-label">
								<?php esc_html_e( 'Choose Page to Link', 'cost-calculator-builder-pro' ); ?>
							</span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="generalSettings.form_fields.terms_and_conditions.page_id">
									<option value="" selected><?php esc_html_e( 'Select page', 'cost-calculator-builder-pro' ); ?></option>
									<option :value="page.id" :title="page.tooltip" v-for="page in $store.getters.getPagesAll">{{ page.title }}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col col-3">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Linked Page Title', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" maxlength="20" v-model="generalSettings.form_fields.terms_and_conditions.link_text" placeholder="<?php esc_attr_e( 'Enter title', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row" v-if="generalSettings.form_fields.terms_use_in_all">
					<div class="col-3">
						<span class="ccb-terms-span-desc"><?php esc_html_e( 'Enter no more than 40 symbols in this field' ); ?></span>
					</div>
					<div class="col-3"></div>
					<div class="col-3">
						<span class="ccb-terms-span-desc"><?php esc_html_e( 'Enter no more than 20 symbols in this field' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
