<div class="ccb-pdf-templates-container">
	<template v-if="templateLoader">
		<div class="ccb-pdf-templates-loader">
			<loader />
		</div>
	</template>
	<template v-else>
		<div class="ccb-pdf-templates-header">
			<div class="ccb-pdf-templates-header--tabs">
				<span class="ccb-pdf-templates-header--tabs-item" @click="() => setModalTemplates('templates')" :class="{'ccb-pdf-item-active': activeModalTab === 'templates'}"><?php esc_html_e( 'Default templates', 'cost-calculator-builder' ); ?></span>
				<span class="ccb-pdf-templates-header--tabs-item" @click="() => setModalTemplates('custom')" :class="{'ccb-pdf-item-active': activeModalTab === 'custom'}"><?php esc_html_e( 'My templates', 'cost-calculator-builder' ); ?></span>
			</div>
		</div>
		<div class="ccb-pdf-templates-body ccb-custom-scrollbar">
			<div class="ccb-pdf-template-items" v-if="activeModalTab === 'templates'">
				<div class="ccb-pdf-template-item" v-for="template in templates" v-if="!template.is_custom" :key="template.key">
					<div class="ccb-pdf-template-item--banner" :style="{backgroundImage: `url('${template.image}')`}"></div>
					<div style="height: 16px; display: flex; align-items: center">
						<span class="ccb-pdf-template-item--name">{{ template.name }}</span>
					</div>
					<span class="ccb-pdf-template-select" @click.prevent="() => extendTemplate(template.key)">
						<?php echo __( 'Extend', 'cost-calculator-builder-pro' ); //phpcs:ignore ?>
					</span>
				</div>
			</div>
			<div class="ccb-pdf-template-items" v-if="activeModalTab === 'custom'">
				<template v-if="getCustomTemplates.length">
					<div class="ccb-pdf-template-item" :class="{'ccb-pdf-active-template': getTemplateKey === template.key}" v-for="template in getCustomTemplates" :key="template.key">
						<div class="ccb-pdf-template-item--banner" :style="{backgroundImage: `url('${template.image}')`}"></div>
						<div style="height: 16px; display: flex; align-items: center">
							<span class="ccb-pdf-template-item--name">{{ template.name }}</span>
						</div>
						<span class="ccb-pdf-template-select" @click.prevent="() => editTemplate(template.key)" v-if="getCustomTemplates?.length !== 1 && template.key !== getTemplateKey">
							<?php echo __( 'Select', 'cost-calculator-builder-pro' ); //phpcs:ignore ?>
						</span>
						<span class="ccb-pdf-template-selected">
							<?php echo __( 'Selected', 'cost-calculator-builder-pro' ); //phpcs:ignore ?>
						</span>
						<span class="ccb-pdf-template-delete" @click.prevent="() => deleteTemplate(template.key)" v-if="getCustomTemplates?.length !== 1 && template.key !== getTemplateKey">
							<i class="ccb-icon-close-x"></i>
						</span>
					</div>
				</template>
				<div style="width: 100%; height: 100%; display: flex; margin: 120px auto; justify-content: center" v-else>
					<span class="ccb-pdf-no-templates">
						<?php echo __( 'No saved templates yet', 'cost-calculator-builder-pro' ); //phpcs:ignore ?>
					</span>
				</div>
			</div>
		</div>
		<div class="ccb-pdf-templates-close">
			<span class="close-icon" @click.prevent="closeModel"></span>
		</div>
	</template>
</div>
