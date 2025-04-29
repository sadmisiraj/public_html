<div class="ccb-grid-box share-quote-form">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title email-quote-preview"><?php esc_html_e( 'Share Quote Form', 'cost-calculator-builder-pro' ); ?>
					<div class="ccb-preview">
						<span class="ccb-preview__title">
							<?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?>
							<div class="ccb-preview__wrapper">
								<div class="ccb-preview__img" style="background-image: url('<?php echo esc_attr( CALC_URL . '/images/send-email.jpg' ); ?>')"></div>
							</div>
						</span>
					</div>
				</span>
				<span class="ccb-tab-subtitle"><?php esc_html_e( 'Allow customers to send their ready quote via email to others. This feature requires PDF Entries to work.', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.invoice.emailButton"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable Share Quote Button', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-15" v-if="!this.$store.getters.getPdfManager.options.use_in_all && generalSettings.invoice.emailButton">
			<div class="col">
				<div class="ccb-warn-row share-quote-form-warn">
					<span class="ccb-icon-Path-3367 ccb-warn-sign"></span>
					<span class="ccb-warn-text"><?php esc_html_e( 'Important! PDF Entries must be set up and enabled.', 'cost-calculator-builder-pro' ); ?> <a @click="tab = 'invoice'"><?php esc_html_e( 'Go to PDF Entries', 'cost-calculator-builder-pro' ); ?></a></span>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" v-if="generalSettings.invoice.emailButton">
			<div class="row ccb-p-t-15">
			<div class="col col-4">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Open Form Button Text', 'cost-calculator-builder-pro' ); ?></span>
					<span class="ccb-required-mark">*</span>
					<input type="text" v-model="generalSettings.invoice.btnText" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
				</div>
				</div>
				<div class="col col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Submit Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.invoice.submitBtnText" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Close Form Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.invoice.closeBtn" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col col-8">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Share Quote Success Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.invoice.successText" placeholder="<?php esc_attr_e( 'Enter success text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col col-8">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Share Quote Error Text', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-required-mark">*</span>
						<input type="text" v-model="generalSettings.invoice.errorText" placeholder="<?php esc_attr_e( 'Enter error text', 'cost-calculator-builder-pro' ); ?>">
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
