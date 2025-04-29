<!-- TOPBAR | TOPBAR-LOGGEDIN -->
<section id="topbar" class="topbar-loggedin">
    <div class="{{Request::routeIs('user*') ? 'container-fluid' : 'container'}}  ">
        <div class="row">
            <div class="col-md-6">
                <div class="topbar-contact">
                    <div class="d-flex flex-wrap justify-content-between">
                        <ul class="topbar-contact-list d-flex flex-wrap justify-content-between justify-content-lg-start">
                            <li><i class="icofont-envelope"></i><span
                                    class="ml-5">{{$footer['single']['email']??''}}</span></li>
                            <li class="ml-sm-3 ml-0"><i class="icofont-android-tablet"></i><span
                                    class="ml-5">{{$footer['single']['telephone']??''}} </span></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div
                    class="topbar-content d-flex align-items-center justify-content-between justify-content-md-end">
                    <div class="language-wrapper">
                        <div class="control-plugin">
                            <div class="language"
                                 data-input-name="country3"
                                 data-selected-country="{{app()->getLocale() ? : 'US'}}"
                                 data-button-size="btn-sm"
                                 data-button-type="btn-info"
                                 data-scrollable="true"
                                 data-scrollable-height="250px"
                                 data-countries='{{$languages}}'>
                            </div>
                        </div>
                    </div>
                    <div class="topbar-social">
                        @foreach(collect($footer['multiple'])->toArray() as $k =>  $data)
                            <a @if($k == 0) class="pl-0" @endif href="{{$data['media']->social_link}}">
                                {!! icon($data['media']->social_link) !!}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
