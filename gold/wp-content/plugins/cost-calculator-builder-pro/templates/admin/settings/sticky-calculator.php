<?php
$calc_id = $_GET['id'] ?? '';
?>
<div class="sticky-calculator-wrapper">
	<div class="ccb-grid-box" style="max-width: 380px">
		<div class="container">

			<div class="row ccb-p-b-10">
				<div class="col-12">
					<span class="ccb-tab-title"><?php esc_html_e( 'Sticky calculator', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="col-12">
					<span class="ccb-tab-description-with-link">
						<?php esc_html_e( 'Add a sticky button to return to the calculator that will stay visible when users scroll down the page', 'cost-calculator-builder-pro' ); ?>
					</span>
				</div>
			</div>

			<div class="row ccb-p-t-10">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="settingsField.sticky_calc.enable"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Enable a sticky calculator', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>

			<template v-if="settingsField.sticky_calc.enable">
				<div class="row ccb-p-t-20">
					<div class="col-12">
						<span class="ccb-field-title"><?php esc_html_e( 'Show as', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-radio-wrapper" style="margin-top: 5px; flex-wrap: nowrap; column-gap: 25px;">
							<label style="display: flex; align-items: center; column-gap: 7px; cursor: pointer">
								<input type="radio" name="display_type" value="btn" checked v-model="settingsField.sticky_calc.display_type">
								<span class="ccb-heading-5"><?php esc_html_e( 'Floating button', 'cost-calculator-builder-pro' ); ?></span>
							</label>
							<label style="display: flex; align-items: center; column-gap: 7px; cursor: pointer">
								<input type="radio" name="display_type" value="banner" v-model="settingsField.sticky_calc.display_type">
								<span class="ccb-heading-5"><?php esc_html_e( 'Sticky banner', 'cost-calculator-builder-pro' ); ?></span>
							</label>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="settingsField.sticky_calc.display_type === 'btn'">
					<div class="col-12">
						<span class="ccb-field-title" style="line-height: 1.4"><?php esc_html_e( 'Position', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-options-tooltip">
							<i class="ccb-icon-circle-question"></i>
							<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Pick where on the page it shows up', 'cost-calculator-builder-pro' ); ?></span>
						</span>
						<div class="calc-sticky-positions">
							<div class="calc-position-left">
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'top_left', 'ccb-count-over': isAvailable('top_left')}" @click="() => updateBtnPosition('top_left')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('top_left')">
										<span class="ccb-hint-info-text"><?php esc_html_e( 'Two calculators have been added to the same position:', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.top_left?.titles">{{key + 1}}. {{ title | short-title }}</span>
										</span>
									</span>
								</span>
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'center_left', 'ccb-count-over': isAvailable('center_left')}" @click="() => updateBtnPosition('center_left')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('center_left')">
										<span class="ccb-hint-info-text"><?php esc_html_e( 'Two calculators have been added to the same position:', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.center_left?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'bottom_left', 'ccb-count-over': isAvailable('bottom_left')}" @click="() => updateBtnPosition('bottom_left')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('bottom_left')">
										<span class="ccb-hint-info-text"><?php esc_html_e( 'Two calculators have been added to the same position:', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.bottom_left?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
							</div>
							<div class="calc-position-center">
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'top_center', 'ccb-count-over': isAvailable('top_center')}" @click="() => updateBtnPosition('top_center')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('top_center')">
										<span class="ccb-hint-info-text"><?php esc_html_e( 'Two calculators have been added to the same position:', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.top_center?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'bottom_center', 'ccb-count-over': isAvailable('bottom_center')}" @click="() => updateBtnPosition('bottom_center')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('bottom_center')">
										<span class="ccb-hint-info-text"><?php esc_html_e( 'Two calculators have been added to the same position:', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.bottom_center?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
							</div>
							<div class="calc-position-right">
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'top_right', 'ccb-count-over': isAvailable('top_right')}" @click="() => updateBtnPosition('top_right')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('top_right')">
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.top_right?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'center_right', 'ccb-count-over': isAvailable('center_right')}" @click="() => updateBtnPosition('center_right')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('center_right')">
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.center_right?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
								<span class="ccb-options-tooltip" style="width: 100% !important;">
									<span class="ccb-position-item" :class="{selected: settingsField.sticky_calc.btn_position === 'bottom_right', 'ccb-count-over': isAvailable('bottom_right')}" @click="() => updateBtnPosition('bottom_right')"></span>
									<span class="ccb-options-tooltip__text" style="max-width: 170px; left: 48px; bottom: 141%;" v-if="isAvailable('bottom_right')">
										<span class="ccb-titles-info-wrapper">
											<span class="ccb-title-info" v-for="(title, key) in positions.bottom_right?.titles">{{key + 1}}.{{ title | short-title }}</span>
										</span>
									</span>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-else>
					<div class="col-12">
						<span class="ccb-field-title"><?php esc_html_e( 'Position', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-radio-wrapper" style="margin-top: 5px; flex-wrap: nowrap; column-gap: 25px;">
							<label style="display: flex; align-items: center; column-gap: 7px; cursor: pointer">
								<input type="radio" name="banner_position" value="top" checked v-model="settingsField.sticky_calc.banner_position">
								<span class="ccb-heading-5"><?php esc_html_e( 'Top', 'cost-calculator-builder-pro' ); ?></span>
							</label>
							<label style="display: flex; align-items: center; column-gap: 7px; cursor: pointer">
								<input type="radio" name="banner_position" value="bottom" v-model="settingsField.sticky_calc.banner_position">
								<span class="ccb-heading-5"><?php esc_html_e( 'Bottom', 'cost-calculator-builder-pro' ); ?></span>
							</label>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20">
					<div class="col-12">
						<div class="ccb-select-box">
							<div style="display: flex; margin-bottom: 5px;">
								<span class="sticky-settings-label"><?php esc_html_e( 'Icon', 'cost-calculator-builder-pro' ); ?></span>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Allowed image formats: JPG, JPEG, PNG, WEBP, GIF and SVG', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</div>
							<div class="ccb-sticky-icon-wrapper" :class="{'icon-selected': settingsField.sticky_calc.icon?.length}">
								<img-selector :svg="true" :url="settingsField.sticky_calc.icon" @set="setThumbnail" :style="" select_text="Select icon"></img-selector>
								<div class="ccb-input-wrapper">
									<div class="ccb-input-box">
										<div class="ccb-checkbox-box" style="cursor: pointer; line-height: 1.6;">
											<input :checked="settingsField.sticky_calc.hide_icon" @change="() => toggleHideIcon()" type="checkbox"/>
											<span @click="() => toggleHideIcon()" style="position: relative; top: 2px">
												<?php esc_html_e( 'Hide an icon', 'cost-calculator-builder-pro' ); ?>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20">
					<div class="col-12">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Title', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="settingsField.sticky_calc.title">
									<option value="calc_title"><?php esc_html_e( 'Calculator title', 'cost-calculator-builder-pro' ); ?></option>
									<option value="custom"><?php esc_html_e( 'Custom title', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="settingsField.sticky_calc.title === 'custom'">
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Custom text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.sticky_calc.custom_text">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="settingsField.sticky_calc.display_type === 'banner'">
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Description text', 'cost-calculator-builder-pro' ); ?></span>
							<textarea style="resize: none" class="ccb-heading-5 ccb-light" v-model="settingsField.sticky_calc.custom_desc"></textarea>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="['scroll_to', 'open_modal', 'pdf', 'invoice', 'pro_features'].includes(settingsField.sticky_calc.one_click_action)">
					<div class="col col-12">
						<span class="ccb-field-title">
							<?php esc_html_e( 'Select total', 'cost-calculator-builder-pro' ); ?>
						</span>
						<div class="ccb-select-box">
							<div class="multiselect">
								<span v-if="formulas.length > 0 && formulas.length <= 2" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click.prevent="multiselectShow(event)">
									<span class="selected-payment" v-for="formula in formulas">
										{{ formula.title | to-short-input  }}
										<i class="ccb-icon-close" @click.self="removeIdx( formula )"></i>
									</span>
								</span>
								<span v-else-if="formulas.length > 0 && formulas.length > 2" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShow(event)">
									{{ formulas.length }} <?php esc_attr_e( 'totals selected', 'cost-calculator-builder-pro' ); ?>
								</span>
								<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
									<?php esc_html_e( 'Select totals', 'cost-calculator-builder-pro' ); ?>
								</span>
								<ul class="items row-list settings-list totals" style="grid-template-columns: repeat(1, 1fr);">
									<li class="option-item settings-item" v-for="formula in getFormulaFields" @click="(e) => autoStickySelect(e, formula)">
										<input :id="'sticky_totals' + formula.idx" :checked="getTotalsIdx.includes(+formula.idx)" name="paymentGatewayTotals" class="index" type="checkbox" @change="multiselectChooseStickyTotals(formula)"/>
										<label :for="'sticky_totals' + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
									</li>
								</ul>
								<input name="options" type="hidden" />
							</div>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="['scroll_to', 'open_modal', 'woo_checkout', 'pdf', 'invoice'].includes(settingsField.sticky_calc.one_click_action)">
					<div class="col col-12">
						<span class="ccb-field-title" style="line-height: 1.4"><?php esc_html_e( 'Not show on pages', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-options-tooltip">
							<i class="ccb-icon-circle-question"></i>
							<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Choose on what pages you don’t want to show the sticky calculator', 'cost-calculator-builder-pro' ); ?></span>
						</span>
						<div class="ccb-select-box">
							<div class="multiselect" :class="{'visible': multiSelectPage}">
								<span v-if="selectedPages.length > 0 && selectedPages.length <= 2" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click.prevent="multiselectShowPages(event)">
									<span class="selected-payment" v-for="page in selectedPages">
										{{ page.title }}
										<i class="ccb-icon-close" @click="removePage(page)"></i>
									</span>
								</span>
								<span v-else-if="selectedPages.length > 0 && selectedPages.length > 2" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShowPages(event)">
									{{ selectedPages.length }} <?php esc_attr_e( 'pages selected', 'cost-calculator-builder-pro' ); ?>
								</span>
								<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
									<?php esc_html_e( 'Select pages', 'cost-calculator-builder-pro' ); ?>
								</span>
								<ul class="items row-list settings-list totals" style="grid-template-columns: repeat(1, 1fr);">
									<li class="option-item settings-item" @click.prevent="selectOrUnselectAll">
										<input id="select_or_unselect_all" name="paypalTotals" class="index" type="checkbox" :checked="selectAll"/>
										<label for="select_or_unselect_all" class="ccb-heading-5"><?php esc_html_e( 'Select / Unselect all', 'cost-calculator-builder-pro' ); ?></label>
									</li>
									<li class="option-item settings-item" v-for="page in $store.getters.getPages" @click="multiselectChoosePages(page)">
										<input :id="page.id" name="paypalTotals" class="index" type="checkbox" :checked="pagesIdx.includes(page.id)" @change="multiselectChoosePages(page)"/>
										<label :for="page.id" class="ccb-heading-5">{{ page.title | to-short }}</label>
									</li>
								</ul>
								<input name="options" type="hidden" />
							</div>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20">
					<div class="col-12">
						<div class="ccb-select-box">
							<span class="ccb-select-label" style="line-height: 1.4; display: inline-flex;"><?php esc_html_e( 'Click action', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-options-tooltip">
								<i class="ccb-icon-circle-question"></i>
								<span class="ccb-options-tooltip__text" style="max-width: 200px; left: 30px;"><?php esc_html_e( 'Choose what happens when users click the button: either they go back to the calculator or a popup will open.', 'cost-calculator-builder-pro' ); ?></span>
							</span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="settingsField.sticky_calc.one_click_action">
									<option value="scroll_to"><?php esc_html_e( 'Scroll to calculator', 'cost-calculator-builder-pro' ); ?></option>
									<option value="open_modal"><?php esc_html_e( 'Open a pop-up', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('pro_features')" value="pro_features"><?php esc_html_e( 'Pop up order form or payments', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('pdf')" value="pdf"><?php esc_html_e( 'Download PDF', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('invoice')" value="invoice"><?php esc_html_e( 'Share invoice', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('woo_checkout')" value="woo_checkout"><?php esc_html_e( 'WooCheckout action after submit', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('woo_product_as_modal')" value="woo_product_as_modal"><?php esc_html_e( 'WooProduct as open modal', 'cost-calculator-builder-pro' ); ?></option>
									<option v-bind="extraAttrs('woo_product_with_redirect')" value="woo_product_with_redirect"><?php esc_html_e( 'WooCheckout action on WooProduct page', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-12 ccb-p-t-10" v-if="showNoticeRedirect">
						<div class="ccb-warn-row row-notice">
							<?php esc_html_e( 'The page won\'t redirect to Woo Checkout as “Stay on Page” option is enabled.', 'cost-calculator-builder-pro' ); ?>
							<span @click="tab = '<?php echo esc_attr( 'woo-checkout' ); ?>'"><?php esc_html_e( 'Click here to open settings', 'cost-calculator-builder-pro' ); ?></span>
						</div>
					</div>
					<div class="col-12 ccb-p-t-10" v-if="showNoticePageBreak">
						<div class="ccb-warn-row row-notice">
							<?php esc_html_e( '\'Popup order form or payments\' cannot be selected as click action because \'Show summary block on the last page of multi-step calculator\' is enabled in Page Breaker settings.', 'cost-calculator-builder-pro' ); ?>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="['woo_checkout', 'woo_product_with_redirect', 'pdf', 'invoice', 'pro_features'].includes(settingsField.sticky_calc.one_click_action)">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.sticky_calc.show_calculator"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show calculator in background', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10" v-if="['woo_checkout', 'woo_product_as_modal', 'woo_product_with_redirect',].includes(settingsField.sticky_calc.one_click_action)">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.sticky_calc.show_total"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Show total', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20" v-if="settingsField.sticky_calc.display_type === 'banner'">
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.sticky_calc.btn_text">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-20">
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Additional classes', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.sticky_calc.classes">
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>

	<div class="sticky-calculator-preview" v-if="settingsField.sticky_calc.enable">
		<div class="sticky-calculator-preview--header">
			<span class="ccb-heading-5 ccb-bold" style="color: #000"><?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="sticky-calculator-preview--content ccb-sticky-calc ccb-calc-id-<?php echo esc_attr( $calc_id ); ?>">
			<span class="calc-sticky-placeholder">
				<?php esc_html_e( 'Page content', 'cost-calculator-builder-pro' ); ?>
			</span>
			<div class="sticky-calculator-banner" :style="getBannerPosition" v-if="settingsField.sticky_calc.display_type === 'banner'">
				<div class="sticky-calculator-banner--left">
					<div class="sticky-bar-icon is-image" v-if="!settingsField.sticky_calc.hide_icon">
						<template v-if="settingsField.sticky_calc.icon">
							<img :src="settingsField.sticky_calc.icon" alt="icon svg">
						</template>
						<template v-else>
							<i class="ccb-icon-Calculators-filled"></i>
						</template>
					</div>
					<div class="sticky-bar-text">
						<span class="sticky-bar-text__title">{{getTitle | to-short-banner-title}}</span>
						<span class="sticky-bar-text__description" v-if="settingsField.sticky_calc.custom_desc?.trim()?.length">{{settingsField.sticky_calc.custom_desc | to-short-banner-description}}</span>
					</div>
				</div>
				<div class="sticky-calculator-banner--right">
					<div class="sticky-bar-totals" v-if="showTotal">
						<span>Total: $0</span>
					</div>
					<div class="sticky-bar-action">
						<button class="ccb-button success" style="height: 40px">{{ settingsField.sticky_calc.btn_text | to-short-banner-title }}</button>
					</div>
				</div>
			</div>
			<div class="sticky-calculator-btn" v-else-if="settingsField.sticky_calc.display_type === 'btn'" :style="getBtnPosition">
				<div class="sticky-calculator-btn--icon is-image" v-if="!settingsField.sticky_calc.hide_icon" v-if="!settingsField.sticky_calc.hide_icon">
					<template v-if="settingsField.sticky_calc.icon">
						<img :src="settingsField.sticky_calc.icon" alt="icon svg">
					</template>
					<template v-else>
						<i class="ccb-icon-Calculators-filled"></i>
					</template>
				</div>
				<div class="sticky-calculator-btn--text">
					<span class="sticky-calculator-btn--text__title">{{getTitle | to-short-cart-title}}</span>
					<span class="sticky-calculator-btn--text__description" v-if="showTotal">Total: $0</span>
				</div>
				<div class="ccb-icon-arrow">
					<i class="ccb-icon-Down"></i>
				</div>
			</div>
		</div>
	</div>

	<ccb-confirm-popup
			v-if="confirmPopup"
			:status="confirmPopup"
			@close-confirm="closeConfirm"
			:abandon="true"
			@cancel-confirm="cancelConfirm"
			cancel="<?php esc_html_e( 'Cancel', 'cost-calculator-builder' ); ?>"
			del="<?php esc_html_e( 'Make sticky banner', 'cost-calculator-builder' ); ?>"
	>
		<slot>
			<span slot="description"><?php esc_html_e( 'Would you like to make this calculator sticky banner? You can use only one calculator with sticky banner. Other calculator with sticky banner becomes floating button.', 'cost-calculator-builder' ); ?></span>
		</slot>
	</ccb-confirm-popup>
</div>
