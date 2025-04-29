<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Multi range', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save(multiRangeField, id, index, multiRangeField.alias)"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-edit-field-switch">
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
							<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
							<span class="ccb-fields-required" v-if="errorsCount > 0">{{ errorsCount }}</span>
						</div>
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'options'}" @click="tab = 'options'">
							<?php esc_html_e( 'Settings', 'cost-calculator-builder-pro' ); ?>
						</div>
					</div>
				</div>
			</div>
			<template v-if="tab === 'main'">
				<div class="row ccb-p-t-15">
					<div class="col">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
							<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="multiRangeField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="multiRangeField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Minimum Range Value', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['minValue'] ) && errors.minValue}" name="minValue" min="0" step="1" @input="() => fixErrorByKey('minValue')" v-model="multiRangeField.minValue" placeholder="<?php esc_attr_e( 'Enter min range', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('minValue')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('minValue', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['minValue'] ) && errors.minValue" v-html="errors.minValue"></span>
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Maximum Range Value', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['maxValue'] ) && errors.maxValue}" name="maxValue" min="0" step="1" @input="() => fixErrorByKey('maxValue')" v-model="multiRangeField.maxValue" placeholder="<?php esc_attr_e( 'Enter max range', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('maxValue')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('maxValue', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['maxValue'] ) && errors.maxValue" v-html="errors.maxValue"></span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Range Step', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['step'] ) && errors.step}" name="step" min="0" step="1" @input="() => fixErrorByKey('step')" v-model="multiRangeField.step" placeholder="<?php esc_attr_e( 'Enter step', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('step')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('step', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['step'] ) && errors.step" v-html="errors.step"></span>
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Default Start Value', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['default_left'] ) && errors.default_left}" name="default_left" step="1" min="0" @input="() => fixErrorByKey('default_left')" v-model="multiRangeField.default_left" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('default_left')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('default_left', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['default_left'] ) && errors.default_left" v-html="errors.default_left"></span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Default End Value', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['default_right'] ) && errors.default_right}" name="default_right" min="0" step="1" @input="() => fixErrorByKey('default_right')" v-model="multiRangeField.default_right" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('default_right')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('default_right', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['default_right'] ) && errors.default_right" v-html="errors.default_right"></span>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="ccb-input-wrapper" :class="{ 'disabled': !multiRangeField.multiply && multiRangeField.allowCurrency || multiRangeField.fieldCurrency }">
							<span class="ccb-input-label"><?php esc_html_e( 'Name of value (kg, gr, pcs)', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" maxlength="18" class="ccb-heading-5 ccb-light" v-model.trim="multiRangeField.sign" placeholder="<?php esc_attr_e( 'Enter unit symbol', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-disable-msg" v-if="!multiRangeField.multiply && multiRangeField.allowCurrency">
							<span><?php esc_html_e( 'Currency sign is ON', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<div class="ccb-select-box" style="padding-top: 27px;" v-else>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="multiRangeField.unitPosition">
									<option value="right" selected><?php esc_html_e( 'On the right', 'cost-calculator-builder-pro' ); ?></option>
									<option value="left"><?php esc_html_e( 'On the left', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.multiply"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Multiply (cost per value)', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="multiRangeField.multiply">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-multiply">
								<span class="ccb-multiply__bg">=</span>
								<span class="ccb-multiply__bg"><?php esc_html_e( 'Selected value', 'cost-calculator-builder-pro' ); ?></span>
								<span class="ccb-multiply__icon"><i class="ccb-icon-close"></i></span>
								<div class="ccb-input-wrapper number">
									<div class="ccb-input-box">
										<input type="text" class="ccb-heading-5 ccb-light" name="unit" min="1" step="1" :class="{'ccb-input-required': isObjectHasPath(errors, ['unit'] ) && errors.unit}" v-model="multiRangeField.unit" placeholder="<?php esc_attr_e( 'Enter unit', 'cost-calculator-builder-pro' ); ?>">
										<span @click="numberCounterAction('unit')" class="input-number-counter up"></span>
										<span @click="numberCounterAction('unit', '-')" class="input-number-counter down"></span>
									</div>
									<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['unit'] ) && errors.unit" v-html="errors.unit"></span>
								</div>
								<div class="ccb-input-wrapper" style="margin-left: 10px; width: 160px;" :class="{'disabled': multiRangeField.fieldCurrency || multiRangeField.allowCurrency }">
									<input type="text" maxlength="18" class="ccb-heading-5 ccb-light" v-model.trim="multiRangeField.unitSymbol" placeholder="<?php esc_attr_e( 'Unit (kg, cm,...)', 'cost-calculator-builder-pro' ); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15" v-if="multiRangeField.multiply">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.multipliedTotal"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show multiplied value instead of subtotal', 'cost-calculator-builder-pro' ); ?></h6>
							<span class="ccb-help-tip-block" style="margin-top: 2px;">
								<span class="ccb-help-label ccb-help-label-range" ><?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?></span>
								<span class="ccb-help ccb-help-settings" style="left: -50%; bottom: 20px;">
									<span class="ccb-help-content">
										<img src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/preview/multirange.png' ); ?>" alt="Show multiplied value instead of subtotal">
									</span>
								</span>
							</span>
						</div>
					</div>
				</div>
			</template>
			<template v-else>
				<div class="row ccb-p-t-5">
					<div class="col-6 ccb-p-t-10">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.allowCurrency"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Currency Sign', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(multiRangeField)">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.hidden"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(multiRangeField)">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.calculateHidden"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculate hidden by default', 'cost-calculator-builder' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.allowRound"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Round Value', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.addToSummary"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.required"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6 ccb-p-t-10">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="multiRangeField.fieldCurrency"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Add a measuring unit', 'cost-calculator-builder' ); ?></h6>
						</div>
					</div>
				</div>
				<div class="row row-currency" :class="{'disabled': !multiRangeField.fieldCurrency}">
					<div class="col-4">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Unit Symbol', 'cost-calculator-builder' ); ?></span>
							<input type="text" maxlength="18" v-model="fieldCurrency.currency" placeholder="<?php esc_attr_e( 'Enter unit symbol', 'cost-calculator-builder' ); ?>">
						</div>
					</div>
					<div class="col-4">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Position', 'cost-calculator-builder' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="fieldCurrency.currencyPosition">
									<option value="left"><?php esc_html_e( 'Left', 'cost-calculator-builder' ); ?></option>
									<option value="right"><?php esc_html_e( 'Right', 'cost-calculator-builder' ); ?></option>
									<option value="left_with_space"><?php esc_html_e( 'Left with space', 'cost-calculator-builder' ); ?></option>
									<option value="right_with_space"><?php esc_html_e( 'Right with space', 'cost-calculator-builder' ); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Thousands separator', 'cost-calculator-builder' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="fieldCurrency.thousands_separator">
									<option value=","><?php esc_html_e( ' Comma ', 'cost-calculator-builder' ); ?></option>
									<option value="."><?php esc_html_e( ' Dot ', 'cost-calculator-builder' ); ?></option>
									<option value="'"><?php esc_html_e( ' Apostrophe ', 'cost-calculator-builder' ); ?></option>
									<option value=" "><?php esc_html_e( ' Space ', 'cost-calculator-builder' ); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Number of decimals', 'cost-calculator-builder' ); ?></span>
							<div class="ccb-input-box">
								<input type="number" name="option_num_after_integer" v-model="fieldCurrency.num_after_integer" min="1" max="8" placeholder="<?php esc_attr_e( 'Enter decimals', 'cost-calculator-builder' ); ?>">
								<span class="input-number-counter up" @click="numberCounterAction('num_after_integer')"></span>
								<span class="input-number-counter down" @click="numberCounterAction('num_after_integer', '-')"></span>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Decimal separator', 'cost-calculator-builder' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="fieldCurrency.decimal_separator">
									<option value=","><?php esc_html_e( ' Comma ', 'cost-calculator-builder' ); ?></option>
									<option value="."><?php esc_html_e( ' Dot ', 'cost-calculator-builder' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Additional Classes', 'cost-calculator-builder-pro' ); ?></span>
							<textarea class="ccb-heading-5 ccb-light" v-model="multiRangeField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>
</div>
