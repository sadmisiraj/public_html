<div class="ccb-pdf-tool-manager">
	<ccb-pdf-template :key="$store.getters.getLayoutCounter" ref="pdfPreview" :class="{'ccb-disable-content': !status}"></ccb-pdf-template>

	<div class="ccb-pdf-tool-manager-sidebar">
		<div class="ccb-pdf-tool-manager-sidebar--item">
			<div class="ccb-pdf-tool-manager-sidebar--item-main">
				<div class="ccb-pdf-tool-manager-sidebar--item-main__top" :style="{borderBottom: !status ? 'none' : ''}">
					<div class="ccb-pdf-tool-manager-sidebar--item-main__top-header">
						<div class="ccb-pdf-tool-manager-sidebar--item-main__top-header-label">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="status"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-6 ccb-bold"><?php esc_html_e( 'Activate PDF Entries', 'cost-calculator-builder' ); ?></h6>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Generate PDF copies of form submissions automatically', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</div>
						</div>
						<div class="ccb-pdf-tool-manager-sidebar--item-main__top-header-action">
							<button class="ccb-button success ccb-settings" @click.prevent="savePdf" v-if="extended" style="padding: 0 16px !important;"><?php esc_html_e( 'Publish', 'cost-calculator-builder-pro' ); ?></button>
							<button class="ccb-button success ccb-settings" @click.prevent="savePdf" v-else style="padding: 0 16px !important;"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
						</div>
					</div>
					<div class="ccb-pdf-tool-manager-sidebar--item-main__top-content" v-if="status">
						<img :src="getTemplateImage" alt="">
						<div class="ccb-pdf-tool-manager-sidebar--item-main__top-content-actions">
							<div class="ccb-pdf-tool-manager-sidebar--item-main__top-content-actions-top">
								<button class="ccb-button default" @click.prevent="selectTemplate"><?php esc_html_e( 'Select Template', 'cost-calculator-builder-pro' ); ?></button>
							</div>
							<div class="ccb-pdf-tool-manager-sidebar--item-main__top-content-actions-bottom">
								<button class="ccb-button default" @click.prevent="restoreTemplate"><?php esc_html_e( 'Restore Styles', 'cost-calculator-builder-pro' ); ?></button>
								<button class="ccb-button default" @click.prevent="preview">
									<span><?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?></span>
									<i class="ccb-icon-Printing-Service"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="ccb-pdf-tool-manager-sidebar--item-main__top-footer" v-if="status">
						<div class="ccb-pdf-color-picker with-text-label">
							<div class="ccb-pdf-color-picker--label">
								<span><?php echo __( 'Name', 'cost-calculator-builder-pro' ); //phpcs:ignore ?></span>
							</div>
							<div class="ccb-pdf-color-picker--input">
								<input type="text" v-model="pdfName">
							</div>
						</div>
						<div class="ccb-pdf-color-picker with-text-label">
							<div class="ccb-pdf-color-picker--label">
								<span><?php echo __( 'Button Text', 'cost-calculator-builder-pro' ); //phpcs:ignore ?></span>
							</div>
							<div class="ccb-pdf-color-picker--input">
								<input type="text" v-model="buttonText">
							</div>
						</div>
						<div class="ccb-pdf-color-picker just-switch">
							<div class="ccb-pdf-color-picker--label" :class="{'ccb-disable-text': !showAfterPayment}">
								<span><?php echo __( 'Show button only after payment', 'cost-calculator-builder-pro' ); //phpcs:ignore ?></span>
							</div>
							<div class="ccb-pdf-color-picker--switch">
								<div class="list-header">
									<div class="ccb-switch">
										<input type="checkbox" v-model="showAfterPayment"/>
										<label></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ccb-pdf-tool-manager-sidebar--item-main__bottom" v-if="status">
					<ul class="ccb-accordion">
						<accordion-item :item="getDocumentStyle"></accordion-item>
					</ul>
				</div>
			</div>
		</div>

		<div class="ccb-pdf-tool-manager-sidebar--item" v-if="items.body.length" :class="{'ccb-disable-content': !status}">
			<div class="ccb-pdf-tool-manager-sidebar--item-header">
				<span><?php echo __( 'Body', 'cost-calculator-builder-pro' ); //phpcs:ignore ?></span>
			</div>
			<div class="ccb-pdf-tool-manager-sidebar--item-body" :class="{'ccb-disable-drag': bodyActive}">
				<draggable v-if="items.body.length" :disabled="bodyActive" v-bind="dragOptions" :move="onMove" @end="endDrag" v-model="items.body" group="shared" data-list="body" tag="ul" class="ccb-accordion">
					<accordion-item v-for="item in items.body" :key="item.key" :item="item" block="sections" :body="true" @update="updateAccordion" :ref="item.key"></accordion-item>
				</draggable>
			</div>
		</div>

		<div class="ccb-pdf-tool-manager-sidebar--item" v-if="items.sidebar.length" :class="{'ccb-disable-content': !status}">
			<div class="ccb-pdf-tool-manager-sidebar--item-header">
				<span><?php echo __( 'Sidebar', 'cost-calculator-builder-pro' ); //phpcs:ignore ?></span>
			</div>
			<div class="ccb-pdf-tool-manager-sidebar--item-body">
				<draggable v-if="items.sidebar.length" :disabled="sidebarActive" v-bind="dragOptions" :move="onMove" @end="endDrag" block="sections" v-model="items.sidebar" group="shared" data-list="sidebar" tag="ul" class="ccb-accordion">
					<accordion-item v-for="item in items.sidebar" :key="item.key" :item="item" block="sections" :body="false" @update="updateAccordion" :ref="item.key"></accordion-item>
				</draggable>
			</div>
		</div>
	</div>
</div>

<ccb-modal-window @on-close="closeModel">
	<template v-slot:content>
		<template v-if="$store.getters.getModalType === 'pdf-templates'">
			<?php require CCB_PRO_PATH . '/templates/admin/general-settings/modals/pdf-templates.php'; ?>
		</template>
	</template>
</ccb-modal-window>
