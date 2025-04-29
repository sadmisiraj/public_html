<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Page breaker', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save(pageBreakField, id, index, pageBreakField.alias)"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Page name', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="pageBreakField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( '“Previous”  button label', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="pageBreakField.previousBtnLabel" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col-6">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( '“Next” button label', 'cost-calculator-builder-pro' ); ?></span>
						<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="pageBreakField.nextBtnLabel" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>

			<div class="col-6 ccb-p-t-15">
				<div class="ccb-select-box">
					<span class="ccb-select-label"><?php esc_html_e( 'Page box style', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select class="ccb-select" v-model="pageBreakField.boxStyle">
							<option value="vertical"><?php esc_html_e( 'Full Width', 'cost-calculator-builder-pro' ); ?></option>
							<option value="horizontal"><?php esc_html_e( '2 columns', 'cost-calculator-builder-pro' ); ?></option>
						</select>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15" v-if="toggleTwoColumnsSetting">
				<div class="col-12">
					<div class="ccb-warn-row row-notice">
						<?php esc_html_e( 'Since "Show Summary on the last page of multi-step calculator" is enabled in the Page Breaker settings, the "2 columns" style won\'t work, and it will switch to "Full Width"', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="page-break-condition-title">
						<span class="ccb-edit-field-title ccb-heading-5 ccb-bold"><?php esc_html_e( 'Conditions', 'cost-calculator-builder-pro' ); ?></span>
						<span class="border"></span>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-20">
				<div class="col-12">
					<div class="page-break-row">
						<span class="ccb-edit-field-title ccb-heading-5 ccb-bold"><?php esc_html_e( 'If', 'cost-calculator-builder-pro' ); ?></span>

						<div class="ccb-select-box">
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="pageBreakField.condition" style="text-indent: 0px;">
									<option value="any"><?php esc_html_e( 'Any', 'cost-calculator-builder-pro' ); ?></option>
									<option value="and"><?php esc_html_e( 'All', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>

						<span class="ccb-edit-field-title ccb-heading-5 ccb-bold"><?php esc_html_e( 'of the following match:', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
			</div>


			<div class="row ccb-p-t-15">
				<div class="col-12 page-break-conditions">
					<div class="ccb-options-container radio">
						<div class="ccb-options-header" v-if="conditions.length">
							<span><?php esc_html_e( 'Element', 'cost-calculator-builder' ); ?></span>
							<span><?php esc_html_e( 'Condition', 'cost-calculator-builder' ); ?></span>
							<span><?php esc_html_e( 'Value', 'cost-calculator-builder' ); ?></span>
						</div>
						<draggable
							v-model="conditions"
							class="ccb-options"
							draggable=".ccb-option"
							:animation="200"
							handle=".ccb-option-drag"
						>
							<div class="ccb-option" v-for="(option, index) in conditions" :key="option">
								<div class="ccb-option-drag" :class="{disabled: conditions.length === 1}">
									<i class="ccb-icon-drag-dots"></i>
								</div>
								<div class="ccb-option-delete" @click.prevent="removeCondition(index, option.optionValue)">
									<i class="ccb-icon-close"></i>
								</div>
								<div class="ccb-option-inner">
									<div class="ccb-input-wrapper">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="option.field">
													<option value=""><?php esc_html_e( 'Select Element', 'cost-calculator-builder-pro' ); ?></option>
													<option :value="field.alias" v-for="field in pageFields" v-if="!field.alias.includes('time') && !field.alias.includes('date')">{{ field.label }}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="ccb-option-inner" v-if="option.field">
									<div class="ccb-input-wrapper">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="option.condition">
													<option value=""><?php esc_html_e( 'Select condition', 'cost-calculator-builder-pro' ); ?></option>
													<option :value="conditionState.value" v-if="conditionState.value !== 'in' && conditionState.value !== 'not in'" v-for="(conditionState, key) in  conditionsByElementId(option.field)">{{ conditionState.title }}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="ccb-option-inner" v-if="option.condition">
									<div class="ccb-input-wrapper" v-if="!['in', 'not in', 'contains'].includes(option.condition)">
										<div class="ccb-select-box" v-if="getConditionType(option.field) === 'select' && !['>=', '<=', '== & distance', '<= & distance', '>= & distance', '!= & distance'].includes(option.condition)">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="option.key">
													<option value=""><?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?></option>
													<option value="any"><?php esc_html_e( 'Select any', 'cost-calculator-builder' ); ?></option>
													<template v-if="option.field.includes('geolocation')">
														<option v-for="(item, key) in getFieldOptionsByFieldId(option.field)" :value="key">
															{{ item.label }}
														</option>
													</template>
													<template v-else>
														<option v-for="(item, key) in getOptionsByCond(option.field)" :value="key">
															{{ item.optionText }}
														</option>
													</template>
												</select>
											</div>
										</div>
										<input v-else type="number" v-model="option.value" placeholder="<?php esc_html_e( 'Set value', 'cost-calculator-builder' ); ?>"/>
									</div>

									<div class="ccb-input-wrapper" v-else-if="option.condition === 'contains'">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<select class="ccb-select" v-model="option.key">
													<option value=""><?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?></option>
													<option value="any"><?php esc_html_e( 'Select any', 'cost-calculator-builder' ); ?></option>
													<option v-for="(item, key) in getFieldOptionsByFieldId(option.field)" :value="key">
														{{ item.optionText }}
													</option>
												</select>
											</div>
										</div>
									</div>

									<div class="select-with-label" v-else>
										<div class="multiselect" tabindex="100" style="min-height: 38px; height: 38px; border-radius: 0 4px 4px 0; border: 0;">

											<span v-if="option.checkedValues && option.checkedValues.length" class="anchor" @click.prevent="multiselectShow(event)">
												<?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
											</span>

											<span v-else class="anchor" style="padding-left: 0;" @click.prevent="multiselectShow(event)">
												<template v-if="option.checkedValues && option.checkedValues.length > 0">
													{{ option.checkedValues.length }} <?php esc_html_e( 'option(s) selected', 'cost-calculator-builder' ); ?>
												</template>
												<template v-else>
													<?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?>
												</template>
											</span>
											<ul class="items custom-items" style="padding-top: 8px; border-top: 1px solid #dddddd; top: 38px">
												<li class="option-item" v-for="(item, optionIndex) in getFieldOptionsByFieldId(option.field)" style="margin-bottom: 10px">
													<label class="ccb-checkboxes" :key="optionIndex" style="display: flex; align-items: center">
														<input type="checkbox" v-model="option.checkedValues" :data-idx="optionIndex" :value="optionIndex" style="margin-right: 0;">
														<span class="ccb-checkboxes-label">{{ item.optionText }}</span>
														{{ console.log( option ) }}
													</label>
												</li>
											</ul>
										</div>
									</div>

								</div>
							</div>
						</draggable>
						<div class="ccb-option-actions">
							<button class="ccb-button light" @click="addConditions">
								<i class="ccb-icon-Path-3453"></i>
								<?php esc_html_e( 'Add new', 'cost-calculator-builder' ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Action', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="pageBreakField.action">
								<option value="skip"><?php esc_html_e( 'Skip next page', 'cost-calculator-builder-pro' ); ?></option>
								<option value="not_skip"><?php esc_html_e( 'Block next page', 'cost-calculator-builder-pro' ); ?></option>
								<option value="jump_to"><?php esc_html_e( 'Jump to', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-6" v-if="pageBreakField.action === 'jump_to'">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Page', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="pageBreakField.pageTo">
								<option value=""><?php esc_html_e( 'Select page', 'cost-calculator-builder-pro' ); ?></option>
								<option :value="field.alias" :title="field.label" v-for="field in jumpToPageList">{{ field.label.length > 30 ? field.label.substring(0, 27) + '...' : field.label }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
