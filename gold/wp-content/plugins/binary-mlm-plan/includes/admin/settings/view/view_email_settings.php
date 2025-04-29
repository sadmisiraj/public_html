<div class="form-row">
	<?php $row_num = 0;
	$settings = get_option('bmp_manage_email');
	?>
	<div class="col-md-12">
		<h2><?php esc_html_e('Email Settings', 'binary-mlm-plan'); ?></h2>
	</div><br>

	<div class="email-shortcodes" style="background: #cecece1a;">
		<div class="col-md-12">
			<h4><?php esc_html_e('Please use the short code in the email description.', 'binary-mlm-plan'); ?></h4>
		</div>
		<table class="form-table text-center e_table_style">
			<tr>
				<td><?php esc_html_e('First Name', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[firstname]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Last Name', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[lastname]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Email', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[email]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('User Name', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[username]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Amount', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[amount]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Withdrawal', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[withdrawalmode]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Payout Id', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[payoutid]</td>
			</tr>
			<tr>
				<td><?php esc_html_e('Site Name', 'binary-mlm-plan'); ?></td>
				<td>:</td>
				<td>[sitename]</td>
			</tr>
		</table>
	</div>

	<div class="form-group">
		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<h5 for="bmp_payout_email" class="thick" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Payout Recieve Mail', 'binary-mlm-plan'); ?> </h5>
							<th scope="row"><label for=""><?php esc_html_e('Subject', 'binary-mlm-plan'); ?></label></th>

							<td><input name="bmp_runpayout_email_subject" id="bmp_runpayout_email_subject" type="text" style="" value="<?php echo esc_attr(isset($settings['bmp_runpayout_email_subject']) ? $settings['bmp_runpayout_email_subject'] : ''); ?>" required class="regular-text" placeholder="<?php esc_html_e('Subject', 'binary-mlm-plan'); ?>"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="bmp_payout_email_message"><?php esc_html_e('Message', 'binary-mlm-plan'); ?></label></th>
							<td>
								<textarea type="text" name="bmp_runpayout_email_message" rows="6" id="bmp_runpayout_email_message" class="form-control textareawidth" placeholder="<?php esc_html_e('Message', 'binary-mlm-plan'); ?>" required><?php echo esc_textarea(isset($settings['bmp_runpayout_email_message']) ? $settings['bmp_runpayout_email_message'] : ''); ?></textarea>
								<input type="checkbox" name="bmp_payout_mail" value="1" <?php echo (isset($settings['bmp_payout_mail']) && $settings['bmp_payout_mail'] == 1) ? 'checked' : ''; ?>> <?php esc_html_e('Enabled this Mail functionality', 'binary-mlm-plan'); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<h5 for="bmp_networkgrowing_email" class="thick" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Network Growing Mail', 'binary-mlm-plan'); ?> </h5>
							<th scope="row"><label for="bmp_networkgrowing_email_subject"><?php esc_html_e('Subject', 'binary-mlm-plan'); ?></label></th>

							<td><input name="bmp_networkgrowing_email_subject" id="bmp_networkgrowing_email_subject" type="text" style="" value="<?php echo esc_attr(isset($settings['bmp_networkgrowing_email_subject']) ? $settings['bmp_networkgrowing_email_subject'] : ''); ?>" required class="regular-text" placeholder="<?php esc_html_e('Subject', 'binary-mlm-plan'); ?>"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="bmp_networkgrowing_email_message"><?php esc_html_e('Message', 'binary-mlm-plan'); ?> </label></th>
							<td>
								<textarea type="text" name="bmp_networkgrowing_email_message" rows="6" id="bmp_networkgrowing_email_message" class="form-control textareawidth" placeholder="<?php esc_html_e('Message', 'binary-mlm-plan'); ?>" required><?php echo esc_textarea(isset($settings['bmp_networkgrowing_email_message']) ? $settings['bmp_networkgrowing_email_message'] : ''); ?></textarea>
								<input type="checkbox" name="bmp_networkgrowing_mail" value="1" <?php echo (isset($settings['bmp_networkgrowing_mail']) && $settings['bmp_networkgrowing_mail'] == 1) ? 'checked' : ''; ?>> <?php esc_html_e('Enabled this Mail functionality', 'binary-mlm-plan'); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="form-group ">
		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<h5 for="bmp_withdrawalInitiate_email" class="thick" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Withdrawal Initiated Mail', 'binary-mlm-plan'); ?> </h5>
							<th scope="row"><label for="bmp_withdrawalInitiate_email_subject"><?php esc_html_e('Subject', 'binary-mlm-plan'); ?> </label></th>
							<td><input name="bmp_withdrawalInitiate_email_subject" id="bmp_withdrawalInitiate_email_subject" type="text" style="" value="<?php echo esc_attr(isset($settings['bmp_withdrawalInitiate_email_subject']) ? $settings['bmp_withdrawalInitiate_email_subject'] : ''); ?>" required class="regular-text" placeholder="<?php esc_html_e('Subject', 'binary-mlm-plan'); ?>"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="bmp_withdrawalInitiate_email_message"><?php esc_html_e('Message', 'binary-mlm-plan'); ?> </label></th>
							<td>
								<textarea type="text" name="bmp_withdrawalInitiate_email_message" rows="6" id="bmp_withdrawalInitiate_email_message" class="form-control textareawidth" placeholder="<?php esc_html_e('Message', 'binary-mlm-plan'); ?>" required><?php echo esc_textarea(isset($settings['bmp_withdrawalInitiate_email_message']) ? $settings['bmp_withdrawalInitiate_email_message'] : ''); ?></textarea>
								<input type="checkbox" name="bmp_withdrawalInitiate_mail" value="1" <?php echo (isset($settings['bmp_withdrawalInitiate_mail']) && $settings['bmp_withdrawalInitiate_mail'] == 1) ? 'checked' : ''; ?>> <?php esc_html_e('Enabled this Mail functionality', 'binary-mlm-plan'); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="form-group ">
		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<h5 for="bmp_withdrawalProcess_email" class="thick" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Withdrawal Processed Mail', 'binary-mlm-plan'); ?> </h5>
							<th scope="row"><label for="bmp_withdrawalProcess_email_subject"><?php esc_html_e('Subject', 'binary-mlm-plan'); ?> </label></th>
							<td><input name="bmp_withdrawalProcess_email_subject" id="bmp_withdrawalProcess_email_subject" type="text" style="" value="<?php echo esc_attr(isset($settings['bmp_withdrawalProcess_email_subject']) ? $settings['bmp_withdrawalProcess_email_subject'] : ''); ?>" required class="regular-text" placeholder="<?php esc_html_e('Subject', 'binary-mlm-plan'); ?>"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 float-left">
			<div class="form-group ">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="bmp_withdrawalProcess_email_message"><?php esc_html_e('Message', 'binary-mlm-plan'); ?> </label></th>
							<td>
								<textarea type="text" name="bmp_withdrawalProcess_email_message" rows="6" id="bmp_withdrawalProcess_email_message" class="form-control textareawidth" placeholder="<?php esc_html_e('Message', 'binary-mlm-plan'); ?>" required><?php echo esc_textarea(isset($settings['bmp_withdrawalProcess_email_message']) ? $settings['bmp_withdrawalProcess_email_message'] : ''); ?></textarea>
								<input type="checkbox" name="bmp_withdrawalProcess_mail" value="1" <?php echo (isset($settings['bmp_withdrawalProcess_mail']) && $settings['bmp_withdrawalProcess_mail'] == 1) ? 'checked' : ''; ?>> <?php esc_html_e('Enabled this Mail functionality', 'binary-mlm-plan'); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>