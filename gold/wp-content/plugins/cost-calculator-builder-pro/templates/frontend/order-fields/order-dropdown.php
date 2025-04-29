<?php
/**
 * @file
 * Order-dropdown component's template
 */
?>

<div class="ccb-order-dropdown" :class="[width, {'error': field.requiredStatus}]">
	<div class="ccb-order-dropdown__title ccb-order-field__title">
		{{ label }}
		<span class="ccb-order-required-mark" v-if="required">*</span>
	</div>
	<div class="ccb-order-dropdown__wrapper">
		<div class="ccb-drop-down">
			<div class="calc-drop-down">
				<div class="calc-drop-down-wrapper" v-if="!multiselect">
					<span :class="['calc-drop-down-with-image-current calc-dd-toggle ccb-appearance-field', {'calc-dd-selected': openList}]" @click="openListHandler">
						<span v-if='selectValue == 0' class="calc-dd-with-option-label calc-dd-toggle">
							<?php esc_html_e( 'Select value', 'cost-calculator-builder' ); ?>
						</span>
						<span v-else class="calc-dd-with-option-label calc-dd-toggle">
							{{ getLabel ? getLabel : '<?php esc_html_e( 'Select value', 'cost-calculator-builder' ); ?>' }}
						</span>
						<i :class="['ccb-icon-Path-3485 ccb-select-arrow calc-dd-toggle', {'ccb-arrow-down': !openList}]"></i>
					</span>
					<div :class="[{'calc-list-open': openList}, 'calc-drop-down-list']">
						<ul class="calc-drop-down-list-items">
							<li @click="selectOption(null)">
								<span class="calc-list-wrapper">
									<span class="calc-list-title"><?php esc_html_e( 'Select value', 'cost-calculator-builder' ); ?></span>
								</span>
							</li>
							<li v-for="element in getOptions" :key="element.value" :value="element.value" @click="selectOption(element)">
								<span class="calc-list-wrapper">
									<span class="calc-list-title">{{ element.optionText }}</span>
								</span>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-6 ccb-select-box" v-if="multiselect">
					<div class="ccb-multi-select" tabindex="100" @click.prevent="multiselectShow(event)" :class="{ 'visible': multiselectOpened }">
						<i :class="['ccb-icon-Path-3485 ccb-select-arrow', {'ccb-arrow-up': multiselectOpened}]"></i>
						<span v-if="selectedOptions.length && selectedOptions.length < 3" class="anchor ccb-heading-5 ccb-light-3 ccb-selected">
							<span class="selected" v-for="(choosenOption, index) in selectedOptions" >
								{{ choosenOption }}
								<i class="ccb-icon-close" @click="deleteOption(index)"></i>
							</span>
						</span>
						<span v-else-if="selectedOptions.length >= 3" class="anchor ccb-heading-5 ccb-light ccb-selected">
							{{ selectedOptions.length }} <?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
						</span>
						<span v-else class="anchor ccb-heading-5 ccb-light-3">
								<?php esc_html_e( 'Select values', 'cost-calculator-builder' ); ?>
						</span>
					</div>
					<div class="ccb-order-checkbox" v-if="multiselectOpened">
						<div class="ccb-order-checkbox-overlay" @click="multiselectOpened = false"></div>
						<div class=ccb-order-checkbox__wrapper>
							<div class="calc-checkbox-item" v-for="( element, index ) in getOptions">
								<input :checked="element.isChecked" type="checkbox" :id="label + index + field.id " v-model="selectedOptions" :value="element.optionText" style="display: none;">
								<label :for="label + index + field.id">
									<span>
										<span class="calc-checkbox-title">{{ element.optionText }}</span>
									</span>
									</span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ccb-order-field-required" v-if="field.requiredStatus">
		<div class="ccb-order-field-required__tooltip">
			<span>{{ label }} <?php esc_html_e( 'is required', 'cost-calculator-builder-pro' ); ?></span>
		</div>
	</div>
</div>
