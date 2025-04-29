<?php
$modal_types = array(
	'preview' => array(
		'type' => 'preview',
		'path' => CALC_PATH . '/templates/admin/single-calc/modals/modal-preview.php',
	),
	'history' => array(
		'type' => 'history',
		'path' => CALC_PATH . '/templates/admin/single-calc/modals/history.php',
	),
);
?>
<div class="ccb-table-body calc-quick-tour-discounts calc-quick-tour-no-discounts" style="height: calc(100vh - 145px); position: unset;">
	<div class="ccb-table-body--card" v-if="discounts.length">
		<div class="table-display" style="z-index: 2">
			<div class="table-display--left">
				<div class="ccb-bulk-actions">
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select name="actionType" id="actionType" class="ccb-select">
							<option value="-1"><?php esc_html_e( 'Bulk actions', 'cost-calculator-builder-pro' ); ?></option>
							<option value="duplicate" class="hide-if-no-js"><?php esc_html_e( 'Duplicate', 'cost-calculator-builder-pro' ); ?></option>
							<option value="delete"><?php esc_html_e( 'Delete', 'cost-calculator-builder-pro' ); ?></option>
						</select>
					</div>
					<button class="ccb-button default" @click.prevent="bulkAction"><?php esc_html_e( 'Apply', 'cost-calculator-builder-pro' ); ?></button>
				</div>
			</div>
			<div class="table-display--right">
				<div class="ccb-bulk-actions">
					<button class="ccb-button embed" @click.prevent="createDiscount">
						<i class="ccb-icon-Path-3453"></i>
						<span>
							<?php esc_html_e( 'Add Discount', 'cost-calculator-builder-pro' ); ?>
						</span>
					</button>
				</div>
			</div>
		</div>
		<div class="table-concept ccb-custom-scrollbar" style="z-index: 1">
			<div class="list-item calculators-header calculators">
				<div class="list-title check">
					<input type="checkbox" class="ccb-pure-checkbox" v-model="allChecked" @click="checkAllDiscountsAction">
				</div>
				<div class="list-title sortable discount_id" @click="() => setSort('discount_id')" :class="isActiveSort('discount_id')">
					<span class="ccb-default-title"><?php esc_html_e( 'ID', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title sortable discount_title" @click="() => setSort('title')" :class="isActiveSort('title')">
					<span class="ccb-default-title"><?php esc_html_e( 'Discount name', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title sortable discount_type" @click="() => setSort('is_promo')" :class="isActiveSort('is_promo')">
					<span class="ccb-default-title"><?php esc_html_e( 'Discount type', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title discount_count">
					<span class="ccb-default-title"><?php esc_html_e( 'Usage/Limit', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title discount_date">
					<span class="ccb-default-title"><?php esc_html_e( 'Discount date', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title sortable discount_status" @click="() => setSort('discount_status')" :class="isActiveSort('discount_status')">
					<span class="ccb-default-title"><?php esc_html_e( 'Status', 'cost-calculator-builder-pro' ); ?></span>
				</div>
				<div class="list-title discount_actions" style="text-align: right; padding-right: 5px">
					<span class="ccb-default-title"><?php esc_html_e( 'Actions', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>

			<div class="list-item calculators discounts" v-for="discount in discounts" :key="discount.discount_id" style="padding: 13px 20px; height: auto" @click="() => editDiscount(discount.discount_id)">
				<div class="list-title check">
					<input type="checkbox" class="ccb-pure-checkbox" :value="discount.discount_id" :checked="checkedDiscountIds.includes(discount.discount_id)" @click.stop="checkDiscountAction(discount.discount_id)"/>
				</div>
				<div class="list-title discount_id">
					<span class="ccb-default-title">{{ discount.discount_id }}</span>
				</div>
				<div class="list-title discount_title">
					<span class="ccb-title">
<!--						@click="editCalc(calc.id)"-->
						<span class="ccb-default-title" style="cursor: pointer">{{ discount.title }}</span>
					</span>
				</div>
				<div class="list-title discount_type">
					<span class="ccb-title">
						<span class="ccb-default-title" style="cursor: pointer; display: flex; column-gap: 4px; align-items: center;">
							<template v-if="!discount.is_promo">
								<?php esc_html_e( 'For total price', 'cost-calculator-builder-pro' ); ?>
							</template>
							<template v-else>
								<span>
									<?php esc_html_e( 'Promo code', 'cost-calculator-builder-pro' ); ?>
								</span>
								<span class="ccb-short-code-copy" style="max-width: 100%">
									<span class="code">{{ discount.promocode }}</span>
									<span class="ccb-copy-icon ccb-icon-Path-3400 ccb-tooltip" @click.stop="copyShortCode(discount.discount_id)" @mouseleave="resetCopy">
										<span class="ccb-tooltip-text" style="right: 5px; left: -22px; width: 90px;">{{ shortCode.text }}</span>
										<input type="hidden" class="calc-short-code" :data-id="discount.discount_id" :value="discount.promocode">
									</span>
								</span>
							</template>
						</span>
					</span>
				</div>
				<div class="list-title discount_count">
					<span class="ccb-title">
						<span class="ccb-default-title" style="cursor: pointer">{{ !discount.is_promo ? '—' : discount.promocode_used + ' / ' + discount.promocode_count }}</span>
					</span>
				</div>
				<div class="list-title discount_date">
					<span class="ccb-title">
						<span class="ccb-default-title" style="cursor: pointer">{{ discount.period === 'period' ? discount.period_start_date + ' - ' + discount.period_end_date : discount.period === 'single_day' ? discount.single_date : "<?php esc_html_e( 'No date', 'cost-calculator-builder-pro' ); ?>" }}</span>
					</span>
				</div>
				<div class="list-title discount_status">
					<span class="ccb-title">
						<span class="ccb-default-title" style="text-transform: capitalize">{{ discount.discount_status }}</span>
					</span>
				</div>
				<div class="list-title actions" style="display: flex; justify-content: flex-end; width: 4.5%">
					<div class="ccb-action copy" @click.stop="() => duplicateDiscount(discount.discount_id)">
						<i class="ccb-icon-Path-3505"></i>
					</div>
					<div class="ccb-action delete" @click.stop="() => deleteDiscount(discount.discount_id)">
						<i class="ccb-icon-Path-3503"></i>
					</div>
					<div class="ccb-action edit">
						<i class="ccb-icon-Path-3483"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="ccb-pagination">
			<div class="ccb-pages">
				<span class="ccb-page-item" @click="prevPage" v-if="getDiscountList.page != 1">
					<i class="ccb-icon-Path-3481 prev"></i>
				</span>
				<span class="ccb-page-item" v-for="n in totalPages" :key="n" :class="{active: n === getDiscountList.page}" @click="getPage(n)" :disabled="n == getDiscountList.page">{{ n }}</span>
				<span class="ccb-page-item" @click="nextPage" v-if="getDiscountList.page != totalPages">
					<i class="ccb-icon-Path-3481"></i>
				</span>
			</div>
			<div class="ccb-bulk-actions">
				<div class="ccb-select-wrapper">
					<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
					<select v-model="limit" @change="resetPage" class="ccb-select">
						<option value="5"><?php esc_html_e( '5 per page', 'cost-calculator-builder-pro' ); ?></option>
						<option value="10" class="hide-if-no-js"><?php esc_html_e( '10 per page', 'cost-calculator-builder-pro' ); ?></option>
						<option value="15" class="hide-if-no-js"><?php esc_html_e( '15 per page', 'cost-calculator-builder-pro' ); ?></option>
						<option value="20"><?php esc_html_e( '20 per page', 'cost-calculator-builder-pro' ); ?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="ccb-no-existing-calc discounts" style="width: 100%; background: #eef1f7" v-else>
		<div class="ccb-discounts-content">
			<div class="ccb-discounts-icon-wrap">
				<i class="ccb-icon-Sale-Discount" style="font-size: 48px"></i>
			</div>
			<div class="ccb-discounts-title">
				<span><?php esc_html_e( 'There are no discounts yet', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="ccb-discounts-description">
				<span><?php esc_html_e( 'Create a new discount from scratch', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="ccb-discounts-action">
				<button class="ccb-button embed" @click.prevent="createDiscount">
					<span>
						<?php esc_html_e( 'Create', 'cost-calculator-builder-pro' ); ?>
					</span>
				</button>
			</div>
		</div>
	</div>
	<div class="discounts-overlay" v-if="showModal" @click="closeModal"></div>
	<discount-modal v-if="showModal" inline-template :discount="selectedDiscount" :class="{'is-open': showModalAnimation}" @close="closeModal" @save-discount="saveDiscount">
		<?php echo \cBuilder\Classes\CCBProTemplate::load( 'admin/partials/discounts-modal' ); //phpcs:ignore ?>
	</discount-modal>
	<ccb-modal-window>
		<template v-slot:content>
			<?php foreach ( $modal_types as $m_type ) : ?>
				<template v-if="$store.getters.getModalType === '<?php echo esc_attr( $m_type['type'] ); ?>'">
					<?php require $m_type['path']; ?>
				</template>
			<?php endforeach; ?>
		</template>
	</ccb-modal-window>
</div>
