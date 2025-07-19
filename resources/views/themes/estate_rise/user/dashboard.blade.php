@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')

    @php
        $content = getContent();
        use App\Models\Announcement;
        $today = date('Y-m-d');
        $announcements = Announcement::where('status', 'active')
            ->where(function($q) use ($today) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
            })
            ->where(function($q) use ($today) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
            })
            ->pluck('text');
    @endphp
    
    <!-- Dashboard Popup Modal -->
    @if(basicControl()->show_dashboard_popup && basicControl()->dashboard_popup_image)
    <div class="modal fade" id="dashboardPopupModal" tabindex="-1" role="dialog" aria-labelledby="dashboardPopupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" id="closePopupBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-0">
                    @if(basicControl()->dashboard_popup_url)
                        <a href="{{ basicControl()->dashboard_popup_url }}" target="_blank">
                            <img src="{{ getFile(basicControl()->dashboard_popup_image_driver, basicControl()->dashboard_popup_image) }}" 
                                 class="img-fluid" alt="Dashboard Popup" style="cursor: pointer;">
                        </a>
                    @else
                        <img src="{{ getFile(basicControl()->dashboard_popup_image_driver, basicControl()->dashboard_popup_image) }}" 
                             class="img-fluid" alt="Dashboard Popup">
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="main-wrapper">
        <!-- Page title start -->
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Dashboard')</li>
                </ol>
            </nav>
        </div>
        @if($announcements && count($announcements) > 0)
            <div class="announcement-marquee mb-3">
                <marquee behavior="scroll" direction="left" scrollamount="6" onmouseover="this.stop();" onmouseout="this.start();">
                    @foreach($announcements as $announcement)
                        <span class="announcement-item">{{ $announcement }}</span>
                        @if(!$loop->last)
                            <span class="mx-3">|</span>
                        @endif
                    @endforeach
                </marquee>
            </div>
        @endif
     
        <!-- Page title end -->
        <div class="dashboard-top">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center" style="height: 100%;">
                        <!-- Greeting Text (left, flex: 1) -->
                        <div class="text-box text-center text-lg-start flex-grow-1" style="min-width:0;">
                            <div class="d-flex align-items-center gap-3 justify-content-center justify-content-lg-start">
                                <h2 class="title mb-1" style="font-size: 1.5rem;">@lang('Hi'), {{auth()->user()->fullname}}!</h2>
                                <div class="icon-box">
                                    <i class="fa-regular fa-money-bill"></i>
                                </div>
                            </div>
                            <div class="profile-content">
                                <h4 style="font-size: 1rem;">user<span>{{'@'.auth()->user()->username}}</span></h4>
                            </div>
                            <h2 class="title mb-1" style="font-size: 1.2rem;">
                                {!! styleSentence($content['single']['heading']??'',5) !!}
                            </h2>
                            <h5 class="sub-title " style="font-size: 1rem;">
                                {!! $content['single']['sub_heading']??'' !!}
                            </h5>
                        </div>
                        <!-- Dashboard Tile (right of greeting, auto width) -->
                        @if(auth()->user()->dashboard_label && auth()->user()->dashboard_value)
                        <div class="card text-center ms-3" style="min-width:130px; max-width:180px; margin-bottom: 0;">
                            <div class="card-body p-3">
                                <h5 class="card-title mb-1" style="font-size:1.1em;">{{ auth()->user()->dashboard_label }}</h5>
                                <p class="card-text mb-0" style="font-size:1.4em; font-weight:bold;">{{ auth()->user()->dashboard_value }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Offer Slider (right half, taller and image fits) -->
                    <div class="offer-slider-container" style="height: 297px; display: flex; align-items: center;"> <!-- 270px * 1.1 = 297px -->
                        @php
                            $offerImages = \App\Models\OfferImage::where('status', true)->orderBy('order', 'asc')->get();
                            if ($offerImages->isEmpty()) {
                                // Create a default offer image for testing
                                $defaultImage = new \App\Models\OfferImage([
                                    'title' => 'Default Offer',
                                    'image' => 'offerImage/test-offer.png',
                                    'image_driver' => 'local',
                                    'url' => null,
                                    'order' => 1,
                                    'status' => true
                                ]);
                                $offerImages = collect([$defaultImage]);
                            }
                        @endphp
                        @if($offerImages->count() > 0)
                            <div class="offer-slider" style="width: 100%; height: 100%;">
                                @foreach($offerImages as $offerImage)
                                    <div class="offer-slide" style="height: 100%;">
                                        @php
                                            $imageUrl = $offerImage->getImageUrl();
                                        @endphp
                                        @if($offerImage->url)
                                            <a href="{{ $offerImage->url }}" target="_blank">
                                                <img src="{{ $imageUrl }}" alt="{{ $offerImage->title }}" class="img-fluid" style="height: 100%; width: 100%; object-fit: contain;">
                                            </a>
                                        @else
                                            <img src="{{ $imageUrl }}" alt="{{ $offerImage->title }}" class="img-fluid" style="height: 100%; width: 100%; object-fit: contain;">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-offers" style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                <p>@lang('No offers available')</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Below the top row, show the grid/tile layout (no greeting tile) -->
        <div class="grid-container">
            <div class="item">
                <div class="deposit-invest-box">
                    <div class="img-box">
                        <img src="{{asset(template(true).'img/box-card/market-analysis-31.png')}}" alt="icon">
                    </div>
                    <div class="text-box">
                        <a href="{{route('user.plan')}}" class="cmn-btn"><i class="fa-regular fa-usd-circle"></i>
                            @lang('Gold Purchase')</a>
                        <a href="{{route('user.addFund')}}" class="cmn-btn"><i class="fa-regular fa-wallet"></i>
                            @lang('Gold Booking')</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="box-card2">
                    <div class="img-box">
                        <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="icon">
                    </div>
                    <div class="text-box">
                        <h4 class="title mb-0">{{currencyPosition(auth()->user()->balance+0)}}</h4>
                        <p class="mb-0">@lang('Booking Balance')</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="box-card2">
                    <div class="img-box">
                        <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="icon">
                    </div>
                    <div class="text-box">
                        <h5 class="mb-0">{{currencyPosition(auth()->user()->profit_balance+0)}}</h5>
                        <p class="mtitle b-0">@lang('Performance Balance')</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="box-card2">
                    <div class="img-box">
                        <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="icon">
                    </div>
                    <div class="text-box">
                        <h5 class="mb-0">{{currencyPosition(auth()->user()->interest_balance+0)}}</h5>
                        <p class="mtitle b-0">@lang('Gold value Balance')</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="box-card2">
                    <div class="img-box">
                        <img src="{{asset(template(true).'img/box-card/money-jar-54.png')}}" alt="icon">
                    </div>
                    <div class="text-box">
                        <h5 class="title mb-0">{{currencyPosition($totalDeposit+0)}} </h5>
                        <p class="mb-0">@lang('Total Gold Booking')</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile-only Action Tiles -->
        <div class="mobile-action-tiles d-md-none">
            <div class="row g-3">
                <div class="col-6">
                    <div class="mobile-action-card">
                        <div class="action-icon">
                            <i class="fa-regular fa-usd-circle"></i>
                        </div>
                        <div class="action-content">
                            <h6 class="action-title">@lang('Gold Purchase')</h6>
                            <p class="action-desc">@lang('Buy gold packages')</p>
                        </div>
                        <a href="{{route('user.plan')}}" class="action-link"></a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mobile-action-card">
                        <div class="action-icon">
                            <i class="fa-regular fa-wallet"></i>
                        </div>
                        <div class="action-content">
                            <h6 class="action-title">@lang('Gold Booking')</h6>
                            <p class="action-desc">@lang('Add funds to wallet')</p>
                        </div>
                        <a href="{{route('user.addFund')}}" class="action-link"></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- RGP Earnings Section -->
        <div class="rgp-earnings-section mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('RGP Earnings')</h5>
                </div>
                <div class="card-body">
                    <!-- Desktop Table (hidden on mobile) -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('Total Earned')</th>
                                    <th>@lang('Earned Today')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@lang('RGP Alpha')</td>
                                    <td>{{ $total_rgp_l ?? 0 }}</td>
                                    <td>{{ $today_rgp_l ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('RGP Beta')</td>
                                    <td>{{ $total_rgp_r ?? 0 }}</td>
                                    <td>{{ $today_rgp_r ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Mobile Cards (visible on mobile only) -->
                    <div class="rgp-mobile-cards d-block d-md-none">
                        <div class="rgp-card">
                            <div class="rgp-label">@lang('RGP Alpha')</div>
                            <div class="rgp-row"><span>@lang('Total Earned'):</span> <span>{{ $total_rgp_l ?? 0 }}</span></div>
                            <div class="rgp-row"><span>@lang('Earned Today'):</span> <span>{{ $today_rgp_l ?? 0 }}</span></div>
                        </div>
                        <div class="rgp-card">
                            <div class="rgp-label">@lang('RGP Beta')</div>
                            <div class="rgp-row"><span>@lang('Total Earned'):</span> <span>{{ $total_rgp_r ?? 0 }}</span></div>
                            <div class="rgp-row"><span>@lang('Earned Today'):</span> <span>{{ $today_rgp_r ?? 0 }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        /* Mobile Action Tiles Styles */
        .mobile-action-tiles {
            margin: 20px 0;
            padding: 0 15px;
        }
        
        .mobile-action-card {
            position: relative;
            background: linear-gradient(135deg, rgb(var(--primary-color)) 0%, rgb(var(--primary-color), 0.8) 100%);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(var(--primary-color), 0.3);
            transition: all 0.3s ease;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .mobile-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(var(--primary-color), 0.4);
        }
        
        .mobile-action-card .action-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        
        .mobile-action-card .action-icon i {
            font-size: 24px;
            color: rgb(var(--white));
        }
        
        .mobile-action-card .action-content {
            color: rgb(var(--white));
        }
        
        .mobile-action-card .action-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
            color: rgb(var(--white));
        }
        
        .mobile-action-card .action-desc {
            font-size: 12px;
            margin: 0;
            opacity: 0.9;
            color: rgb(var(--white));
        }
        
        .mobile-action-card .action-link {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        /* Hide on desktop */
        @media (min-width: 768px) {
            .mobile-action-tiles {
                display: none !important;
            }
        }
        
        /* Dark theme support */
        .dark-theme .mobile-action-card {
            background: linear-gradient(135deg, rgb(var(--primary-color)) 0%, rgb(var(--primary-color), 0.9) 100%);
        }
        </style>

        <style>
        /* RGP Earnings Styles */
        .rgp-earnings-section {
            margin: 20px 0;
        }
        
        .rgp-mobile-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .rgp-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }
        
        .rgp-card .rgp-label {
            font-weight: 700;
            font-size: 16px;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .rgp-card .rgp-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .rgp-card .rgp-row:last-child {
            margin-bottom: 0;
        }
        
        .rgp-card .rgp-row span:first-child {
            color: #6c757d;
            font-weight: 500;
        }
        
        .rgp-card .rgp-row span:last-child {
            color: #495057;
            font-weight: 700;
        }
        
        /* Dark theme support */
        .dark-theme .rgp-card {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            border-color: #6c757d;
        }
        
        .dark-theme .rgp-card .rgp-label {
            color: #f8f9fa;
        }
        
        .dark-theme .rgp-card .rgp-row span:first-child {
            color: #adb5bd;
        }
        
        .dark-theme .rgp-card .rgp-row span:last-child {
            color: #f8f9fa;
        }
        </style>

        <div class="mt-30">
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Dashboard card start -->
                    <div>
                        <div class="row g-4 justify-content-center">
                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="first circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[0]) ? $configs[0]->display_name : 'Config 1' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="second circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[1]) ? $configs[1]->display_name : 'Config 2' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="third circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[2]) ? $configs[2]->display_name : 'Config 3' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard card end -->
                    <div class="card mt-25">
                        <div class="card-header pb-0 border-0">
                            <h4 class="mb-0">@lang('To do list')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-funnel-dollar"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($roi['totalInvestAmount']+0)}}</h5>
                                            <h6>@lang('Total Gold Purchase')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-usd-circle"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($totalPayout+0)}}</h5>
                                            <h6>@lang('Total Saled Gold')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-lightbulb-dollar"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($totalBonus+0)}}</h5>
                                            <h6>@lang('TRB')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-ticket"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{$ticket}}</h5>
                                            <h6>@lang('Total Ticket')</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-25">
                        <div class="card-body">
                            <div class="card h-100">
                                <div class="card-body p-1">
                                    <div id="columnChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-lg-12 col-md-6">
                            <div id="datepicker" class=" h-100"></div>
                        </div>


                        @php
                            $user = auth()->user();
                            $user_rankings = getRanking();
                        @endphp
                        <div class="col-lg-12 col-md-6">
                            <div class="row g-4">
                                @if($user->last_lavel != null && $user_rankings)
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="box-card3">
                                                    <div class="icon-box">
                                                        <i class="fa-regular fa-box-open"></i>
                                                    </div>

                                                    <div class="text-box">
                                                        <h5 class="title">@lang(@$user_rankings->rank_name)</h5>
                                                        <h6>@lang(@$user_rankings->rank_lavel)</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <h5 class="mb-3">Bank Details</h5>
                                            <div style="font-size: 0.95rem;">
                                                <div><strong>ACCOUNT NAME:</strong> REINO GOLD PRIVATE LIMITED</div>
                                                <div><strong>ACCOUNT NUMBER:</strong> 925020025550562</div>
                                                <div><strong>IFSC CODE:</strong> UTIB0001919</div>
                                                <div><strong>BRANCH:</strong> TOWN HALL, COIMBATORE</div>
                                            </div>
                                            <div class="mt-3">
                                                <img src="{{ asset('assets/qr.jpeg') }}" alt="UPI QR Code" style="max-width: 150px; width: 100%; height: auto; border: 1px solid #eee; border-radius: 8px;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-handshake"></i>
                                        </div>

                                        <div class="text-box">
                                            <h6>{{currencyPosition($lastPayout)}}</h6>
                                            <h5 class="title">@lang('Latest Gold sale ')</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="mb-20">Referral Link</h4> -->
                                    <h5 class="mb-3">@lang('TC LINKS')</h5>
                                    <div class="mb-3">
                                        <label class="form-label">@lang('ALPHA')</label>
                                        <div class="input-group">
                                            <input id="leftReferralURL" type="text" class="form-control"
                                                   value="{{route('register.sponsor',[Auth::user()->username, 'left'])}}"
                                                   aria-label="Left referral link" aria-describedby="copy-left-btn"
                                                   readonly>
                                            <div class="input-group-text" id="copyLeftBtn"><i
                                                    class="fa-regular fa-copy"></i>@lang('copy')
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">@lang('BETA')</label>
                                        <div class="input-group">
                                            <input id="rightReferralURL" type="text" class="form-control"
                                                   value="{{route('register.sponsor',[Auth::user()->username, 'right'])}}"
                                                   aria-label="Right referral link" aria-describedby="copy-right-btn"
                                                   readonly>
                                            <div class="input-group-text" id="copyRightBtn"><i
                                                    class="fa-regular fa-copy"></i>@lang('copy')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <style>
        /* Ensure text is centered in the circle */
        .circle {
            position: relative;
        }
        .circle span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            font-weight: 500;
        }
        /* Special styling for percentage values */
        .circle span.percent i {
            font-style: normal;
            font-size: 10px;
        }
    </style>
    <script>
        $(document).ready(function () {
            console.log('Dashboard script loaded');
            console.log('Modal exists: ' + $('#dashboardPopupModal').length);

            // Always show the dashboard popup modal if it exists
            if ($('#dashboardPopupModal').length) {
                setTimeout(function() {
                    $('#dashboardPopupModal').modal('show');
                }, 300);
            }
            // Handle close button click
            $('#closePopupBtn').on('click', function() {
                $('#dashboardPopupModal').modal('hide');
            });
        });
        
        // Circle progress start
        @php
            // Get configs
            $config1Raw = isset($configs[0]) ? $configs[0]->value : '0';
            $config2Raw = isset($configs[1]) ? $configs[1]->value : '0';
            $config3Raw = isset($configs[2]) ? $configs[2]->value : '0';
            
            // Check if values end with % to determine if they're percentages
            $isConfig1Percent = str_ends_with($config1Raw, '%');
            $isConfig2Percent = str_ends_with($config2Raw, '%');
            $isConfig3Percent = str_ends_with($config3Raw, '%');
            
            // Strip % for percentage values and convert to integer
            $config1Value = $isConfig1Percent ? (int)str_replace('%', '', $config1Raw) : $config1Raw;
            $config2Value = $isConfig2Percent ? (int)str_replace('%', '', $config2Raw) : $config2Raw;
            $config3Value = $isConfig3Percent ? (int)str_replace('%', '', $config3Raw) : $config3Raw;
        @endphp

        if ($('.circle').length) {
            $('.first.circle').circleProgress({
                value: {{ $isConfig1Percent ? $config1Value/100 : 0 }},
                size: 70,
                fill: {
                    gradient: ["#ae8656"]
                }
            }).on('circle-animation-progress', function (event, progress) {
                @if($isConfig1Percent)
                    $(this).find('span').html(Math.round({{ $config1Value }} * progress) + '<i>%</i>');
                @else
                    $(this).find('span').html('{{ $config1Raw }}');
                    // Show empty ring for non-percentage values
                @endif
                $(this).find('span').addClass('percent');
            });
        }

        if ($('.circle').length) {
            $('.second.circle').circleProgress({
                value: {{ $isConfig2Percent ? $config2Value/100 : 0 }},
                size: 70,
                fill: {
                    gradient: ["#ae8656"]
                }
            }).on('circle-animation-progress', function (event, progress) {
                @if($isConfig2Percent)
                    $(this).find('span').html(Math.round({{ $config2Value }} * progress) + '<i>%</i>');
                @else
                    $(this).find('span').html('{{ $config2Raw }}');
                    // Show empty ring for non-percentage values
                @endif
                $(this).find('span').addClass('percent');
            });
        }

        if ($('.circle').length) {
            $('.third.circle').circleProgress({
                value: {{ $isConfig3Percent ? $config3Value/100 : 0 }},
                size: 70,
                fill: {
                    gradient: ["#ae8656"]
                }
            }).on('circle-animation-progress', function (event, progress) {
                @if($isConfig3Percent)
                    $(this).find('span').html(Math.round({{ $config3Value }} * progress) + '<i>%</i>');
                @else
                    $(this).find('span').html('{{ $config3Raw }}');
                    // Show empty ring for non-percentage values
                @endif
                $(this).find('span').addClass('percent');
            });
        }

        // Circle progress end

        if ($('#columnChart').length) {
            var options = {
                series: [{
                    name: 'Purchase',
                    color: '#567eae',
                    data: {!! $monthly['investment']->flatten() !!}
                }, {
                    name: 'Payout',
                    color: 'rgb(174,134,86)',
                    data: {!! $monthly['payout']->flatten() !!}
                },
                    {
                        name: 'Deposit',
                        color: '#5a56ae',
                        data: {!! $monthly['funding']->flatten() !!}
                    },
                    {
                        name: 'Deposit Bonus',
                        color: '#e7bb89',
                        data: {!! $monthly['referralFundBonus']->flatten() !!}
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

                },

                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "{{basicControl()->currency_symbol}}" + val
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#columnChart"), options);
            chart.render();
        }

    document.getElementById("copyLeftBtn").addEventListener("click", () => {
        let leftReferralURL = document.getElementById("leftReferralURL");
        leftReferralURL.select();
        navigator.clipboard.writeText(leftReferralURL.value)
        if (leftReferralURL.value) {
            document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
            setTimeout(() => {
                document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
            }, 1000)
        }
    })

    document.getElementById("copyRightBtn").addEventListener("click", () => {
        let rightReferralURL = document.getElementById("rightReferralURL");
        rightReferralURL.select();
        navigator.clipboard.writeText(rightReferralURL.value)
        if (rightReferralURL.value) {
            document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
            setTimeout(() => {
                document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
            }, 1000)
        }
    })
    </script>
@endpush

@push('style')
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Default: 5 columns */
            gap: 16px;
            margin: 20px 0;
        }
        @media (max-width: 991px) {
            .grid-container {
                grid-template-columns: repeat(2, 1fr); /* Tablet: 2 columns */
            }
        }
        @media (max-width: 600px) {
            .grid-container {
                grid-template-columns: 1fr; /* Mobile: 1 column */
            }
            .grid-container .item {
                margin-bottom: 16px;
            }
            /* Hide the first deposit-invest-box tile on mobile */
            .grid-container .item:first-child {
                display: none !important;
            }
        }
        .img-box img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .announcement-marquee {
            background: #fffbe6;
            color: #ae8656;
            border: 1px solid #ffe58f;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 16px;
            overflow: hidden;
        }
        .announcement-item {
            margin-right: 16px;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function(){
            console.log('Document ready');
            console.log('Offer images count:', $('.offer-slider .offer-slide').length);
            
            // Check if slick is available
            if (typeof $.fn.slick === 'undefined') {
                console.error('Slick slider library is not loaded');
                
                // Load slick dynamically
                var slickCss = document.createElement('link');
                slickCss.rel = 'stylesheet';
                slickCss.href = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css';
                document.head.appendChild(slickCss);
                
                var slickThemeCss = document.createElement('link');
                slickThemeCss.rel = 'stylesheet';
                slickThemeCss.href = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css';
                document.head.appendChild(slickThemeCss);
                
                var slickScript = document.createElement('script');
                slickScript.src = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js';
                slickScript.onload = function() {
                    console.log('Slick library loaded dynamically');
                    initSliders();
                };
                document.body.appendChild(slickScript);
            } else {
                console.log('Slick library is available');
                initSliders();
            }
            
            function initSliders() {
                try {
                    $('.offer-slider').slick({
                        dots: true,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 3000,
                        fade: true,
                        cssEase: 'linear'
                    });
                    console.log('Desktop slider initialized');
                    
                    $('.offer-slider-mobile').slick({
                        dots: true,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 3000,
                        fade: true,
                        cssEase: 'linear'
                    });
                    console.log('Mobile slider initialized');
                } catch (e) {
                    console.error('Error initializing sliders:', e);
                }
            }
        });
    </script>
@endpush

@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            // Modal show is now handled conditionally in the main script section
            @if(basicControl()->dashboard_popup_url)
            // Make the entire modal body clickable if URL is provided
            $('#dashboardPopupModal .modal-body').css('cursor', 'pointer');
            $('#dashboardPopupModal .modal-body').click(function(e) {
                if (!$(e.target).is('a')) {
                    window.open('{{ basicControl()->dashboard_popup_url }}', '_blank');
                }
            });
            @endif
        });
    </script>
@endpush
