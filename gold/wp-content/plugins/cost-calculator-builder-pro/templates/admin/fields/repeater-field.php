<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Repeater', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save(repeaterField, id, index, repeaterField.alias)"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>

	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Repeater name', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="repeaterField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20">
				<div class="col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( '"Add" button label', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="repeaterField.addButtonLabel" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( '"Remove" button label', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="repeaterField.removeButtonLabel" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col-4">
					<div class="ccb-input-wrapper number">
						<span class="ccb-input-label"><?php esc_html_e( 'Repeat limit', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-input-box">
							<input type="text" class="ccb-heading-5 ccb-light" name="repeatCount" min="0" step="1"  @keypress="repeatMinValue" v-model="repeaterField.repeatCount" placeholder="<?php esc_attr_e( 'Enter field step', 'cost-calculator-builder-pro' ); ?>">
							<span @click="numberCounterAction('repeatCount')" class="input-number-counter up"></span>
							<span @click="numberCounterAction('repeatCount', '-')" class="input-number-counter down"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="repeaterField.sumAllAvailable" @change="() => toggleHandler('sumAllAvailable')">
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Sum up values in all fields', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="repeaterField.enableFormula" @change="() => toggleHandler('enableFormula')">
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Use formula for the repeatable group', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20" v-if="repeaterField.enableFormula">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="repeaterField.advancedJsCalculation"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Advanced calculations', 'cost-calculator-builder' ); ?></h6>
						<span class="ccb-options-tooltip">
							<i class="ccb-icon-circle-question"></i>
							<span class="ccb-options-tooltip__text"><?php esc_html_e( 'Enable for advanced calculations using JavaScript-based formulas. With over 9 totals, performance may slow. Disable for faster basic calculations.' ); ?></span>
						</span>
					</div>
				</div>
			</div>
			<div v-if="repeaterField.enableFormula">
				<div class="row ccb-p-t-20" v-if="errorMessage.length > 0">
					<div class="col-12">
						<div class="ccb-formula-message-errors">
							<p class="ccb-formula-error-message" v-for="(item) in errorMessage">
								{{ item.message }}
							</p>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-20" v-if="openFormula">
					<div class="col-12">
						<formula-field @change="change" @error="setErrors" :id="repeaterField._id" v-model="costCalcLetterFormula" :available_fields="available_fields"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
