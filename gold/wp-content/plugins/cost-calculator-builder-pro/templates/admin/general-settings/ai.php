<div class="ccb-grid-box captcha">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'AI', 'cost-calculator-builder-pro' ); ?></span>
				<span class="ccb-tab-subtitle"><?php printf('%s <a target="_blank" href="https://docs.stylemixthemes.com/cost-calculator-builder/cost-calculator-settings/global-settings/ai-formula">%s</a>', __( 'How to get an API Key?', 'cost-calculator-builder-pro' ), __( 'Learn more', 'cost-calculator-builder-pro' ) ); // phpcs:ignore ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col col-4" style="padding-right: 8px !important; padding-left: 8px !important;">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'GPT API Key', 'cost-calculator-builder-pro' ); ?></span>
					<input type="text" v-model="generalSettings.ai.gpt_api_key" placeholder="<?php esc_attr_e( 'Enter an API key', 'cost-calculator-builder-pro' ); ?>">
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
