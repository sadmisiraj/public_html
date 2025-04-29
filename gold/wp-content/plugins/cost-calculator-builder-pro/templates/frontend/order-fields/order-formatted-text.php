<?php
/**
 * @file
 * Order-custom-text component's template
 */
?>

<div class="ccb-order-custom-text" :class="[width, {'error': field.requiredStatus}]">
	<label>
		{{ label }}
	</label>
	<div class="ccb-order-custom-text__wrapper" :class="boxStyle">
		<div class="ccb-order-custom-text__content" v-html="fieldText"></div>
	</div>
</div>
