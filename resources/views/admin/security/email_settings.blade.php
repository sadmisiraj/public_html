@extends('admin.layouts.app')
@section('page_title', __('Email Template Settings'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.settings') }}">@lang('Settings')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Email Settings')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Email Template Settings')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.email'), 'suffix' => ''])
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Default Email Settings')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.security.email.update') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">@lang('From Email')</label>
                                    <input type="text" name="sender_email" class="form-control"
                                           placeholder="@lang('Enter default form email address')"
                                           value="{{ $basicControl->sender_email }}">
                                    @error('sender_email')<span class="text-danger">@lang($message)</span>@enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('From Email Name')</label>
                                        <input type="text" name="sender_email_name" class="form-control"
                                               placeholder="@lang('Enter default form email name')"
                                               value="{{ $basicControl->sender_email_name }}">
                                        @error('sender_email_name')<span
                                            class="text-danger">@lang($message)</span>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">@lang('Email Description')</label>
                                <textarea class="form-control" name="email_description" id="summernote"
                                      placeholder="@lang('Enter default form email template')" rows="20">{{$basicControl->email_description}}</textarea>
                                @error('email_description')<span class="text-danger">@lang($message)</span>@enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Available Email Templates')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>@lang('SL.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($emailTemplates as $template)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ __($template->name) }}</td>
                                        <td>
                                            <span class="badge bg-{{ isset($template->status['mail']) && $template->status['mail'] == 1 ? 'success' : 'danger' }}">
                                                {{ isset($template->status['mail']) && $template->status['mail'] == 1 ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.email.template.edit', $template->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil-square"></i> @lang('Edit')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">@lang('No templates found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                dialogsInBody: true,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });
    </script>
@endpush 