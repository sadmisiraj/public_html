<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Date picker', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="saveField"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-edit-field-switch">
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
							<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
						</div>
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'settings'}" @click="tab = 'settings'">
							<?php esc_html_e( 'Settings', 'cost-calculator-builder-pro' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'main'">
			<div class="row ccb-p-t-15">
				<div class="col">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Placeholder', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.placeholder" placeholder="<?php esc_attr_e( 'Enter field placeholder', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15 vertical-center">
				<div class="col-6">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Calendar Option', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="dateField.range">
								<option value="1"><?php esc_html_e( 'With range', 'cost-calculator-builder-pro' ); ?></option>
								<option value="0"><?php esc_html_e( 'No range', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-6 ccb-p-t-20">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.day_price_enabled"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculate cost per day', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-m-t-20 ccb-p-l-15 ccb-p-r-15" :class="{'d-none': !dateField.day_price_enabled}">
				<div class="col-12 ccb-col-active d-inline-flex flex-wrap align-items-center ccb-p-b-20 ccb-p-t-15">
					<div class="col-6 px-lg-0 ccb-p-r-15">
						<div class="ccb-input-wrapper number">
							<span class="ccb-input-label"><?php esc_html_e( 'Value (cost) of each day', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box">
								<input type="text" class="ccb-heading-5 ccb-light" name="day_price" min="0" step="1" @input="errors.day_price=false" v-model="dateField.day_price" placeholder="<?php esc_attr_e( 'Enter Value', 'cost-calculator-builder-pro' ); ?>">
								<span @click="numberCounterAction('day_price')" class="input-number-counter up"></span>
								<span @click="numberCounterAction('day_price', '-')" class="input-number-counter down"></span>
							</div>
							<span class="ccb-error-tip default" v-if="isObjectHasPath(errors, ['day_price'] ) && errors.unit" v-html="errors.day_price"></span>
						</div>
					</div>
					<div class="col-6 ccb-p-t-20">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="dateField.allowCurrency"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Currency Sign', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-12 px-lg-0 ccb-p-t-15">
						<div class="ccb-input-wrapper flex-column d-flex">
							<div class="ccb-input-box">
								<div class="ccb-checkbox-box" style="cursor: pointer;">
									<input :checked="dateField.calculate_unselectable_days" @change="() => toggleCalculateUnselectableDays()" type="checkbox"/>
									<span @click="() => toggleCalculateUnselectableDays()">
										<?php esc_html_e( 'Calculate unselectable days', 'cost-calculator-builder-pro' ); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15 vertical-center">
				<div class="col-12 ccb-p-t-20">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.is_have_unselectable"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5">
							<?php esc_html_e( 'Make some days unselectable', 'cost-calculator-builder-pro' ); ?>
						</h6>
						<span class="ccb-help-tip-block">
							<i class="ccb-circle-question-icon"></i>
							<span class="ccb-help left-20 date-picker">
								<span class="ccb-help-tip ccb-default-title">
									<span><?php esc_attr_e( 'The setting allows the disabling ', 'cost-calculator-builder-pro' ); ?></span>
									<span><?php esc_attr_e( 'of specific days or date ranges in the calendar', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</span>
						</span>
					</div>
				</div>
			</div>
			<div class="row ccb-m-t-20 ccb-p-l-15 ccb-p-r-15" v-if="dateField.is_have_unselectable" :class="{'d-none': !dateField.is_have_unselectable}">
				<div class="col-12 ccb-col-danger d-flex flex-column align-items-center ccb-p-b-20 ccb-p-t-15">
					<div class="col-12 px-lg-0 ccb-p-r-15 ccb-p-b-15 border-bottom">
						<div class="ccb-input-wrapper flex-column d-flex">
							<span class="ccb-block-label"><?php esc_html_e( 'Block every', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box d-flex">
								<div v-if="weekdays.length > 0" class="ccb-checkbox-box" v-for="(weekTitle, weekDayIndex) in weekdays" style="cursor: pointer;">
									<input :checked="( dateField.hasOwnProperty('not_allowed_week_days') && dateField.not_allowed_week_days.length > 0 && dateField.not_allowed_week_days.includes(weekDayIndex+1) )"
										@change="setNotAllowedWeekDays(weekDayIndex+1)"
										type="checkbox"/>
									<span @click="setNotAllowedWeekDays(weekDayIndex+1)">{{ weekTitle }}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 px-lg-0 ccb-p-r-15 ccb-p-t-15 ccb-p-b-15 border-bottom">
						<div class="ccb-input-wrapper flex-column d-flex">
							<span class="ccb-block-label"><?php esc_html_e( 'Block days relative to current day', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box d-flex ccb-input-box-overflow-unset">
								<div class="ccb-checkbox-box small-font" style="cursor:pointer" @click="dateField.not_allowed_dates.all_past=!dateField.not_allowed_dates.all_past">
									<input type="checkbox" v-model="dateField.not_allowed_dates.all_past"/>
									<?php esc_attr_e( 'All previous', 'cost-calculator-builder-pro' ); ?>
								</div>
								<div class="ccb-checkbox-box small-font" style="cursor:pointer" @click="dateField.not_allowed_dates.current=!dateField.not_allowed_dates.current">
									<input type="checkbox" v-model="dateField.not_allowed_dates.current" />
									<?php esc_attr_e( 'Current day', 'cost-calculator-builder-pro' ); ?>
									<span class="ccb-help-tip-block">
										<i class="ccb-circle-question-icon"></i>
										<span class="ccb-help date-picker">
											<span class="ccb-help-tip ccb-default-title">
												<span>
													<?php esc_attr_e( 'The day when visitor uses calculator', 'cost-calculator-builder-pro' ); ?>
												</span>
											</span>
										</span>
									</span>
								</div>
							</div>
							<div class="ccb-combined-input-box d-inline-flex ccb-p-t-20 align-items-center">
								<?php esc_attr_e( 'Next', 'cost-calculator-builder-pro' ); ?>
								<div class="ccb-input-box ccb-input-box-overflow-unset">
									<input type="text" class="ccb-heading-5 ccb-light" name="days_from_current" step="1" min="0" v-model="dateField.days_from_current" @input="validate" />
									<span @click="numberCounterAction('days_from_current')" class="input-number-counter up"></span>
									<span @click="numberCounterAction('days_from_current', '-')" class="input-number-counter down"></span>
									<span v-if="errors.hasOwnProperty('days_from_current') && errors.days_from_current == true" class="ccb-error-tip default">
										<?php esc_attr_e( 'This field is required', 'cost-calculator-builder-pro' ); ?>
									</span>
								</div>
								<?php esc_attr_e( 'days from current day', 'cost-calculator-builder-pro' ); ?>
							</div>
						</div>
					</div>

					<div class="col-12 px-lg-0 ccb-p-t-15 ccb-p-b-15" style="padding-right: 0 !important;">
						<div class="ccb-input-wrapper flex-column d-flex">
							<span class="ccb-block-label"><?php esc_html_e( 'Block a period', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-input-box ccb-custom-date ccb-options-container">
								<div class="ccb-options">
									<div class="ccb-options-item" v-for="(period, index) in getPeriods">
										<div class="ccb-option" style="padding: 5px; width: 90%">
											<div class="ccb-option-inner" style="width: 100%">
												<custom-date-calendar @set-not-allowed-dates="setNotAllowedDates" :dates="dateField.not_allowed_dates" :alias="dateField.alias" :index="index" :key="updateKey"></custom-date-calendar>
											</div>
										</div>
										<div class="ccb-option-delete" style="right: -30px;" @click="() => removePeriod(index)">
											<i style="cursor: pointer" class="ccb-icon-Trash-filled"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="ccb-date-picker-action">
								<button class="ccb-button success" style="height: 40px" @click.prevent="addNewPeriod">
									<i class="ccb-icon-Path-3453"></i>
									<?php esc_html_e( 'Add new period', 'cost-calculator-builder-pro' ); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'settings'">
			<div class="row ccb-p-t-10">
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.required"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(dateField)">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.hidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(dateField)">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.calculateHidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculate hidden by default', 'cost-calculator-builder' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.addToSummary"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.autoclose_enabled"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable Auto-close', 'cost-calculator-builder-pro' ); ?></h6>
						<span class="ccb-help-tip-block">
							<i class="ccb-circle-question-icon"></i>
							<span class="ccb-help left-20 date-picker">
								<span class="ccb-help-tip ccb-default-title">
									<span><?php esc_attr_e( 'Date picker will close ', 'cost-calculator-builder-pro' ); ?></span>
									<span><?php esc_attr_e( 'automatically when', 'cost-calculator-builder-pro' ); ?></span>
									<span><?php esc_attr_e( 'a date is selected', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</span>
						</span>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.fieldCurrency"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Add a measuring unit', 'cost-calculator-builder' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row row-currency" :class="{'disabled': !dateField.fieldCurrency}">
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
						<textarea class="ccb-heading-5 ccb-light" v-model="dateField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
