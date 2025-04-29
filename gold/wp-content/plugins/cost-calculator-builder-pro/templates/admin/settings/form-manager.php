<div class="ccb-order-form-manager-wrapper">
	<div class="ccb-order-form-wrapper-preloader" v-if="preloader">
		<loader></loader>
	</div>
	<div class="ccb-order-form-wrapper" v-else>
		<div class="ccb-order-form-header-wrapper" >
			<div class="ccb-order-form-header-title">
				<div class="row">
					<div class="col">
						<div class="ccb-calc-title" v-if="!getEditFormTitle">
							<span class="ccb-title" @click="getEditFormTitle = true" :title="formTitle">{{ formTitle }}</span>
							<i class="ccb-title-edit ccb-icon-Path-3483" @click="getEditFormTitle = true"></i>
						</div>
						<div class="ccb-calc-title" v-else>
							<input type="text" class="ccb-title" v-model="formTitle" @blur="editTitle">
							<i class="ccb-title-approve ccb-icon-Path-3484" @click="getEditFormTitle = false"></i>
						</div>
					</div>
				</div>
			</div>
			<div :class="['ccb-order-form-header-menu', {'is-updated': !isUpdated }]">
				<div :class="['ccb-update-button-wrapper', {'hidden': !isUpdated }]" @click="updateForm">
					<div class="ccb-update-button">
						<?php esc_html_e( 'Update', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
				<div :class="['ccb-order-form-action-menu', {'hidden': !actionMenuOpen}]">
					<div class="ccb-action-menu-item" @click="duplicateForm">
						<?php esc_html_e( 'Duplicate Form', 'cost-calculator-builder-pro' ); ?>
					</div>
					<div class="ccb-action-menu-item" @click="showConfirmDeleteForm">
						<?php esc_html_e( 'Delete Form', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
				<div class="ccb-order-form-header-button">
					<button class="ccb-button default" @click="openAddMenu">
						<i class="ccb-icon-Path-3453 ccb-header-button">
						</i>
						<?php esc_html_e( 'Add Field', 'cost-calculator-builder-pro' ); ?>
					</button>
				</div>
				<div :class="['ccb-order-form-add-menu', {'hidden': !addMenuOpen}]">
					<div class="ccb-add-menu-item" v-for="(field, index) in $store.getters.getOrderFormFields" @click="addField(field)">
						<span class="ccb-sidebar-item-icon">
							<i :class="field.icon"></i>
						</span>
						<span class="ccb-add-menu-item-title">{{ field.name }}</span>
					</div>
				</div>
				<div class="ccb-order-form-header-more" @click="openActionMenu">
					<i class="ccb-icon-Union-15">
					</i>
				</div>
			</div>
		</div>
		<div class="ccb-form-fields-wrapper">
			<template>
				<draggable
					v-bind="dragOptions()"
					tag="div"
					class="ccb-fields-item-row"
					:list="formBuilderFields"
					:filter="'.ccb-switch'"
					@add="added"
					@end="onEnd"
					@start="onDragStart"
				>
				<template v-for="(field, index) in formBuilderFields" :key="field.id || field.tempId">
					<component 
						:is="field.type + '-field'" 
						:field="field" 
						@click="setFieldSelected(field.id || field.tempId)" 
						@close-form-field-confirm="showConfirmDeleteField" 
						@duplicate-form-field="duplicateField" 
						@make-primary-email-field="makeOnePrimaryEmailField"
						@set-field-selected="setFieldSelected(field.id || field.tempId)"
						:class="isSelected(field.id || field.tempId)">
					</component>
				</template>
				</draggable>
			</template>
			<div class="ccb-btn-container calc-buttons" v-if="formBuilderFields.length > 0">
				<button class="ccb-button success"><span>{{ settingsField.formFields.submitBtnText }}</span></button>
			</div>
		</div>
	</div>
	<div class="ccb-order-form-settings-wrapper">
		<div class="ccb-order-form-menu" v-if="!fieldType">
			<div class="ccb-order-menu-item">
				<span class="ccb-tab-title">Order Forms</span>
				<button class="ccb-add-form-button" @click="createDefaultForm">+</button>
			</div>
		</div>
		<div class="ccb-form-list" v-if="!fieldType">
			<div class="ccb-form-item" v-for="(form, idx) in getExistingForms" :key="idx" :class="{'selected': currentFormId == form.id}" @click="confirmFormSelect(form.id)">
				<span class="ccb-default-title" :title="form.name">{{ form.name }}</span>
				<div class="ccb-form-item-tools">
					<button class="ccb-button default" @click="applyForm(form.id)" v-if="!isActive(form.id)"><?php esc_html_e( 'Apply', 'cost-calculator-builder-pro' ); ?></button>
					<i class="ccb-icon-radius-check" v-if="isActive(form.id)"></i>
				</div>
			</div>
		</div>
		<div class="ccb-form-setting">
			<template v-if="fieldType">
				<?php
				$fields = \cBuilder\Helpers\CCBOrderFormFieldsHelper::order_form_fields();
				?>
				<?php foreach ( $fields as $key => $field ) : ?>
					<component
							inline-template
							:field="currentFieldSetting"
							:sort_id="sortId"
							@cancel="closeSetting"
							is="<?php echo esc_attr( $field['type'] ); ?>-field"
							v-if="fieldType === '<?php echo esc_attr( $field['type'] ); ?>'"
					>
						<?php echo \cBuilder\Classes\CCBProTemplate::load( '/admin/form-fields/' . $field['type'] . '-field' ); // phpcs:ignore ?>
					</component>
				<?php endforeach; ?>
			</template>
		</div>
	</div>

	<ccb-confirm-form-field-popup
		v-if="confirmDeleteFieldPopup"
		:status="confirmDeleteFieldPopup"
		@close-form-field-confirm="deleteField"
		cancel="<?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?>"
		delete="<?php esc_html_e( 'Delete field', 'cost-calculator-builder-pro' ); ?>"
	>
		<slot>
			<span slot="description"><?php esc_html_e( 'Are you sure you want to delete this field and all data associated with it?', 'cost-calculator-builder-pro' ); ?></span>
		</slot>
	</ccb-confirm-form-field-popup>
	<ccb-confirm-form-popup
		v-if="confirmSelectForm"
		:status="confirmSelectForm"
		:form-id="tempFormId"
		@select-form-confirm="setSelected"
		cancel="<?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?>"
		ok="<?php esc_html_e( 'Ok', 'cost-calculator-builder-pro' ); ?>"
	>
	<slot>
		<span slot="description"><?php esc_html_e( 'Are you sure you want select another form without saving it?', 'cost-calculator-builder-pro' ); ?></span>
	</slot>
	</ccb-confirm-form-popup>
	<ccb-confirm-form-popup
		v-if="confirmDeleteFormPopup"
		:status="confirmDeleteFormPopup"
		:form-id="tempFormId"
		@select-form-confirm="deleteForm"
		cancel="<?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?>"
		ok="<?php esc_html_e( 'Ok', 'cost-calculator-builder-pro' ); ?>"
	>
		<slot>
			<span slot="description"><?php esc_html_e( 'Are you sure you want to delete this form?', 'cost-calculator-builder-pro' ); ?></span>
		</slot>
	</ccb-confirm-form-popup>
	<ccb-notify-form-popup
		v-if="confirmNotifyForm"
		:status="confirmNotifyForm"
		@close-notify-confirm="notifiedConfirmClose"
		:description="selectedDescriptionTranslation"
		ok="<?php esc_html_e( 'Ok', 'cost-calculator-builder-pro' ); ?>"
	>
	</ccb-notify-form-popup>
</div>
