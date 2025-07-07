<div class="modal fade" id="accountInvoiceReceiptModal" tabindex="-1" role="dialog" aria-hidden="true"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form role="form" method="POST" class="actionRoute" action="" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="text-center mb-5">
                        <h3 class="mb-1">@lang('Payment Information')</h3>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <small class="text-cap text-secondary mb-0">@lang('Amount paid:')</small>
                            <h5 class="amount"></h5>
                            <small class="amount-in-words text-success"></small>
                        </div>

                        <div class="col-md-4 mb-3 mb-md-0">
                            <small class="text-cap text-secondary mb-0">@lang('Date paid:')</small>
                            <span class="text-dark date"></span>
                        </div>

                        <div class="col-md-4">
                            <small class="text-cap text-secondary mb-0">@lang('Payment method:')</small>
                            <div class="d-flex align-items-center">
                                <img class="avatar avatar-xss me-2 gateway_modal_image" src="" alt="Image Description">
                                <span class="text-dark method"></span>
                            </div>
                        </div>
                    </div>

                    <small class="text-cap mb-2">@lang('Summary')</small>
                    <ul class="list-group mb-4 payment_information">
                    </ul>

                    <div class="get-feedback">


                    </div>



                    <div class="modal-footer-text mt-3">
                        <div class="d-flex justify-content-end gap-3 status-buttons">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                            <input type="hidden" class="action_id" name="id">
                            <button type="submit" class="btn btn-success btn-sm" name="status"
                                    value="1">@lang('Approved')</button>
                            <button type="submit" class="btn btn-danger btn-sm" name="status"
                                    value="3"> @lang('Rejected')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
    <script>
        "use strict";
        
        // Function to convert number to words
        function numberToWords(num) {
            const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            
            if (num === 0) return 'Zero';
            
            function convertLessThanOneThousand(num) {
                if (num === 0) return '';
                if (num < 20) return ones[num];
                const ten = Math.floor(num / 10);
                const unit = num % 10;
                return tens[ten] + (unit ? ' ' + ones[unit] : '');
            }
            
            function convert(num) {
                if (num === 0) return 'Zero';
                let result = '';
                
                // Handle crores (10,000,000+)
                if (num >= 10000000) {
                    result += convert(Math.floor(num / 10000000)) + ' Crore ';
                    num %= 10000000;
                }
                
                // Handle lakhs (100,000+)
                if (num >= 100000) {
                    result += convert(Math.floor(num / 100000)) + ' Lakh ';
                    num %= 100000;
                }
                
                // Handle thousands (1,000+)
                if (num >= 1000) {
                    result += convertLessThanOneThousand(Math.floor(num / 1000)) + ' Thousand ';
                    num %= 1000;
                }
                
                // Handle hundreds
                if (num >= 100) {
                    result += ones[Math.floor(num / 100)] + ' Hundred ';
                    num %= 100;
                }
                
                // Handle tens and ones
                if (num > 0) {
                    if (result !== '') result += 'and ';
                    result += convertLessThanOneThousand(num);
                }
                
                return result;
            }
            
            // Split number into integer and decimal parts
            const parts = num.toString().split('.');
            let result = convert(parseInt(parts[0]));
            
            // Handle decimal part
            if (parts.length > 1) {
                result += ' Point';
                for (let i = 0; i < parts[1].length; i++) {
                    result += ' ' + ones[parseInt(parts[1][i])];
                }
            }
            
            return result;
        }
        
        $(document).on("click", '.edit_btn', function (e) {
            let id = $(this).data('id');
            let status = $(this).data('status');
            let feedback = $(this).data('feedback')
            $('.gateway_modal_image').attr('src', $(this).data('gatewayimage'))

            if (status == 1) {
                $(".status-buttons button[name='status']").hide();
            }

            $(".action_id").val(id);
            $(".actionRoute").attr('action', $(this).data('action'));

            let details = Object.entries($(this).data('detailsinfo'));
            let list = details.map(([key, value]) => {

                let field_name = value.field_name;
                let field_value = value.field_value;
                let field_name_text = field_name.replace(/_/g, ' ');


                if (value.type === 'file') {
                    return `<li class="list-group-item text-dark">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <a href="${field_value}" target="_blank"><img src="${field_value}" alt="Image Description" class="rounded-1" width="100"></a>
                                    </div>
                                </li>`;
                } else {
                    return `<li class="list-group-item text-dark">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <span>${field_value}</span>
                                    </div>
                                </li>`;
                }
            })

            let feedbackField = "";
            if (feedback == '') {
                feedbackField = `
                                <div class="mb-3">
                                    <small class="text-cap mb-2">@lang('Send Your Feedback')</small>
                                    <textarea name="feedback" class="form-control feedback" placeholder="Feedback" rows="3" >{{old('feedback')}}</textarea>
                                    @error('feedback')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>`;

            } else {
                feedbackField = `<div class="mb-3">
                                    <small class="text-cap mb-2">@lang('Feedback')</small>
                                    <p>${feedback}</p>
                                 </div>`;
            }
            $('.get-feedback').html(feedbackField)
            $('.payment_information').html(list);
            $('.image').html(list);
            
            // Set amount and convert to words
            let amount = $(this).data('amount');
            $('.amount').html(amount);
            
            // Extract the numeric value from the amount string (removing currency symbol and commas)
            let numericAmount = amount.replace(/[^\d.-]/g, '');
            let amountInWords = numberToWords(parseFloat(numericAmount));
            
            // Add currency code if present in the amount string
            let currencyMatch = amount.match(/[A-Z]{3}$/);
            let currencyCode = currencyMatch ? currencyMatch[0] : '';
            
            $('.amount-in-words').html(amountInWords + (currencyCode ? ' ' + currencyCode : ''));
            
            $('.method').html($(this).data('method'));
            $('.date').html($(this).data('datepaid'));

        });
    </script>
@endpush

