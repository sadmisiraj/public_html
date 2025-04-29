<?php
/**
 * @file
 * Cost-geolocation component's template
 */

$texts = array(
	'cancel'          => esc_html__( 'Cancel', 'cost-calculator-builder-pro' ),
	'save_location'   => esc_html__( 'Save location', 'cost-calculator-builder-pro' ),
	'clear_selection' => esc_html__( 'Clear selection', 'cost-calculator-builder-pro' ),
	'open_map'        => esc_html__( 'Open map', 'cost-calculator-builder-pro' ),
	'choose_from_map' => esc_html__( 'Choose from map', 'cost-calculator-builder-pro' ),
	'search_location' => esc_html__( 'Search location', 'cost-calculator-builder-pro' ),
	'enter_address'   => esc_html__( 'Enter address', 'cost-calculator-builder-pro' ),
	'distance'        => esc_html__( 'Distance', 'cost-calculator-builder-pro' ),
	'from'            => esc_html__( 'From', 'cost-calculator-builder-pro' ),
	'to_destination'  => esc_html__( 'To destination', 'cost-calculator-builder-pro' ),
	'to'              => esc_html__( 'To', 'cost-calculator-builder-pro' ),
	'select_location' => esc_html__( 'Select Location', 'cost-calculator-builder-pro' ),
	'large_distance'  => esc_html__( 'The distance from your address can not be calculated because it is too far.', 'cost-calculator-builder-pro' ),
);

?>

<div :style="additionalCss" class="calc-item ccb-field ccb-geolocation-field" :class="{required: requiredActive}" :data-id="geolocationField.alias" :data-repeater="repeater">
	<component :is="getStyle" :repeater="repeater" :field="geolocationField" static-texts='<?php echo esc_attr( wp_json_encode( $texts ) ); ?>' :value="value" @update="updateValue"></component>
</div>
