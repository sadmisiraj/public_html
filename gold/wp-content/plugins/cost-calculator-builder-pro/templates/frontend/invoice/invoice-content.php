<style>
	.ccb-invoice {
		display: block !important;
		background: #fff;
		font-family: Arial, Helvetica, sans-serif, sans-serif;
		min-width: 700px;
	}

	.ccb-invoice-table__contact {
		width: 100%;
		display: inline-block;
		border-top: 1px solid #000;
		vertical-align: top;
	}

	.ccb-invoice-table__contact ul {
		padding: 0 !important;
		list-style: none;
		width: 95%;
		margin-left: 20px !important;
	}

	.ccb-invoice-table__contact ul li {
		margin-bottom: 18px !important;
	}

	.ccb-invoice-table__contact ul li span {
		font-size: 12px;
		font-style: normal;
		display: block;
		word-wrap: break-word;
	}

	.ccb-invoice-table__contact ul li .name {
		font-weight: 700;
	}

	.ccb-invoice-table__contact ul li .value {
		font-weight: normal;
	}

	.ccb-invoice-table__contact ul li span:first-child {
		text-transform: capitalize;
	}

	.ccb-invoice-table__title {
		color: #000;
		font-size: 20px;
		font-weight: 700;
		display: block;
		margin: 25px 20px !important;
		width: 90%;
	}
</style>

<div class="ccb-invoice">
	<div class="ccb-invoice-table__contact">
		<span class="ccb-invoice-table__title"><?php echo esc_html__( 'Contact Information', 'cost-calculator-builder-pro' ); ?></span>
		<ul>
			<li>
				<span class="name"><?php echo esc_html__( 'Name', 'cost-calculator-builder-pro' ); ?>:</span>
				<span class="value"><?php echo esc_html( $name ); ?></span>
			</li>
			<li>
				<span class="name"><?php echo esc_html__( 'Message', 'cost-calculator-builder-pro' ); ?>:</span>
				<span class="value"><?php echo esc_html( $message ); ?></span>
			</li>
		</ul>
	</div>
</div>
