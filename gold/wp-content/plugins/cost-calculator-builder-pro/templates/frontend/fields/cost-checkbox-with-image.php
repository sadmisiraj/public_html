<?php
/**
 * @file
 * Cost-checkbox component's template
 */
?>
<div :style="additionalCss" class="calc-item ccb-field ccb-fields-tooltip calc-horizontal-full-width" :class="{required: requiredActive, [checkboxField.additionalStyles]: checkboxField.additionalStyles}" :data-id="checkboxField.alias" :data-repeater="repeater">
	<component :is="getStyle" :repeater="repeater" :price="'<?php esc_attr_e( 'Price:', 'cost-calculator-builder-pro' ); ?>'" :field="checkboxField" @update="updateValue" :value="value"></component>
</div>
