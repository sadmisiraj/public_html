@extends('admin.layouts.app')
@section('page_title',__('Withdraw Log'))
@section('content')

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0);">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0);">
                                    @lang('Withdraw Log')
                                </a>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Withdraw Log')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Total Withdraw")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $payoutRecord[0]['totalWithdrawLog'] }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $payoutRecord[0]['totalWithdrawLog'] }}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-info text-info p-1">
                                <i class="bi-graph-up"></i> {{ fractionNumber($payoutRecord[0]['totalWithdrawLog']) }}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Success Withdraw")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $payoutRecord[0]['successWithdraw'] }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $payoutRecord[0]['totalWithdrawLog'] }}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-success text-success p-1">
                                <i class="bi-graph-up"></i> {{ fractionNumber($payoutRecord[0]['successWithdrawPercentage']) }}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Pending Withdraw")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $payoutRecord[0]['pendingWithdraw'] }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $payoutRecord[0]['totalWithdrawLog'] }}</span>
                            </div>

                            <div class="col-auto">
                              <span class="badge bg-soft-warning text-warning p-1">
                                <i class="bi-graph-down"></i> {{ fractionNumber($payoutRecord[0]['pendingWithdrawPercentage']) }}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Cancel Withdraw")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $payoutRecord[0]['cancelWithdraw'] }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $payoutRecord[0]['totalWithdrawLog'] }}</span>
                            </div>

                            <div class="col-auto">
                                <span class="badge bg-soft-danger text-danger p-1">{{ fractionNumber($payoutRecord[0]['cancelWithdrawPercentage']) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="Test">
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <form>
                        <div class="input-group input-group-merge navbar-input-group">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input type="search" id="datatableSearch"
                                   class="search form-control form-control-sm"
                                   placeholder="@lang('Search here')"
                                   aria-label="@lang('Search here')"
                                   autocomplete="off">
                        </div>
                    </form>
                </div>

                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                    <div id="datatableCounterInfo">
                        <div class="d-flex align-items-center">
                            @if(adminAccessRoute(config('role.withdraw.access.edit')))
                                <a class="btn btn-outline-success btn-sm" href="javascript:void(0)" data-bs-toggle="modal"
                                   data-bs-target="#multiplePaymentRequestApproved">
                                    <i class="bi bi-check"></i> @lang('Approved')
                                </a>
                            @endif
                            
                        </div>
                    </div>
                    <!-- Export Dropdown Button -->
                    <div class="dropdown ms-2">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-download me-1"></i> @lang('Export')
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li>
                                        <a class="dropdown-item export-excel" href="{{ route('admin.export.payout.excel') }}" id="exportExcelLink">
                                            <i class="fa-regular fa-file-excel me-2"></i> @lang('Excel')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-pdf" href="{{ route('admin.export.payout.pdf') }}" id="exportPdfLink">
                                            <i class="fa-regular fa-file-pdf me-2"></i> @lang('PDF')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-white btn-sm w-100"
                                id="dropdownMenuClickable" data-bs-auto-close="false"
                                id="usersFilterDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi-filter me-1"></i> @lang('Filter')
                        </button>

                        <div
                            class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered filter_dropdown"
                            aria-labelledby="dropdownMenuClickable">
                            <div class="card">
                                <div class="card-header card-header-content-between">
                                    <h5 class="card-header-title">@lang('Filter')</h5>
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2"
                                            id="filter_close_btn">
                                        <i class="bi-x-lg"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <form id="filter_form">
                                        <div class="row">
                                            <div class="mb-4">
                                                <span class="text-cap text-body">@lang('Transaction ID')</span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="text" class="form-control"
                                                               id="transaction_id_filter_input"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm mb-4">
                                                <small class="text-cap text-body">@lang('Status')</small>
                                                <div class="tom-select-custom">
                                                    <select
                                                        class="js-select js-datatable-filter form-select form-select-sm"
                                                        id="filter_status"
                                                        data-target-column-index="4" data-hs-tom-select-options='{
                                                                  "placeholder": "Any status",
                                                                  "searchInDropdown": false,
                                                                  "hideSearch": true,
                                                                  "dropdownWidth": "10rem"
                                                                }'>
                                                        <option value="all"
                                                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-secondary"></span>All Status</span>'>
                                                            @lang('All Status')
                                                        </option>
                                                        <option value="1"
                                                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-warning"></span>Pending</span>'>
                                                            @lang('Pending')
                                                        </option>
                                                        <option value="2"
                                                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Success</span>'>
                                                            @lang('Success')
                                                        </option>
                                                        <option value="3"
                                                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Cancel</span>'>
                                                            @lang('Cancel')
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <span class="text-cap text-body">@lang('Method')</span>
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select" id="filter_method">
                                                        <option value="all"
                                                                data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ asset("assets/upload/payoutMethod/withdraw.png") }}" alt="" /><span class="text-truncate">All Withdraw Method</span></span>'>
                                                        @forelse($methods as $method)
                                                            <option value="@lang($method->id)"
                                                                    data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ getFile($method->driver, $method->logo) }}" alt="" /><span class="text-truncate">{{ $method->name }}</span></span>'>
                                                                @lang($method->name)
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 mb-4">
                                                <span class="text-cap text-body">@lang('Date Range')</span>
                                                <div class="input-group mb-3 custom">
                                                    <input type="text" id="filter_date_range"
                                                           class="js-flatpickr form-control"
                                                           placeholder="Select dates"
                                                           data-hs-flatpickr-options='{
                                                                 "dateFormat": "d/m/Y",
                                                                 "mode": "range"
                                                               }' aria-describedby="flatpickr_filter_date_range">
                                                    <span class="input-group-text" id="flatpickr_filter_date_range">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="d-grid">
                                                    <button type="button" id="clear_filter"
                                                            class="btn btn-white">@lang('Clear Filters')</button>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-grid">
                                                    <button type="button" class="btn btn-primary" id="filter_button"><i
                                                            class="bi-search"></i> @lang('Apply')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class=" table-responsive datatable-custom  ">
                <table id="datatable"
                       class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                       "columnDefs": [{
                          "targets": [0, 8],
                          "orderable": false
                        }],
                       "order": [],
                       "info": {
                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                       },
                       "search": "#datatableSearch",
                       "entries": "#datatableEntries",
                       "pageLength": 15,
                       "isResponsive": false,
                       "isShowPaging": false,
                       "pagination": "datatablePagination"
                     }'>
                    <thead class="thead-light">
                    <tr>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input check-all tic-check" type="checkbox" name="check-all"
                                       id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th>@lang('Trx Number')</th>
                        <th>@lang('User')</th>
                        <th>@lang('Method')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Charge')</th>
                        <th>@lang('Payout Amount')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">@lang('Showing:')</span>
                            <div class="tom-select-custom">
                                <select id="datatableEntries"
                                        class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                        data-hs-tom-select-options='{
                                            "searchInDropdown": false,
                                            "hideSearch": true
                                          }'>
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">of</span>
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex  justify-content-center justify-content-sm-end">
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="multiplePaymentRequestApproved" tabindex="-1" role="dialog" aria-labelledby="multiplePaymentRequestApprovedModalLabel" data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="multiplePaymentRequestApprovedModalLabel"><i
                            class="fa-light fa-square-check"></i> @lang('Confirmation')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        @lang('Do you want to approved all selected  data?')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary approved-multiple">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    @include('admin.user_management.components.payout_information_modal')
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
@endpush


