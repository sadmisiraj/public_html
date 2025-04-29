<div class="discount-modal ccb-custom-scrollbar">
	<div class="discount-modal__header">
		<div class="discount-modal__header--label">
			<span class="ccb-edit-field-title ccb-heading-3 ccb-bol"><?php esc_html_e( 'Discount', 'cost-calculator-builder-pro' ); ?></span>
		</div>
		<div class="discount-modal__header--action">
			<button class="ccb-button default" @click="closeModal"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click="saveDiscount"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="discount-modal__body" v-if="isOpen && currentDiscount">
		<div class="ccb-grid-box" style="padding: 0">
			<div class="container" style="padding: 0">

				<div class="row ccb-p-t-20">
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Discount title', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="currentDiscount.title" placeholder="<?php esc_attr_e( 'Enter discount title here', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col col-12 ccb-p-t-40">
						<span class="ccb-delimiter">
							<span class="ccb-delimiter-text"><?php esc_html_e( 'Promo code', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-delimiter-border"></span>
						</span>
					</div>

					<div class="col col-12  ccb-p-t-20">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="currentDiscount.is_promo"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Add a promo code for a discount', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>

					<template v-if="currentDiscount.is_promo">
						<div class="col col-6 ccb-p-t-20">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Promo code', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-input-box">
									<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['promocode'] ) && errors.promocode}" name="promocode" min="0" step="1" @input="errors.promocode=false" v-model="currentDiscount.promocode.promocode" placeholder="<?php esc_attr_e( 'Enter promocode here', 'cost-calculator-builder-pro' ); ?>">
								</div>
								<span class="ccb-error-tip default" style="bottom: 44px !important;" v-if="isObjectHasPath(errors, ['promocode'] ) && errors.promocode" v-html="errors.promocode"></span>
							</div>
						</div>

						<div class="col col-6 ccb-p-t-20" style="padding-left: 0">
							<button class="ccb-button embed" style="height: 40px; margin-top: 27px" @click.prevent="generatePromoCode">
								<span class="ccb-icon-html"></span>
								<span>
								<?php esc_html_e( 'Generate a promo code', 'cost-calculator-builder-pro' ); ?>
							</span>
							</button>
						</div>

						<div class="col col-6 ccb-p-t-20">
							<div class="ccb-input-wrapper number">
								<span class="ccb-input-label"><?php esc_html_e( 'Limit for using this promo code', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-input-box">
									<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['promocode_count'] ) && errors.promocode_count}" name="promocode_count" min="0" step="1" @input="errors.promocode_count=false" v-model="currentDiscount.promocode.promocode_count" placeholder="<?php esc_attr_e( 'Enter count here', 'cost-calculator-builder-pro' ); ?>">
									<span @click="numberCounterAction('promocode_count')" class="input-number-counter up"></span>
									<span @click="numberCounterAction('promocode_count', '-')" class="input-number-counter down"></span>
								</div>
								<span class="ccb-error-tip default" style="bottom: 44px !important;" v-if="isObjectHasPath(errors, ['promocode_count'] ) && errors.promocode_count" v-html="errors.promocode_count"></span>
							</div>
						</div>
					</template>
				</div>

				<div class="row">
					<div class="col col-12 ccb-p-t-40">
						<span class="ccb-delimiter">
							<span class="ccb-delimiter-text"><?php esc_html_e( 'Discount activation', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-delimiter-border"></span>
						</span>
					</div>
					<div class="col col-6 ccb-p-t-20" >
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Activate discount', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="currentDiscount.schedule.period">
									<option value="period"><?php esc_html_e( 'In period', 'cost-calculator-builder-pro' ); ?></option>
									<option value="single_day"><?php esc_html_e( 'On an exact day', 'cost-calculator-builder-pro' ); ?></option>
									<option value="permanently"><?php esc_html_e( 'Forever', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>

					<div class="col col-6 ccb-p-t-20" v-if="['period', 'single_day'].includes(currentDiscount.schedule.period)">
						<div class="ccb-discount-datepicker ccb-select-box select-with-label">
							<span class="ccb-select-label"><?php esc_html_e( 'Date', 'cost-calculator-builder-pro' ); ?></span>
							<discount-calendar :notice="showNotice" :key="keyCount" @set-date="setDate" @clean="cleanSetVal" :value="getPeriodDate" :type="currentDiscount.schedule.period"/>
						</div>
					</div>

					<div class="col col-6 ccb-p-t-20" >
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Show', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="currentDiscount.schedule.view_type">
									<option value="show_without_title"><?php esc_html_e( 'Only discount in total', 'cost-calculator-builder-pro' ); ?></option>
									<option value="show_with_title"><?php esc_html_e( 'Discount with title', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col col-12 ccb-p-t-40">
						<span class="ccb-delimiter">
							<span class="ccb-delimiter-text" style="display: flex">
								<?php esc_html_e( 'Condition', 'cost-calculator-builder-pro' ); ?>
								<span class="ccb-options-tooltip" style="display: flex">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text" style="max-width: 200px; left: unset; margin-left: -85px"><?php esc_html_e( 'The discount will be applied only to the selected formula', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</span>
							<span class="ccb-delimiter-border"></span>
						</span>
					</div>

					<div class="col col-12 ccb-p-t-20" v-for="(condition, idx) in currentDiscount.conditions" :key="idx">
						<div class="ccb-discount-condition-box">
							<div class="row">
								<div class="col col-12">
									<span class="ccb-field-title">
										<?php esc_html_e( 'Choose formula', 'cost-calculator-builder-pro' ); ?>
									</span>

									<div class="ccb-select-box">
										<div class="multiselect" :class="{'calc-required': isObjectHasPath(errors, ['totals_' + idx] ) && errors['totals_' + idx]}">
											<span v-if="condition?.totals?.length > 0 && condition?.totals?.length <= 2" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click.prevent="multiselectShow(event)">
												<span class="selected-payment" v-for="formula in condition.totals">
													{{ formula.title | to-short-input  }}
													<i class="ccb-icon-close" @click.self="removeIdx( formula, idx )" :class="{'settings-item-disabled': getTotalsIdx(condition).length === 1 && getTotalsIdx(condition).includes(+formula.idx)}"></i>
												</span>
											</span>
											<span v-else-if="condition?.totals?.length > 0 && condition?.totals?.length > 2" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShow(event)">
												{{ condition?.totals?.length }} <?php esc_attr_e( 'totals selected', 'cost-calculator-builder-pro' ); ?>
											</span>
											<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
												<?php esc_html_e( 'Select totals', 'cost-calculator-builder-pro' ); ?>
											</span>
											<ul class="items row-list settings-list totals" style="grid-template-columns: repeat(2, 1fr)">
												<li class="option-item settings-item" v-for="formula in getFormulaFields" :class="{'settings-item-disabled': getTotalsIdx(condition).length === 1 && getTotalsIdx(condition).includes(+formula.idx)}" @click="(e) => autoSelect(e, formula, idx)">
													<input :id="'discount_' + idx + formula.idx" :checked="getTotalsIdx(condition).includes(+formula.idx)" :name="'discount-totals-' + idx" class="index" type="checkbox" @change="() => multiselectChooseTotals(formula, idx)"/>
													<label :for="'discount_' + idx + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
												</li>
											</ul>
											<input name="options" type="hidden" />
										</div>
										<span class="ccb-error-tip default" style="bottom: 44px !important;" v-if="errors['totals_' + idx]" v-html="errors['totals_' + idx]" style="right: 10px; bottom: 45px;"></span>
									</div>
								</div>

								<div class="col col-6 ccb-p-t-15">
									<div class="ccb-select-box">
										<span class="ccb-select-label"><?php esc_html_e( 'Condition', 'cost-calculator-builder-pro' ); ?></span>
										<div class="ccb-select-wrapper">
											<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
											<select class="ccb-select" v-model="condition.condition">
												<option value=">"><?php esc_html_e( 'Is over than', 'cost-calculator-builder-pro' ); ?></option>
												<option value="<"><?php esc_html_e( 'Is less than', 'cost-calculator-builder-pro' ); ?></option>
												<option value="="><?php esc_html_e( 'Equal to', 'cost-calculator-builder-pro' ); ?></option>
											</select>
										</div>
									</div>
								</div>

								<div class="col col-6 ccb-p-t-15">
									<div class="ccb-input-wrapper number">
										<span class="ccb-input-label"><?php esc_html_e( 'Price', 'cost-calculator-builder-pro' ); ?></span>
										<div class="ccb-input-box">
											<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['over_price_' + idx] ) && errors['over_price_' + idx]}" :name="'over_price_' + idx" min="0" step="1" @input="errors['over_price_' + idx]=false" v-model="condition.over_price" placeholder="<?php esc_attr_e( 'Enter over price here', 'cost-calculator-builder-pro' ); ?>">
											<span @click="numberCounterAction('over_price_' + idx)" class="input-number-counter up"></span>
											<span @click="numberCounterAction('over_price_' + idx, '-')" class="input-number-counter down"></span>
										</div>
										<span class="ccb-error-tip default" style="bottom: 44px !important;" v-if="isObjectHasPath(errors, ['over_price_' + idx] ) && errors['over_price_' + idx]" v-html="errors['over_price_' + idx]"></span>
									</div>
								</div>

								<div class="col col-6 ccb-p-t-15">
									<div class="ccb-select-box">
										<span class="ccb-select-label"><?php esc_html_e( 'Discount type', 'cost-calculator-builder-pro' ); ?></span>
										<div class="ccb-select-wrapper">
											<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
											<select class="ccb-select" v-model="condition.discount_type">
												<option value="percent_of_amount"><?php esc_html_e( '% of the amount', 'cost-calculator-builder-pro' ); ?></option>
												<option value="fixed_amount"><?php esc_html_e( 'Fixed amount', 'cost-calculator-builder-pro' ); ?></option>
											</select>
										</div>
									</div>
								</div>

								<div class="col col-6 ccb-p-t-15">
									<div class="ccb-input-wrapper number">
										<span class="ccb-input-label" v-if="'percent_of_amount' === condition.discount_type"><?php esc_html_e( 'Discount amount in %', 'cost-calculator-builder-pro' ); ?></span>
										<span class="ccb-input-label" v-else><?php esc_html_e( 'Discount amount', 'cost-calculator-builder-pro' ); ?></span>
										<div class="ccb-input-box">
											<input type="text" class="ccb-heading-5 ccb-light" :class="{'ccb-input-required': isObjectHasPath(errors, ['discount_amount_' + idx] ) && errors['discount_amount_' + idx]}" :name="'discount_amount_' + idx" min="0" step="1" @input="errors['discount_amount_' + idx]=false" v-model="condition.discount_amount" placeholder="<?php esc_attr_e( 'Enter discount here', 'cost-calculator-builder-pro' ); ?>">
											<span @click="numberCounterAction('discount_amount_' + idx)" class="input-number-counter up"></span>
											<span @click="numberCounterAction('discount_amount_' + idx, '-')" class="input-number-counter down"></span>
										</div>
										<span class="ccb-error-tip default" style="bottom: 44px !important;" v-if="isObjectHasPath(errors, ['discount_amount_' + idx] ) && errors['discount_amount_' + idx]" v-html="errors['discount_amount_' + idx]"></span>
									</div>
								</div>
							</div>

							<span class="ccb-close-action" :class="{'disabled': currentDiscount.conditions?.length === 1}" @click.prevent="() => removeDiscountCondition(idx)">
								<span class="close-icon"></span>
							</span>
						</div>
					</div>

					<div class="col col-4 ccb-p-t-20">
						<button class="ccb-button embed" style="height: 40px" @click.prevent="addDiscountCondition">
							<span class="ccb-icon-Path-3453" style="margin-right: 5px"></span>
							<span>
								<?php esc_html_e( 'Add new', 'cost-calculator-builder-pro' ); ?>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
