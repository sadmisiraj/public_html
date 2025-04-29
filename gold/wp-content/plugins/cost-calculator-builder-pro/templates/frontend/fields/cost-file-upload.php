<div :style="additionalCss" class="calc-item ccb-field" :class="{required: requiredActive || errors.fileUploadUrl, [fileUpload.additionalStyles]: fileUpload.additionalStyles}" :data-id="fileUpload.alias" :data-repeater="repeater">
	<div class="calc-file-upload" :class="['calc_' + fileUpload.alias]">
		<div class="calc-item__title">
			<span class="ccb-label-span">
				<span v-if="shouldHandleUploadErrorOrRequired" class="calc-required-field">
					<div class="ccb-field-required-tooltip" style="margin-left: 35px">
						<span class="ccb-field-required-tooltip-text" :class="{active: requiredActive || errors.fileUploadUrl}">
							<template v-if="hasFileUploadError">
								{{ errors.fileUploadUrl }}
							</template>
							<template v-if="requiredActive">
								{{ $store.getters.getTranslations.required_field }}
							</template>
						</span>
					</div>
				</span>
				{{ fileUpload.label }}
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
			</span>
			<div class="info-tip-block">
				<div class="info" v-if="showInfo">
					<div class="info-tip">
						<span>
							<?php esc_html_e( 'Supported file formats:', 'cost-calculator-builder-pro' ); ?>
						</span>
						<span class="bold uppercase">{{ fileUpload.fileFormats.join(', ') }}</span>
						<span class="lighter">
							<?php esc_html_e( 'max', 'cost-calculator-builder-pro' ); ?> {{ fileUpload.max_file_size }}mb
						</span>
					</div>
				</div>
				<span class="ccb-icon-Path-3367 info-icon" @mouseover="showInfo = true" @mouseleave="showInfo = false"></span>
			</div>
			<span class="ccb-required-mark" v-if="fileUpload.required">*</span>
		</div>

		<div class="calc-item__description before">
			<span v-text="fileUpload.description"></span>
		</div>

		<div class="calc-buttons">
			<input @change="addFiles" type="file" ref="file" :accept="allowedFormats.map(item=> `.${item}`).join(',')" :multiple="fileUpload.max_attached_files > 1" />
			<div class="calc-file-upload-actions" :style="{'grid-template-columns': !fileUpload.uploadFromUrl ? 'repeat(1, 1fr)' : ''}">
				<button :disabled="fileUpload.max_attached_files <= parseInt(uploadedFiles.length)"  @click="chooseFileBtn" class="calc-btn-action success"><?php esc_html_e( 'Choose file', 'cost-calculator-builder-pro' ); ?></button>
				<button :disabled="fileUpload.max_attached_files <= parseInt(uploadedFiles.length)"  @click.prevent="uploadFromUrlBtn" class="calc-btn-action" v-if="fileUpload.uploadFromUrl"><?php esc_html_e( 'Upload from URL', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>

		<div v-if="uploadFromUrl" class="calc-input-wrapper calc-buttons ccb-field url-file-upload">
			<div class="ccb-url-file-upload-input">
				<input :class="[{'error': ( hasFileUploadError ) }, 'calc-input file-url-upload ccb-field cleanable', 'ccb-appearance-field']" v-model="fileUploadUrl" placeholder="<?php echo wp_specialchars_decode( esc_attr__( 'Enter file url', 'cost-calculator-builder-pro' ), 'ENT_NOQUOTES' ); // phpcs:ignore ?>" type="search"/>
			</div>
			<button class="calc-btn-action success" :class="{disabled: (fileUploadUrl.length <= 0 || ( hasFileUploadError ))}" :disabled="fileUploadUrl.length <= 0" @click.prevent="uploadFileFromUrl()" ><?php esc_html_e( 'Upload', 'cost-calculator-builder-pro' ); ?></button>
		</div>

		<div v-if="uploadedFiles.length > 0" class="calc-uploaded-files">
			<div class="ccb-uploaded-file-list-info" v-if="uploadedFiles.length > 3" @click="openFileList = !openFileList;" style="max-width: max-content">
				<i class="ccb-icon-Path-3484"></i>
				<span>{{ uploadedFiles.length }} <?php esc_html_e( 'files uploaded', 'cost-calculator-builder-pro' ); ?></span>
				<i :class="['ccb-icon-Path-3485', 'ccb-select-anchor',{ 'open': openFileList}]"></i>
			</div>
			<div class="ccb-uploaded-file-list" v-if="openFileList || uploadedFiles.length <= 3">
				<span v-for="(uploadedFile, uploadedFileIndex) in uploadedFiles" class="file-name">
					{{ uploadedFile.name }} <i @click.prevent="removeFile(uploadedFileIndex)" class="remove ccb-icon-close"></i>
				</span>
			</div>
		</div>

		<div class="calc-item__description after">
			<span v-text="fileUpload.description"></span>
		</div>
	</div>
</div>