@push('script')
    <script>
        // Debug script to help troubleshoot export button
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Debug: Checking export button');
            var exportButton = document.getElementById('exportDropdown');
            if (exportButton) {
                console.log('Debug: Export button found', exportButton);
            } else {
                console.log('Debug: Export button NOT found');
            }
            
            // Log all buttons for comparison
            var allButtons = document.querySelectorAll('button');
            console.log('Debug: Total buttons on page:', allButtons.length);
            
            // Check if dropdown is working
            if (typeof bootstrap !== 'undefined') {
                console.log('Debug: Bootstrap is available');
            } else {
                console.log('Debug: Bootstrap is NOT available');
            }
        });

        $(document).on('ready', function () {

            HSCore.components.HSFlatpickr.init('.js-flatpickr')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
            })

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route("admin.payout.search") }}",
                },

                columns: [
                    {data: 'no', name: 'no'},
                    {data: 'trx', name: 'trx'},
                    {data: 'name', name: 'name'},
                    {data: 'method', name: 'method'},
                    {data: 'amount', name: 'amount'},
                    {data: 'charge', name: 'charge'},
                    {data: 'net amount', name: 'net amount'},
                    {data: 'status', name: 'status'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action'},
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counterInfo: '#datatableCounterInfo'
                    }
                },

                language: {
                    zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                    processing: `<div><div></div><div></div><div></div><div></div></div>`
                },

            });

            document.getElementById("filter_button").addEventListener("click", function () {
                let filterTransactionId = $('#transaction_id_filter_input').val();
                let filterStatus = $('#filter_status').val();
                let filterMethod = $('#filter_method').val();
                let filterDate = $('#filter_date_range').val();

                const datatable = HSCore.components.HSDatatables.getItem(0);
                datatable.ajax.url("{{ route('admin.payout.search') }}" + "?filterTransactionID=" + filterTransactionId + "&filterStatus=" + filterStatus + "&filterMethod=" + filterMethod +
                    "&filterDate=" + filterDate).load();
            });

            $.fn.dataTable.ext.errMode = 'throw';


            $(document).on('click', '#datatableCheckAll', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });
            $(document).on('click', '.approved-multiple', function (e) {
                e.preventDefault();
                let all_value = [];
                $(".row-tic:checked").each(function () {
                    all_value.push($(this).attr('data-id'));
                });
                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.payout-request.multiple.approved') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        if(data?.success){
                            Notiflix.Notify.success(data.success);
                            location.reload();
                        }else {
                            Notiflix.Notify.failure(data.error);
                        }
                    },
                });
            });

            $(document).on('click','.exportBtn',function (){
                // Redirect to the Excel export with selected IDs
                let all_value = [];
                $(".row-tic:checked").each(function () {
                    all_value.push($(this).attr('data-id'));
                });
                
                if (all_value.length > 0) {
                    let queryParams = '';
                    all_value.forEach((value, index) => {
                        queryParams += `payout_ids[]=${value}&`;
                    });
                    
                    window.location.href = "{{ route('admin.export.payout.excel') }}?" + queryParams.slice(0, -1);
                } else {
                    // If no items selected, just show export dropdown
                    $('#exportDropdown').dropdown('toggle');
                }
            })
            
            // Handle export with current filters
            function updateExportLinks() {
                let filterTransactionId = $('#transaction_id_filter_input').val() || '';
                let filterStatus = $('#filter_status').val() || 'all';
                let filterMethod = $('#filter_method').val() || 'all';
                let filterDate = $('#filter_date_range').val() || '';
                
                let excelUrl = "{{ route('admin.export.payout.excel') }}" + 
                    "?filterTransactionID=" + filterTransactionId + 
                    "&filterStatus=" + filterStatus + 
                    "&filterMethod=" + filterMethod +
                    "&filterDate=" + filterDate;
                    
                let pdfUrl = "{{ route('admin.export.payout.pdf') }}" + 
                    "?filterTransactionID=" + filterTransactionId + 
                    "&filterStatus=" + filterStatus + 
                    "&filterMethod=" + filterMethod +
                    "&filterDate=" + filterDate;
                    
                $('#exportExcelLink').attr('href', excelUrl);
                $('#exportPdfLink').attr('href', pdfUrl);
            }
            
            // Update export links when filter button is clicked
            $('#filter_button').on('click', function() {
                updateExportLinks();
            });
            
            // Update export links on page load
            updateExportLinks();
            
            // Clear filters and update export links
            $('#clear_filter').on('click', function() {
                $('#transaction_id_filter_input').val('');
                $('#filter_status').val('all');
                $('#filter_method').val('all');
                $('#filter_date_range').val('');
                updateExportLinks();
            });
        });




    </script>

@endpush



