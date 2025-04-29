<?php
/**
 * @file
 * Cost-quantity component's template
 */
?>
<div :style="additionalCss" class="calc-item ccb-field ccb-fields-tooltip calc-horizontal-full-width" :class="{required: requiredActive, [radioField.additionalStyles]: radioField.additionalStyles}" :data-id="radioField.alias" :data-repeater="repeater">
	<component :is="getStyle" :repeater="repeater" :price="'<?php esc_attr_e( 'Price:', 'cost-calculator-builder-pro' ); ?>'" :field="radioField" :value="value" @update="updateValue"></component>
</div>
