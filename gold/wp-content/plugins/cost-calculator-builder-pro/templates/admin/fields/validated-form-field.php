<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Validated form', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save(formElementField, id, index, formElementField.alias)"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
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
					<div class="col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
							<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="formElementField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Placeholder', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model.trim="formElementField.placeholder" placeholder="<?php esc_attr_e( 'Enter field placeholder', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="formElementField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-6">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Form type', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="formElementField.field_type">
									<option value="email"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></option>
									<option value="name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></option>
									<option value="phone"><?php esc_html_e( 'Phone', 'cost-calculator-builder-pro' ); ?></option>
									<option value="website_url"><?php esc_html_e( 'Website URL', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-input-wrapper" style="line-height: 1.2">
							<span class="ccb-input-label"><?php esc_html_e( 'Default value', 'cost-calculator-builder-pro' ); ?></span>
							<input class="ccb-heading-5 ccb-light" type="text" v-model.trim="formElementField.default" placeholder="<?php esc_attr_e( 'Enter default value', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
			</template>
			<template v-else>
				<div class="row ccb-p-t-15">
					<div class="col-6" v-if="!disableFieldHiddenByDefault(formElementField)">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="formElementField.hidden"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="formElementField.addToSummary"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
					<div class="col-6" :class="{'ccb-p-t-15': !disableFieldHiddenByDefault(formElementField)}">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="formElementField.required"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Additional Classes', 'cost-calculator-builder-pro' ); ?></span>
							<textarea class="ccb-heading-5 ccb-light" v-model="formElementField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>
</div>
