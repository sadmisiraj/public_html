<?php
/**
 * @file
 * Cost-group component's template
 */

$get_date_format = get_option( 'date_format' );
$lang            = get_bloginfo( 'language' );
?>

<div :style="additionalCss" class="calc-item ccb-field calc-group calc-horizontal-full-width" :class="{rtl: rtlClass('<?php echo esc_attr( $lang ); ?>'),required: $store.getters.isUnused(groupField), [additionalCss.additionalStyles]: additionalCss.additionalStyles}" :data-id="groupField.alias" :data-repeater="repeater">
	<div class="calc-group-wrapper" :class="['calc_' + groupField.alias]">
		<div class="calc-item__title ccb-group-field" :data-index="groupField.alias">
			<span @click="() => collapse(groupField.alias)" :class="{ collapsible: groupField.collapsible, 'ccb-collapsed': collapseGroup }">
				<i class="ccb-icon-Path-3514" v-if="groupField.collapsible"></i>
				<span v-if="groupField.showTitle">{{ groupField.label }}</span>
				<span class="is-pro" v-if="isPro">
					<span class="pro-tooltip">
						PRO
						<span class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
			</span>
		</div>
		<div class="calc-group-fields" v-show="!collapseGroup" :data-index="groupField.alias">
			<slot></slot>
		</div>
	</div>
</div>
