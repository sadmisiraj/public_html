<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="x-apple-disable-message-reformatting">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="telephone=no" name="format-detection">
	<title>Order</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Eudoxus+Sans:wght@400;700&display=swap');
		h1, p, span {
			margin: 0;
			padding: 0;
		}

		a {
			text-transform: none;
			text-decoration: none;
		}

		.text-right {
			text-align: right;
		}

		.body {
			margin:0;
			font-family:-apple-system, 'Eudoxus Sans', Sans-serif;
			color:#001931;
		}

		.wrapper {
			background-color: #EEF1F7;
			max-width: 800px;
			margin: 0 auto;
			background-image: url(<?php echo esc_attr( CALC_URL . '/frontend/dist/img/email-bg.png' ); ?>);
			background-repeat: no-repeat;
			background-size: 100% 35%;
		}

		.table-body {
			max-width: 600px;
			margin: 0px auto;
			position: relative;
			z-index: 99999;
		}

		.table-body-row {
			max-width: 600px;
		}

		.table-header {
			margin: 0 auto;
			background: #001931;
		}

		.table-header-wrapper {
			max-width: 600px;
			margin: 0 auto;
			height: 80px;
			padding-top: 50px;
		}

		.header__logo img {
			max-height: 150px;
		}

		.email-title {
			font-family: 'Eudoxus Sans', Sans-serif;
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			color: #fff;
		}

		.order {
			width: 100%;
			color: #fff;
		}

		.order-link {
			padding: 10px 20px;
			border-radius: 4px;
			background-color: #00B163;
			color: #fff !important;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			transition: 300ms ease;
		}

		.order-link:hover {
			background-color: #029755;
		}

		.order-item {
			width: 49%;
			font-weight: 500;
			font-size: 16px;
			display: inline-block;
			line-height: 20px;
		}

		.summary {
			margin: 0 auto;
			max-width: 600px;
			background: #fff;
			margin-top: 30px;
		}

		.summary-container {
			padding: 40px;
			margin-bottom: 20px;
		}

		.summary-order {
			font-size: 20px;
			font-weight: 700;
			margin-bottom: 20px;
		}

		.summary-title {
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
		}

		.summary-list-item {
			padding: 15px 0;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
			border-bottom: 1px solid #EEEEEE;
		}

		.summary-list-group {
			padding-left: 15px;
			margin-bottom: 15px;
			border-bottom: 1px solid <?php echo esc_attr( $email_settings['border_color']['value'] ); ?>;
			padding-bottom: 5px;
		}

		.summary-list-group.break-border {
			border: none;
		}

		.summary-list-group .summary-list-item {
			padding: 5px 0 0 0 !important;
			margin-bottom: 0 !important;
			border: none !important;
		}

		.summary-list-group .summary-list-item .summary-list-item-name,
		.summary-list-group .summary-list-item .summary-list-item-value {
			font-weight: 500 !important;
		}

		.summary-list-group-title {
			font-weight: 800;
			font-size: 14px;
		}

		.summary-list-item.break-border {
			border-bottom: none !important;
		}

		.summary-list-item-name {
			width: 49%;
			display: inline-block;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.summary-list-item-value {
			width: 50%;
			display: inline-block;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			text-align: right;
		}

		.summary-list-sub-items li::marker {
			color:  #00193180;
			opacity: 0.1;
		}

		.summary-list-sub-items li {
			margin-bottom: 10px;
		}

		.summary-total {
			max-width: 600px;
			padding: 7px 0;
			border-top: 2px solid #EEEEEE;
		}

		.summary-total-item {
			display: inline-block;
			font-style: normal;
			font-weight: 700;
			font-size: 18px;
			line-height: 23px;
		}

		.other-totals {
			border-top: 1px dashed #ccc;
			padding: 2px 0;
		}

		.other-totals .summary-total-item {
			font-size: 14px;
		}

		.summary-files-list {
			list-style: none;
			margin: 20px 0;
			padding: 0;
		}

		.summary-files-list-item {
			padding: 3px 10px;
			border: 1px solid #EEEEEE;
			border-radius: 4px;
			margin-bottom: 10px;
		}

		.summary-files-icon {
			display: inline-block;
			margin-right: 15px;
		}

		.summary-files-icon img {
			margin-bottom: 3px;
		}

		.summary-files-info {
			display: inline-block;
		}

		.summary-files-info .title {
			display: inline-block;
			width: 100%;
			font-style: normal;
			font-weight: 700;
			font-size: 12px;
			line-height: 15px;
		}

		.summary-files-info .filename {
			display: inline-block;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.summary-files-link {
			background-color: #EEF1F7;
			padding: 9px 20px;
			border-radius: 4px;
			text-decoration: none;
			text-transform: none;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			color: #001931;
			transition: 300ms ease;
			float: right;
			margin-top: 2px;
		}

		.summary-files-link:hover {
			background-color: #dbdbdb;
		}

		.table-contact {
			margin: 0px auto;
			max-width: 600px;
			background-color: #fff;
			margin-bottom: 50px;
		}

		.table-contact-container {
			padding: 40px;
		}

		.table-contact-title {
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			margin-bottom: 20px;
		}

		.table-contact-item {
			margin-bottom: 10px;
		}

		.table-contact-label {
			font-style: normal;
			font-weight: 700;
			font-size: 13px;
			line-height: 16px;
			margin-right: 4px;
		}

		.table-contact-value {
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.table-contact-value.break {
			display: block;
		}

		.table-contact-value a {
			color: #1AB163;
		}

		.table-contact-value a:hover {
			color: #029755;
		}

		.show-unit .summary-list {
			padding: 0 10px;
		}

		.show-unit .summary-list .summary-list-item {
			padding: 5px 0 10px 0;
			border: none;
			border-bottom: 1px dashed #ccc;
			margin-bottom: 5px;
		}

		.show-unit .summary-list .summary-list-item:last-child {
			border: none;
		}

		.show-unit .summary-list .summary-list-item-name,
		.show-unit .summary-list .summary-list-item-value {
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			color: #001931;
		}

		.show-unit .summary-list-item-name {
			width: 49%;
		}

		.show-unit .summary-list-sub-items {
			padding: 5px 0 5px 35px;
			margin: 0px;
			list-style: none;
		}

		.show-unit .summary-list-sub-items li div {
			font-style: normal !important;
			font-weight: 500 !important;
			font-size: 12px !important;
			line-height: 15px !important;
			color: #000 !important;
			opacity: 0.7 !important;
		}

		.show-unit .summary-list-sub-items li {
			margin-bottom: 5px;
		}

		.show-unit .summary-list-sub-items li .summary-list-item-value {
			margin-left: 5px !important;
		}

		.show-unit .summary-list-item-value {
			width: 50%;
			display: inline-block;
			text-align: right;
			word-break: break-all;
		}

		.show-unit .summary-total {
			width: 500px;
			margin: 15px auto;
		}

		.summary-list-item-unit {
			width: 100%;
			display: none;
			font-style: normal;
			font-weight: 500;
			font-size: 12px;
			line-height: 18px;
			color: #000;
			opacity: 0.7;
			padding-left: 35px;
		}

		.calc-subtotal-list-header {
			display: flex;
			padding: 5px 10px;
			background-color: #EEEEEE;
			margin-bottom: 5px;
		}
		.calc-subtotal-list-header span {
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			display: inline-block;
		}

		.calc-subtotal-list-header__name {
			width: 49%;
		}


		.calc-subtotal-list-header__value {
			width: 49%;
			text-align: right;
		}

		.show-unit .summary-list-item-unit {
			display: inline-block !important;
		}

		.show-unit .summary-list-item-space {
			display: block;
		}

		.show-unit .summary-list-sub-items .summary-list-item-name,
		.show-unit .summary-list-sub-items .summary-list-item-value {
			width: auto !important;
		}

		@media (max-width: 540px) {
			.email-title {
				font-size: 20px;
			}

			.order-item {
				font-size: 14px;
			}

			.summary-container {
				padding: 20px 10px;
			}

			.summary-title {
				font-size: 20px;
			}

			.summary-list-item {
				padding: 10px 0;
			}

			.summary-list-item-name {
				font-size: 12px;
				line-height: 14px;
				width: 48%;
			}

			.summary-list-item-value {
				font-size: 12px;
				line-height: 14px;
			}

			.summary-list-sub-items {
				padding: 0 0 0 28px;
				margin: 4px 0;
			}

			.summary-list-sub-items li {
				margin-bottom: 6px;
			}

			.summary-total-item {
				font-size: 16px;
			}

			.summary-files-link {
				display: block;
				float: none;
				text-align: center;
				margin-top: 10px;
			}

			.footer-wrapper span {
				font-size: 12px;
			}
		}

		.ccb-discount-wrapper {
			display: inline-block;
			width: 49%;
		}

		.ccb-discount-wrapper-right {
			text-align: right;
			width: 50%;
		}

		.ccb-discount-off {
			font-size: 10px !important;
			font-weight: 500;
			color: <?php echo esc_attr( $email_settings['content_bg']['value'] ); ?>;
			background: <?php echo esc_attr( $email_settings['button_color']['value'] ); ?>;
			padding: 2px 4px;
			border-radius: 4px;
			vertical-align: middle;
			display: inline !important;
			line-height: 1.1 !important;
		}

	</style>
</head>

<body width="100%" class="body">
	<div class="wrapper">
		<div class="table-header">
			<div class="table-header-wrapper">
				<p class="email-title"><?php esc_html_e( 'Calculation result', 'cost-calculator-builder-pro' ); ?></p>
				<div class="order">
					<p class="order-item"><?php echo esc_html( date_i18n( 'F j Y' ) ); ?></p>
					<p class="order-item text-right">
						<a href="<?php echo esc_attr( home_url( '/' ) . 'wp-admin/admin.php?page=cost_calculator_orders' ); ?>" class="order-link"><?php esc_html_e( 'Manage Order', 'cost-calculator-builder-pro' ); ?></a>
					</p>
				</div>
			</div>
		</div>
		<table width="100%">
			<tbody class="table-body">
			<tr class="table-body-row">
				<td>
					<div class="summary <?php $show_unit ? esc_attr_e( 'show-unit' ) : ''; ?>">
						<div class="summary-container">
						<?php if ( ! empty( $order_id ) ) : ?>
							<div class="summary-order">
								<?php esc_html_e( 'Order ID', 'cost-calculator-builder-pro' ); ?>: <?php echo esc_html( $order_id ); ?>
							</div>
						<?php endif; ?>
							<?php if ( $show_unit ) : ?>
								<div class="calc-subtotal-list-header">
									<span class="calc-subtotal-list-header__name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
									<span class="calc-subtotal-list-header__value"><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></span>
								</div>
							<?php endif; ?>
							<div class="summary-list">
								<?php
								$fieldsLastItem = array_key_last( $fields );
								if ( isset( $fields ) && count( $fields ) > 0 ) {
									foreach ( $fields as $key => $value ) {
										if ( str_contains( $value['alias'], 'repeater' ) ) {
											?>
											<div class="summary-list-group <?php count( $fields ) - 1 === $key ? esc_attr_e( 'break-border' ) : ''; ?>">
											<?php if ( isset( $value['groupTitle'] ) ) : ?>
													<div class="summary-list-group-title"><?php echo esc_html( $value['groupTitle'] ); ?></div>
												<?php else : ?>
													<?php if ( isset( $value['label'] ) ) : ?>
														<div class="summary-list-group-title"><?php echo esc_html( $value['label'] ); ?></div>
													<?php endif; ?>
												<?php endif; ?>
											<?php foreach ( $value['groupElements'] as $child ) { ?>
													<div class="summary-list-item">
														<div class="summary-list-item-name">
															<?php echo isset( $child['label'] ) ? esc_html( ucfirst( $child['label'] ) ) : ''; ?>
														</div>
														<?php if ( isset( $child['summary_view'] ) && 'show_value' !== $child['summary_view'] ) : ?>
															<?php if ( isset( $child['extraViewMultiple'] ) ) : ?>
																<div class="summary-list-item-value">
																	<?php foreach ( $child['extraViewMultiple'] as $extraLabel ) : ?>
																		<?php echo esc_html( $extraLabel ) . '<br>'; ?>
																	<?php endforeach; ?>
																</div>
															<?php else : ?>
																<div class="summary-list-item-value">
																	<?php echo esc_html( $child['extraView'] ); ?>
																</div>
															<?php endif; ?>
														<?php else : ?>
															<div class="summary-list-item-value">
																<?php echo esc_html( $child['converted'] ); ?>
															</div>
														<?php endif; ?>
														<?php if ( isset( $child['option_unit'] ) && ! str_contains( $child['alias'], 'geolocation' ) ) : ?>
															<div class="summary-list-item-unit">
																<?php echo isset( $child['option_unit'] ) ? esc_html( ucfirst( $child['option_unit'] ) ) : ''; ?>
															</div>
														<?php endif; ?>
														<?php if ( isset( $child['userSelectedOptions'] ) ) : ?>
															<ul class="summary-list-sub-items">
																<?php if ( ! isset( $child['userSelectedOptions']['twoPoints'] ) ) : ?>
																	<li>
																		<div class="summary-list-item-name">
																			<a href="<?php echo esc_attr( $child['userSelectedOptions']['addressLink'] ); ?>" target="_blank"><?php echo esc_html( $child['userSelectedOptions']['addressName'] ); ?></a>
																		</div>
																	</li>
																<?php endif; ?>
																<?php if ( isset( $child['userSelectedOptions']['twoPoints'] ) ) : ?>
																	<li class="geolocation-row">
																		<div class="summary-list-item-name">
																			<?php esc_html_e( 'From:', 'cost-calculator-builder-pro' ); ?>
																		</div>
																		<div class="summary-list-item-value">
																			<a href="<?php echo esc_attr( $child['userSelectedOptions']['twoPoints']['from']['addressLink'] ); ?>" style="margin-left: -5px;" target="_blank">
																				<?php
																					$innerFromAddress = $child['userSelectedOptions']['twoPoints']['from']['addressName'];
																					$innerFromAddress = strlen( $innerFromAddress ) > 35 ? substr( $innerFromAddress, 0, 35 ) . '...' : $innerFromAddress;
																					echo esc_html( $innerFromAddress );
																				?>
																			</a>
																		</div>
																	</li>
																	<li class="geolocation-row">
																		<div class="summary-list-item-name">
																			<?php esc_html_e( 'To:', 'cost-calculator-builder-pro' ); ?>
																		</div>
																		<div class="summary-list-item-value">
																			<a href="<?php echo esc_attr( $child['userSelectedOptions']['twoPoints']['to']['addressLink'] ); ?>" style="margin-left: -5px;" target="_blank">
																				<?php
																					$innerToAddress = $child['userSelectedOptions']['twoPoints']['to']['addressName'];
																					$innerToAddress = strlen( $innerToAddress ) > 35 ? substr( $innerToAddress, 0, 35 ) . '...' : $innerToAddress;
																					echo esc_html( $innerToAddress );
																				?>
																			</a>
																		</div>
																	</li>
																<?php endif ?>
																<?php if ( isset( $child['userSelectedOptions']['distance'] ) ) : ?>
																	<li>
																		<div class="summary-list-item-name">
																			<?php
																				esc_html_e( 'Distance: ', 'cost-calculator-builder-pro' );
																				echo esc_html( $child['userSelectedOptions']['distance_view'] );
																			?>
																		</div>
																	</li>
																<?php endif; ?>
															</ul>
														<?php endif; ?>
														<?php if ( isset( $child['has_options'] ) ) : ?>
															<?php if ( count( $child['options'] ) ) : ?>
																<ul class="summary-list-sub-items">
																	<?php foreach ( $child['options'] as $child_option ) : ?>
																		<li>
																			<?php
																			if ( isset( $child['summary_view'] ) && 'show_value' === $child['summary_view'] ) :
																				?>
																				<div class="summary-list-item-name">
																					<?php echo esc_html( $child_option['label'] ); ?>
																				</div>
																				<div class="summary-list-item-value">
																					<?php
																					if ( count( $child['options'] ) > 1 ) {
																						echo esc_html( $child_option['converted'] );
																					}
																					?>
																				</div>
																			<?php endif; ?>
																		</li>
																	<?php endforeach; ?>
																</ul>
															<?php endif; ?>
														<?php endif; ?>
													</div>
													<?php
											}
											?>
											</div>
											<?php
											}  elseif ( str_contains( $value['alias'], 'file_upload' ) && ! $value['allowPrice'] ) { //phpcs:ignore ?>
											<div class="summary-list-item <?php count( $fields ) - 1 === $key ? esc_attr_e( 'break-border' ) : ''; ?>">
												<div class="summary-list-item-name">
													<?php echo esc_html( ucfirst( $value['label'] ) ); ?>
												</div>
												<?php if ( isset( $value['option_unit'] ) ) { ?>
													<div class="summary-list-item-value">
														<?php echo esc_html( $value['option_unit'] ); ?>
													</div>
												<?php } ?>
											</div>
											<?php
											} elseif ( ! str_contains( $value['alias'], 'total' ) && ( ! isset( $value['hidden'] ) || ! $value['hidden'] ) && ! str_contains( $value['alias'], 'repeater' ) ) { //phpcs:ignore ?>
											<div class="summary-list-item <?php $fieldsLastItem === $key ? esc_attr_e( 'break-border' ) : ''; ?>">
												<div class="summary-list-item-name">
													<?php echo esc_html( ucfirst( $value['label'] ) ); ?>
												</div>
												<?php if ( isset( $value['summary_view'] ) && 'show_value' !== $value['summary_view'] ) : ?>
													<?php if ( isset( $value['extraViewMultiple'] ) ) : ?>
														<div class="summary-list-item-value">
															<?php foreach ( $value['extraViewMultiple'] as $extraLabel ) : ?>
																<?php echo esc_html( $extraLabel ) . '<br>'; ?>
															<?php endforeach; ?>
														</div>
													<?php else : ?>
														<div class="summary-list-item-value">
															<?php echo esc_html( $value['extraView'] ); ?>
														</div>
													<?php endif; ?>
												<?php else : ?>
													<?php if ( isset( $value['converted'] ) ) { ?>
														<div class="summary-list-item-value">
															<?php echo esc_html( $value['converted'] ); ?>
														</div>
													<?php } ?>
												<?php endif; ?>
												<?php if ( isset( $value['option_unit'] ) && ! str_contains( $value['alias'], 'geolocation' ) ) : ?>
													<div class="summary-list-item-unit">
														<?php echo isset( $value['option_unit'] ) ? esc_html( ucfirst( $value['option_unit'] ) ) : ''; ?>
													</div>
												<?php endif; ?>
													<?php if ( isset( $value['userSelectedOptions'] ) ) : ?>
													<ul class="summary-list-sub-items">
														<?php if ( ! isset( $value['userSelectedOptions']['twoPoints'] ) ) : ?>
															<li>
																<div class="summary-list-item-name">
																	<a href="<?php echo esc_attr( $value['userSelectedOptions']['addressLink'] ); ?>" target="_blank"><?php echo esc_html( $value['userSelectedOptions']['addressName'] ); ?></a>
																</div>
															</li>
														<?php endif; ?>
														<?php if ( isset( $value['userSelectedOptions']['twoPoints'] ) ) : ?>
															<li class="geolocation-row">
																<div class="summary-list-item-name">
																	<?php esc_html_e( 'From:', 'cost-calculator-builder-pro' ); ?>
																</div>
																<div class="summary-list-item-value">
																	<a href="<?php echo esc_attr( $value['userSelectedOptions']['twoPoints']['from']['addressLink'] ); ?>" style="margin-left: -5px;" target="_blank">
																		<?php
																			$fromAddress = $value['userSelectedOptions']['twoPoints']['from']['addressName'];
																			$fromAddress = strlen( $fromAddress ) > 35 ? substr( $fromAddress, 0, 35 ) . '...' : $fromAddress;
																			echo esc_html( $fromAddress );
																		?>
																	</a>
																</div>
															</li>
															<li class="geolocation-row">
																<div class="summary-list-item-name">
																	<?php esc_html_e( 'To:', 'cost-calculator-builder-pro' ); ?>
																</div>
																<div class="summary-list-item-value">
																	<a href="<?php echo esc_attr( $value['userSelectedOptions']['twoPoints']['to']['addressLink'] ); ?>" style="margin-left: -5px;" target="_blank">
																		<?php
																			$toAddress = $value['userSelectedOptions']['twoPoints']['to']['addressName'];
																			$toAddress = strlen( $toAddress ) > 35 ? substr( $toAddress, 0, 35 ) . '...' : $toAddress;
																			echo esc_html( $toAddress );
																		?>
																	</a>
																</div>
															</li>
														<?php endif ?>
														<?php if ( isset( $value['userSelectedOptions']['distance'] ) ) : ?>
															<li>
																<div class="summary-list-item-name">
																	<?php
																		esc_html_e( 'Distance: ', 'cost-calculator-builder-pro' );
																		echo esc_html( $value['userSelectedOptions']['distance_view'] )
																	?>
																</div>
															</li>
														<?php endif; ?>
													</ul>
												<?php endif; ?>
													<?php if ( isset( $value['has_options'] ) ) : ?>
														<?php if ( count( $value['options'] ) ) : ?>
														<ul class="summary-list-sub-items">
															<?php foreach ( $value['options'] as $option ) : ?>
																<li>
																	<?php
																	if ( isset( $value['summary_view'] ) && 'show_value' === $value['summary_view'] ) :
																		?>
																		<div class="summary-list-item-name">
																			<?php echo esc_html( $option['label'] ); ?>
																		</div>
																		<div class="summary-list-item-value">
																			<?php
																			if ( count( $value['options'] ) > 1 ) {
																				echo esc_html( $option['converted'] );
																			}
																			?>
																		</div>
																	<?php endif; ?>
																</li>
															<?php endforeach; ?>
														</ul>
													<?php endif; ?>
												<?php endif; ?>
											</div>
											<?php
										}
									}
								}
								?>
							</div>
							<?php if ( isset( $other_totals ) && count( $other_totals ) ) : ?>
								<div class="summary-total other-totals">
									<?php foreach ( $other_totals as $tot ) : ?>
										<div class="summary-total-item" style="vertical-align: middle; width: 48%;">
											<?php if ( isset( $tot['label'] ) ) : ?>
												<?php echo esc_html( $tot['label'] ); ?>
											<?php elseif ( isset( $tot['title'] ) ) : ?>
												<?php echo esc_html( $tot['title'] ); ?>
											<?php endif; ?>
										</div>
										<div class="summary-total-item text-right" style="width: 50%;">
											<?php if ( isset( $tot['value'] ) ) : ?>
												<?php echo esc_html( $tot['value'] ); ?>
											<?php elseif ( isset( $tot['converted'] ) ) : ?>
												<?php echo esc_html( $tot['converted'] ); ?>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<div class="summary-total">
								<?php if ( isset( $totals ) && count( $totals ) > 0 ) : ?>
									<?php foreach ( $totals as $total ) : ?>
										<?php if ( empty( $total['hidden'] ) ) : ?>
											<?php if ( empty( $total['hasDiscount'] ) ) : ?>
												<?php if ( isset( $total['label'] ) ) : ?>
													<div class="summary-total-item" style="vertical-align: middle; width: 48%;">
														<?php echo esc_html( $total['label'] ); ?>
													</div>
												<?php elseif ( isset( $total['title'] ) ) : ?>
													<div class="summary-total-item" style="vertical-align: middle; width: 48%;">
														<?php echo esc_html( $total['title'] ); ?>
													</div>
												<?php endif; ?>
												<div class="summary-total-item text-right" style="width: 50%;">
													<?php echo esc_html( $total['converted'] ); ?>
												</div>
											<?php else : ?>
												<?php if ( 'show_without_title' === $total['discount']['discountView'] ) : ?>
													<div class="ccb-discount-wrapper ccb-discount-wrapper-left">
														<div class="summary-total-item" style="vertical-align: middle">
															<?php if ( isset( $total['label'] ) ) : ?>
																<?php echo esc_html( $total['label'] ); ?>
															<?php elseif ( isset( $total['title'] ) ) : ?>
																<?php echo esc_html( $total['title'] ); ?>
															<?php endif; ?>
														</div>
														<div class="summary-total-item ccb-discount-off">
															<?php
															$discount_amount = '';
															if ( 'percent_of_amount' === $total['discount']['discountType'] ) {
																$discount_amount = intval( $total['discount']['discountAmount'] ) . '%';
															} else {
																$discount_amount = '-' . intval( $total['discount']['discountAmount'] );
															}
															?>
															<?php echo esc_html( $discount_amount ); ?> <?php esc_html_e( 'off', 'cost-calculator-builder-pro' ); ?>
														</div>
													</div>
													<div class="ccb-discount-wrapper ccb-discount-wrapper-right">
														<div class="summary-total-item" style="white-space: nowrap; font-size: 14px; font-weight: 500; text-decoration: line-through;"><?php echo esc_html( $total['discount']['original_converted'] ); ?></div>
														<div class="summary-total-item" style="white-space: nowrap"><?php echo esc_html( $total['converted'] ); ?></div>
													</div>
												<?php else : ?>
													<div class="ccb-discount-wrapper ccb-discount-wrapper-left">
														<div class="summary-total-item" style="vertical-align: middle">
															<?php esc_html_e( 'Discount', 'cost-calculator-builder-pro' ); ?>:
														</div>
														<div class="summary-total-item" style="vertical-align: middle">
															<?php echo esc_html( $total['discount']['discountTitle'] ); ?>
														</div>
													</div>
													<div class="ccb-discount-wrapper ccb-discount-wrapper-right">
														<div class="summary-total-item" style="white-space: nowrap; font-size: 14px; font-weight: 700;"><?php echo esc_html( $total['discount']['discountValue'] ); ?></div>
													</div>

													<div class="ccb-discount-wrapper ccb-discount-wrapper-left">
														<div class="summary-total-item" style="white-space: nowrap">
															<?php if ( isset( $total['label'] ) ) : ?>
																<?php echo esc_html( $total['label'] ); ?>
															<?php elseif ( isset( $total['title'] ) ) : ?>
																<?php echo esc_html( $total['title'] ); ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="ccb-discount-wrapper ccb-discount-wrapper-right">
														<div class="summary-total-item" style="white-space: nowrap;"><?php echo esc_html( $total['converted'] ); ?></div>
													</div>

												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $files ) ) : ?>
								<div class="summary-files">
									<ul class="summary-files-list">
										<?php foreach ( $files as $file ) : ?>
											<?php if ( ! empty( $file ) ) : ?>
												<?php foreach ( $file as $item ) : ?>
													<li class="summary-files-list-item">
														<div class="summary-files-icon">
															<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/file-text.png' ) ); ?>" width="20" alt="Email icon">
														</div>
														<div class="summary-files-info">
															<span class="title">Attach file:</span>
															<span class="filename">
																<?php
																$fileName = strlen( $item['filename'] ) > 25 ? substr( $item['filename'], 0, 25 ) . '...' : $item['filename'];
																echo esc_html( $fileName );
																?>
															</span>
														</div>
														<a href="<?php echo esc_url( $item['url'] ); ?>" class="summary-files-link">
															<?php esc_html_e( 'Download', 'cost-calculator-builder-pro' ); ?>
														</a>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</td>
			</tr>
			<tr class="table-body-row">
				<td>
					<div class="table-contact">
						<div class="table-contact-container">
							<div class="table-contact-title">
								<?php esc_html_e( 'Customer Info', 'cost-calculator-builder-pro' ); ?>
							</div>
							<div class="table-contact-list">
								<?php if ( ! empty( $send_fields ) ) : ?>
									<?php foreach ( $send_fields as $field ) : ?>
										<?php if ( 'phone' === $field['name'] || 'email' === $field['name'] ) : ?>
											<div class="table-contact-item">
												<span class="table-contact-label"><?php echo 'phone' === $field['name'] ? esc_html__( 'Phone', 'cost-calculator-builder-pro' ) : esc_html__( 'Email', 'cost-calculator-builder-pro' ); ?>:</span>
												<span class="table-contact-value">
													<a href="<?php echo 'phone' === $field['name'] ? 'tel:' . esc_attr( $field['value'] ) : 'mailto:' . esc_attr( $field['value'] ); ?>">
														<?php echo esc_html( $field['value'] ); ?>
													</a>
												</span>
											</div>
										<?php else : ?>
											<div class="table-contact-item">
												<span class="table-contact-label" style="text-transform: capitalize;"><?php echo esc_html( isset( $field['attributes']['label'] ) ? $field['attributes']['label'] : $field['name'] ); ?>:</span>
												<span class="table-contact-value">
													<?php if ( is_array( $field['value'] ) ) : ?>
														<?php echo esc_html( implode( ', ', $field['value'] ) ); ?>
													<?php else : ?>
														<?php if ( isset( $field['attributes']['label'] ) && 'formatted-text' === $field['type'] ) : ?>
															<?php echo wp_kses_post( $field['value'] ); ?>
														<?php else : ?>
															<?php echo esc_html( $field['value'] ); ?>
														<?php endif; ?>
													<?php endif; ?>
												</span>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</body>

</html>
