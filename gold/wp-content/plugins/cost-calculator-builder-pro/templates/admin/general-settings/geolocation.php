<div class="ccb-grid-box">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Geolocation', 'cost-calculator-builder-pro' ); ?></span>
				<span class="ccb-tab-subtitle">
					<?php esc_html_e( 'Add geolocation API to use the Geolocation element to enable users to choose a location from the map. ', 'cost-calculator-builder-pro' ); ?>
					<br>
					<a href="https://docs.stylemixthemes.com/cost-calculator-builder/cost-calculator-settings/global-settings/geolocation" target="_blank"><?php esc_html_e( 'Read documentation', 'cost-calculator-builder-pro' ); ?></a>
					<?php esc_html_e( 'for more information', 'cost-calculator-builder-pro' ); ?>
				</span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col col-3" style="padding-right: 8px !important;">
				<div class="ccb-select-box">
					<span class="ccb-select-label"><?php esc_html_e( 'Map provider', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select class="ccb-select" v-model="generalSettings.geolocation.type" style="font-size: 14px; padding-left: 4px">
							<option v-for="(option, key) in generalSettings.geolocation.maps" :key="key" :value="key">{{ option }}</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col col-3" style="padding-right: 8px !important;">
				<?php if ( apply_filters( 'ccb_hide_api', '' ) ) : ?>
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'API key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="email" style="opacity: 0.6; pointer-events: none;" value="<?php esc_attr_e( 'Your google api key', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
					</div>
				<?php else : ?>
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'API key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="email" v-model="generalSettings.geolocation.public_key" placeholder="<?php esc_attr_e( 'Enter Your public key', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
					</div>
				<?php endif; ?>
			</div>
			<div class="col col-3" style="padding-right: 8px !important;">
				<div class="ccb-select-box">
					<span class="ccb-select-label"><?php esc_html_e( 'Measure unit', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select class="ccb-select" v-model="generalSettings.geolocation.measure" style="font-size: 14px; padding-left: 4px">
							<option v-for="(option, key) in generalSettings.geolocation.measures" :key="key" :value="key">{{ option }}</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col col-3">
				<div class="ccb-image-upload">
					<input type="file" class="ccb-image-upload-input" ref="pickupref" @change="addImg('pickUp', event)">
					<span class="ccb-image-upload-label"><?php esc_html_e( 'Pickup point icon', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-image-upload-buttons" :class="{disable: pickUpButtonDisable}">
						<button class="ccb-button success" @click="chooseFile('pickupref')"><?php esc_html_e( 'Select image', 'cost-calculator-builder-pro' ); ?></button>
					</div>
					<span class="ccb-image-upload-error" v-if="pickUpErrors"><?php esc_html_e( 'This file type is not supported', 'cost-calculator-builder-pro' ); ?></span>
					<img :src="pickUpIconPath" v-if="pickUpIconPath" class="ccb-image-upload-preview" alt="Logo">
					<span class="ccb-image-upload-filename" v-if="pickUpIconPath">
						{{ pickUpImgName }}
						<i class="remove ccb-icon-close" @click="clear('pickUp')"></i>
					</span>
					<span class="ccb-image-upload-info"><?php esc_html_e( 'Supported file formats: JPG, PNG and SVG(max 1 MB)', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
			<div class="col col-3">
				<div class="ccb-image-upload">
					<input type="file" class="ccb-image-upload-input" ref="markerref" @change="addImg('marker', event)">
					<span class="ccb-image-upload-label"><?php esc_html_e( 'Location marker icon', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-image-upload-buttons" :class="{disable: markerButtonDisable}">
						<button class="ccb-button success" @click="chooseFile('markerref')"><?php esc_html_e( 'Select image', 'cost-calculator-builder-pro' ); ?></button>
					</div>
					<span class="ccb-image-upload-error" v-if="markerErrors"><?php esc_html_e( 'This file type is not supported', 'cost-calculator-builder-pro' ); ?></span>
					<img :src="markerIconPath" v-if="markerIconPath" class="ccb-image-upload-preview" alt="Logo">
					<span class="ccb-image-upload-filename" v-if="markerIconPath">
						{{ markerImgName }}
						<i class="remove ccb-icon-close" @click="clear('marker')"></i>
					</span>
					<span class="ccb-image-upload-info"><?php esc_html_e( 'Supported file formats: JPG, PNG and SVG(max 1 MB)', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
