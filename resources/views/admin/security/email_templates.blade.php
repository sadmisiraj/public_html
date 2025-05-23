@extends('admin.layouts.app')
@section('page_title', __('Email Security Settings'))
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
                    <h1 class="page-header-title">@lang('Email Settings')</h1>
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
                        <h4 class="card-title">@lang('Default Email Template')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.security.email.template.update') }}" method="post">
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
                                <div class="email-editor">
                                    <div class="email-editor-toolbar">
                                        <div class="btn-group">
                                            <button type="button" class="btn" title="Format">
                                                <i class="bi bi-type"></i>
                                            </button>
                                            <button type="button" class="btn" title="Bold">
                                                <i class="bi bi-type-bold"></i>
                                            </button>
                                            <button type="button" class="btn" title="Italic">
                                                <i class="bi bi-type-italic"></i>
                                            </button>
                                            <button type="button" class="btn" title="Underline">
                                                <i class="bi bi-type-underline"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn" title="Insert">
                                                <i class="bi bi-text-paragraph"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn" title="Insert Link">
                                                <i class="bi bi-link"></i>
                                            </button>
                                            <button type="button" class="btn" title="Insert Image">
                                                <i class="bi bi-image"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn" title="View Source">
                                                <i class="bi bi-code"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea class="form-control summernote" id="email_description" name="email_description"
                                          placeholder="@lang('Enter default form email template')" rows="20">{{$basicControl->email_description}}</textarea>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                        <tr>
                                            <th> @lang('SHORTCODE') </th>
                                            <th> @lang('DESCRIPTION') </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <code>[[name]]</code>
                                            </td>
                                            <td> @lang("User's Name will replace here.") </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <code>[[message]]</code>
                                            </td>
                                            <td>@lang("Application notification message will replace here.")</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mt-3">@lang('Save Changes')</button>
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
                                        <td>{{ __($loop->index + 1) }} </td>
                                        <td>{{ __($template->name) }} </td>
                                        <td>
                                            <span class="badge bg-soft-{{ $template->status['mail'] == 1 ? "success" :  "danger" }} text-{{ $template->status['mail'] == 1 ? "success" :  "danger" }}">
                                                <span class="legend-indicator bg-{{ $template->status['mail'] == 1 ? "success" :  "danger" }}"></span> {{ __($template->status['mail'] == 1 ? "Active" :  "Inactive") }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(adminAccessRoute(config('role.control_panel.access.edit')))
                                                <a class="btn btn-white btn-sm"
                                                   href="{{ route('admin.security.email.template.edit', $template->id) }}">
                                                    <i class="bi-pencil-fill me-1"></i> @lang("Edit")
                                                </a>
                                            @endif
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
            $('.summernote').summernote({
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