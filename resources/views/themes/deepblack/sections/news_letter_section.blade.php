<!-- REFFERAL -->
<section class="newsletter-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $news_letter_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $news_letter_section['single']['sub_heading']??'' !!}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{route('subscribe')}}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="@lang('Email Address')" />
                        <button type="submit" class="gold-btn">{{trans('Subscribe')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
