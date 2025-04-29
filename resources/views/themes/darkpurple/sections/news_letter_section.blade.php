

<!-- newsletter section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="box">
                    <div class="overlay">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="text-box">
                                    <h3>{!! $news_letter_section['single']['heading']??'' !!}</h3>
                                    <p>{!! $news_letter_section['single']['sub_heading']??'' !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form action="{{route('subscribe')}}" method="post">
                                    @csrf
                                    <div class="input-box col-md-12">

                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="@lang('Email Address')" />
                                        </div>
                                        <button class="btn-custom" type="submit">{{trans('Subscribe')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
