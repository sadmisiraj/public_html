<div :style="additionalCss" class="calc-item ccb-field ccb-fields-tooltip" :class="{required: requiredActive, [dropDownField.additionalStyles]: dropDownField.additionalStyles}" :data-id="dropDownField.alias" :data-repeater="repeater">
	<div class="calc-item__title">
		<span v-if="dropDownField.required" :class="{active: requiredActive}" class="ccb-error-tip front default calc-dd-img-toggle">{{ $store.getters.getTranslations.required_field }}</span>
		<span>{{ dropDownField.label }}</span>
		<span class="ccb-required-mark" v-if="dropDownField.required">*</span>
	</div>

	<div class="calc-item__description before">
		<span v-text="dropDownField.description"></span>
	</div>

	<div :class="['ccb-drop-down', 'calc_' + dropDownField.alias, {'calc-field-disabled': disabled}]">
		<div class="calc-drop-down-with-image">
			<div class="calc-drop-down-wrapper">
				<span :class="['calc-drop-down-with-image-current calc-dd-img-toggle ccb-appearance-field', {'calc-dd-selected': openList}]" @click="openListHandler" :data-alias="dropDownField.alias">
					<img v-if="getCurrent" :src="getCurrent.src" alt="current-img" class="calc-dd-img-toggle"/>
					<img  v-if="!getCurrent" src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/default.png' ); ?>" alt="default-img" class="calc-dd-img-toggle"/>
					<span class="calc-dd-with-option-label calc-dd-img-toggle">{{ getCurrent ? getCurrent.label : '<?php esc_html_e( 'Select value', 'cost-calculator-builder-pro' ); ?>' }}</span>
					<i :class="['ccb-icon-Path-3485 ccb-select-arrow calc-dd-img-toggle', {'ccb-arrow-down': !openList}]"></i>
				</span>
				<div :class="[{'calc-list-open': openList}, 'calc-drop-down-with-image-list']">
					<ul class="calc-drop-down-with-image-list-items">
						<li @click="selectOption(null)" :value="getEmptyValue">
							<img src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/default.png' ); ?>" alt="default-img"/>
							<span class="calc-list-wrapper">
								<span class="calc-list-title"><?php esc_html_e( 'Select value', 'cost-calculator-builder-pro' ); ?></span>
							</span>
						</li>
						<li v-for="(element, index) in getOptions" :key="element.value" :value="element.value" @click="selectOption(element)" :class="{'ccb-field-option-disabled': checkDisableOption(index)}">
							<img :src="element.src" alt="field-img"/>
							<span class="calc-list-wrapper">
								<span class="calc-list-title">{{ element.label }}</span>
								<span class="calc-list-price" v-if="dropDownField.show_value_in_option"><?php esc_html_e( 'Price', 'cost-calculator-builder-pro' ); ?>: {{ element.converted }}</span>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="calc-item__description after">
		<span v-text="dropDownField.description"></span>
	</div>
</div>
