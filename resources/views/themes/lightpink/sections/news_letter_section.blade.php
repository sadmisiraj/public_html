<section class="newsletter_area">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <h3 class="text-center text-lg-start"><i class="fa-regular fa-paper-plane"></i>
                    {!! $news_letter_section['single']['heading']??'' !!} </h3>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <form class="subscribe_form" action="{{route('subscribe')}}" method="post">
                    @csrf
                    <input type="email" name="email" class="form-control" placeholder="@lang('Email Address')" />
                    <button>{{trans('Subscribe')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>
