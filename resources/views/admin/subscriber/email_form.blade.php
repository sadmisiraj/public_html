@extends('admin.layouts.app')
@section('page_title',__('Mail To Subscriber'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang("Dashboard")</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang("Mail To Subscriber")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Mail To Subscriber")</h1>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title mt-2">@lang('Send Email To All Subscriber')</h4>
                        </div>
                        <div class="card-body mt-2">
                            <form action="{{route('admin.subscriber.mail') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="subjectLabel">@lang('Subject')</label>
                                        <input type="text" class="form-control" name="subject" id="subjectLabel"
                                               placeholder="@lang('Subject')" aria-label="@lang('Subject')" autocomplete="off">
                                        @error('subject')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="descriptionLabel">@lang('Email Body')</label></label>
                                        <textarea class="form-control summernote" name="message"></textarea>
                                        @error('description')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary">@lang('Send')</button>
                                </div>
                            </form>
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
                height: 200,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable')
                            .val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });

    </script>
@endpush
