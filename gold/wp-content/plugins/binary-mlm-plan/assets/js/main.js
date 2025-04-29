var $ = jQuery.noConflict();
var bmpajaxurl = $('meta[name="bmp_adminajax"]').attr('content');
$('#auto_add_bmp_user_fill').click(function (e) {
	e.preventDefault();
	const number = $('#number').val();
	const sponsor = $('#sponsor').val();
	const epin = $('#epin').val();
	const position = $('#position').val();
	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_auto_add',
			'number': number,
			'sponsor': sponsor,
			'epin': epin,
			'position': position,
		},
		success: function (data) {
			$('.bmp_username_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_username_message').html(obj.message);
				$('#bmp_username').val('');
			} else {
				$('.bmp_username_message').html(obj.message);

			}
			return false;
		}
	});
});


// user name exist check
$('#bmp_username').blur(function () {
	const username = $('#bmp_username').val();
	const nonce = $('#bmp_nonce').val();
	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_username_exist',
			'username': username,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_username_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_username_message').html(obj.message);
				$('#bmp_username').val('');
			} else {
				$('.bmp_username_message').html(obj.message);
			}
			return false;
		}
	});

});
// user name exist check
$('#bmp_position').on('change', function () {
	const position = $('#bmp_position').val();
	const sponsor = $('#bmp_sponsor_id').val();
	const nonce = $('#bmp_nonce').val();
	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_position_exist',
			'position': position,
			'sponsor': sponsor,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_position_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_position_message').html(obj.message);
				$('#bmp_position').val('');
			} else {
				$('.bmp_position_message').html(obj.message);

			}
			return false;
		}
	});

});



// user email exist check
$('#bmp_email').blur(function () {
	const email = $('#bmp_email').val();
	const nonce = $('#bmp_nonce').val();
	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_email_exist',
			'email': email,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_email_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_email_message').html(obj.message);
				$('#bmp_email').val('');
			} else {
				$('.bmp_email_message').html(obj.message);

			}
			return false;
		}
	});

});


// user epin exist check
$('#bmp_epin').blur(function () {
	const epin = $('#bmp_epin').val();
	const nonce = $('#bmp_nonce').val();

	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_epin_exist',
			'epin': epin,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_epin_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_epin_message').html(obj.message);
				$('#bmp_epin').val('');
			} else {
				$('.bmp_epin_message').html(obj.message);

			}
			return false;
		}
	});

});// update epin
$('#epin_value').blur(function () {

	const epin = $('#epin_value').val();
	const nonce = $('#bmp_nonce').val();

	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_epin_exist',
			'epin': epin,
			'bmp_nonce': nonce

		},
		success: function (data) {
			$('.bmp_epin_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_epin_message').html(obj.message);
				$('#bmp_epin').val('');
			} else {
				$('.bmp_epin_message').html(obj.message);

			}
			return false;
		}
	});

});

$('#bmp_join_epin').blur(function () {

	const epin = $('#bmp_join_epin').val();
	const nonce = $('#bmp_nonce').val();

	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_epin_exist',
			'epin': epin,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_user_success_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_epin_join_message').html(obj.message);
				$('#bmp_join_epin').val('');
			} else {
				$('.bmp_epin_join_message').html(obj.message);
			}
			return false;
		}
	});

});
// user password exist check
$('#bmp_confirm_password').blur(function () {

	const password = $('#bmp_password').val();
	const confirm_password = $('#bmp_confirm_password').val();
	const nonce = $('#bmp_nonce').val();


	$.ajax({
		type: 'POST',
		url: bmpajaxurl,
		data: {
			'action': 'bmp_password_validation',
			'password': password,
			'confirm_password': confirm_password,
			'bmp_nonce': nonce
		},
		success: function (data) {
			$('.bmp_confirm_password_message').html('');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$('.bmp_confirm_password_message').html(obj.message);
				$('#bmp_confirm_password').val('');
				$('#bmp_password').val('');
			} else {
				$('.bmp_confirm_password_message').html(obj.message);

			}
			return false;
		}
	});

});


// Register form submit

$("#bmp_register_form").submit(function (e) {
	e.preventDefault();
	const form = $(this);
	const postdata = form.serialize();
	$.ajax({
		type: "POST",
		url: bmpajaxurl,
		data: postdata,
		beforeSend: function () {
			$('.layer').addClass('d-block');
		},
		success: function (data) {
			$('.layer').removeClass('d-block');
			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$.each(obj.error, function (key, value) {
					$('.' + key).html('<span style="color:red;">' + value + '</span>');
				});

			} else {
				$('#bmp_user_success_message').html(obj.message);
				$('#bmp_register_form').remove();
			}

		}
	});
	return false;
});

$("#bmp_join_network_form").submit(function (e) {
	e.preventDefault();
	const join_form = $(this);
	const postjoindata = join_form.serialize();
	$.ajax({
		type: "POST",
		url: bmpajaxurl,
		data: postjoindata,
		beforeSend: function () {
			$('.layer').addClass('d-block');
		},
		success: function (data) {
			$('.layer').removeClass('d-block');

			const obj = $.parseJSON(data);
			if (obj.status == false) {
				$.each(obj.error, function (key, value) {
					$('.' + key).html('<span style="color:red;">' + value + '</span>');
				});

			} else {
				$('#bmp_user_success_message').html(obj.message);
				// $('#bmp_join_network_form').remove();
			}

		}
	});
	return false;
});
