<!-- footer_area_start -->
<div class="footer_area pt-100">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer_widget">
                    <div class="widget_logo">
                        <h5><a href="{{route('page')}}" class="site_logo"><img src="{{logo()}}" alt=""></a></h5>
                        <p class="pb-3">
                            {!! $footer['single']['short_description']??'' !!}
                        </p>
                    </div>
                    <div class="social_area">
                        <ul class="">
                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                <li>
                                    <a href="{{$data['media']->social_link}}" target="_blank">
                                        {!! icon($data['media']->social_link) !!}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer_widget ps-md-5">
                    <h5>{{trans('Useful Links')}}</h5>
                    <ul>
                        @if(getFooterMenuData('useful_link') != null)

                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 pt-sm-0 pt-3">
                <div class="footer_widget">
                    <h5>@lang('Our Services')</h5>
                    <ul>
                        @if(getFooterMenuData('support_link') != null)

                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 pt-sm-0 pt-3">
                <div class="footer_widget">
                    <h5> {!! $footer['single']['newsletter_title']??'' !!}</h5>
                    <p>{!! $footer['single']['newsletter_sub_title']??'' !!}</p>
                    <form action="{{route('subscribe')}}" method="post">
                        @csrf
                        <input type="email" name="email" class="form-control" placeholder="@lang('Email Address')">
                        <button type="submit" class="custom_btn"><i class="fa fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- copy_right_area_start -->
        <div class="copy_right_area pt-100 text-center">
            <div class="container">
                <div class="row">
                    <hr class="pb-3">
                    <div class="col-sm-12">
                        <p>@lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved')</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- copy_right_area_end -->
    </div>
</div>
<!-- footer_area_end -->
