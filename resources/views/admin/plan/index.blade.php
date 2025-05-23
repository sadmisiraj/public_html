@extends('admin.layouts.app')
@section('page_title',__('Plan List'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Plan List')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Plan List')</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">

                    <div class="input-group input-group-merge navbar-input-group">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input type="search" id="datatableSearch"
                               class="search form-control form-control-sm"
                               placeholder="@lang('Search plan')"
                               aria-label="@lang('Search plan')"
                               autocomplete="off">
                        <a class="input-group-append input-group-text display-none" href="javascript:void(0)">
                            <i id="clearSearchResultsIcon" class="bi-x"></i>
                        </a>
                    </div>

                </div>

                @if(adminAccessRoute(config('role.manage_plan.access.add')))
                    <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                        <a href="{{route('admin.plan.create')}}"  class="btn btn-primary"><i class="fa-duotone fa-solid fa-plus me-1"></i>@lang('Add New')</a>
                    </div>
                @endif

            </div>

            <div class=" table-responsive datatable-custom  ">
                <table id="datatable"
                       class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                       "columnDefs": [{
                          "targets": [0, 5],
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
                        <th>@lang('SL.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Plan Price')</th>
                        <th>@lang('Base Plan')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Featured')</th>
                        <th>@lang('Eligible for Referral')</th>
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
                            <!-- Select -->
                            <div class="tom-select-custom">
                                <select id="datatableEntries"
                                        class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                        data-hs-tom-select-options='{
                                            "searchInDropdown": false,
                                            "hideSearch": true
                                          }'>
                                    <option value="10">10</option>
                                    <option value="20" selected>20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">@lang('of')</span>
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

@endsection

@push('js-lib')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
@endpush


@push('script')
    <script>

        $(document).on('click','.deleteBtn',function (){
            $('#setRoute').attr('action',$(this).data('route'))
        })

        $(document).on('ready', function () {
            if ($('#datatable').length) {
                HSCore.components.HSDatatables.init($('#datatable'), {
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ route("admin.plan.list") }}",
                    },

                    columns: [
                        {data: 'sl', name: 'sl'},
                        {data: 'name', name: 'name'},
                        {data: 'price', name: 'price'},
                        {data: 'base_plan', name: 'base_plan'},
                        {data: 'status', name: 'status'},
                        {data: 'featured', name: 'featured'},
                        {data: 'eligible_for_referral', name: 'eligible_for_referral'},
                        {data: 'action', name: 'action'},
                    ],

                    language: {
                        zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                        processing: `<div><div></div><div></div><div></div><div></div></div>`
                    },
                });

                $.fn.dataTable.ext.errMode = 'throw';
            } else {
                console.error('DataTable element not found');
            }


        });

    </script>
@endpush




