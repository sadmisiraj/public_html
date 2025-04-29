<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-vertical-aside-initialized
    {{in_array(session()->get('themeMode'), [null, 'auto'] )?  'navbar-dark bg-dark ' : 'navbar-light bg-white'}}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
                <img class="navbar-brand-logo navbar-brand-logo-auto"
                     src="{{ getFile(session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo_driver : $basicControl->admin_logo_driver, session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo:$basicControl->admin_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">

                <img class="navbar-brand-logo"
                     src="{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="dark">

                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="Logo"
                     data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip"
                   data-bs-placement="right"
                   title="Collapse">
                </i>
                <i
                    class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Expand"
                ></i>
            </button>
            <!-- End Navbar Vertical Toggle -->


            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

                    @if(adminAccessRoute(config('role.dashboard.access.view')))
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.dashboard']) }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi-house-door nav-icon"></i>
                                <span class="nav-link-title">@lang("Dashboard")</span>
                            </a>
                        </div>
                    @endif
                    @if(adminAccessRoute(config('role.schedule.access.view')) || adminAccessRoute(config('role.manage_plan.access.view')))
                            <span class="dropdown-header mt-4">@lang('Manage Plan')</span>
                    @endif

                        @if(adminAccessRoute(config('role.schedule.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.schedule']) }}"
                                   href="{{ route('admin.schedule') }}">
                                    <i class="fal fa-clock nav-icon"></i>
                                    <span class="nav-link-title">@lang("Schedule")</span>
                                </a>
                            </div>
                        @endif
                        @if(adminAccessRoute(config('role.manage_plan.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.plan']) }}"
                                   href="{{ route('admin.plan') }}">
                                    <i class="bi bi-box-seam nav-icon"></i>
                                    <span class="nav-link-title">@lang("Plan List")</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.referral.access.view')))
                            <span class="dropdown-header mt-4">@lang('Commission Setting')</span>
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.referral-commission']) }}"
                                   href="{{ route('admin.referral-commission') }}">
                                    <i class="fa-duotone fa-user-gear nav-icon"></i>
                                    <span class="nav-link-title">@lang("Referral")</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.ranking.access.view')))
                            <span class="dropdown-header mt-4">@lang('Manage Ranking')</span>

                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.rankingsUser']) }}"
                                   href="{{ route('admin.rankingsUser') }}">
                                    <i class="bi bi-globe nav-icon"></i>
                                    <span class="nav-link-title">@lang("User Ranking")</span>
                                </a>
                            </div>
                        @endif



                        @if(adminAccessRoute(config('role.commission.access.view')) || adminAccessRoute(config('role.payment_request.access.view')) || adminAccessRoute(config('role.payment.access.view')) || adminAccessRoute(config('role.transaction.access.view')) || adminAccessRoute(config('role.withdraw.access.view')))
                            <span class="dropdown-header mt-4">@lang('Transactions')</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                        @endif

                        @if(adminAccessRoute(config('role.investment.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.investments']) }}"
                                   href="{{ route('admin.investments') }}">
                                    <i class="fa-light fa-layer-group nav-icon"></i>
                                    <span class="nav-link-title">@lang("Investments")</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.commission.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.commission']) }}"
                                   href="{{ route('admin.commission') }}" data-placement="left">
                                    <i class="fa-light fa-sack-dollar nav-icon"></i>
                                    <span class="nav-link-title">@lang("Commission")</span>
                                </a>
                            </div>
                        @endif
                        @if(adminAccessRoute(config('role.transaction.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.transaction']) }}"
                                   href="{{ route('admin.transaction') }}" data-placement="left">
                                    <i class="bi bi-send nav-icon"></i>
                                    <span class="nav-link-title">@lang("Transaction")</span>
                                </a>
                            </div>
                        @endif
                        @if(adminAccessRoute(config('role.withdraw.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.payout.log']) }}"
                                   href="{{ route('admin.payout.log') }}" data-placement="left">
                                    <i class="bi bi-wallet2 nav-icon "></i>
                                    <span class="nav-link-title">@lang("Withdraw Log")</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.payment.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.payment.log']) }}"
                                   href="{{ route('admin.payment.log') }}" data-placement="left">
                                    <i class="bi bi-credit-card-2-front nav-icon"></i>
                                    <span class="nav-link-title">@lang("Payment Log")</span>
                                </a>
                            </div>
                        @endif
                        @if(adminAccessRoute(config('role.payment_request.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.payment.pending']) }}"
                                   href="{{ route('admin.payment.pending') }}" data-placement="left">
                                    <i class="bi bi-cash nav-icon"></i>
                                    <span class="nav-link-title">@lang("Payment Request")</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.support_ticket.access.view')))
                            <span class="dropdown-header mt-4"> @lang("Ticket Panel")</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle {{ menuActive(['admin.ticket', 'admin.ticket.search', 'admin.ticket.view'], 3) }}"
                                   href="#navbarVerticalTicketMenu"
                                   role="button"
                                   data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalTicketMenu"
                                   aria-expanded="false"
                                   aria-controls="navbarVerticalTicketMenu">
                                    <i class="fa-light fa-headset nav-icon"></i>
                                    <span class="nav-link-title">@lang("Support Ticket")</span>
                                </a>
                                <div id="navbarVerticalTicketMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.ticket','admin.ticket.search', 'admin.ticket.view'], 2) }}"
                                     data-bs-parent="#navbarVerticalTicketMenu">
                                    <a class="nav-link {{ request()->is('admin/tickets/all') ? 'active' : '' }}"
                                       href="{{ route('admin.ticket', 'all') }}">@lang("All Tickets")
                                    </a>
                                    <a class="nav-link {{ request()->is('admin/tickets/answered') ? 'active' : '' }}"
                                       href="{{ route('admin.ticket', 'answered') }}">@lang("Answered Ticket")</a>
                                    <a class="nav-link {{ request()->is('admin/tickets/replied') ? 'active' : '' }}"
                                       href="{{ route('admin.ticket', 'replied') }}">@lang("Replied Ticket")</a>
                                    <a class="nav-link {{ request()->is('admin/tickets/closed') ? 'active' : '' }}"
                                       href="{{ route('admin.ticket', 'closed') }}">@lang("Closed Ticket")</a>
                                </div>
                            </div>
                        @endif




                        @if(adminAccessRoute(config('role.kyc.access.view')) || adminAccessRoute(config('role.kyc_request.access.view')))
                            <span class="dropdown-header mt-4"> @lang('Kyc Management')</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                        @endif
                        @if(adminAccessRoute(config('role.kyc.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.kyc.form.list','admin.kyc.edit','admin.kyc.create']) }}"
                                   href="{{ route('admin.kyc.form.list') }}" data-placement="left">
                                    <i class="bi-stickies nav-icon"></i>
                                    <span class="nav-link-title">@lang('KYC Setting')</span>
                                </a>
                            </div>
                        @endif
                        @if(adminAccessRoute(config('role.kyc_request.access.view')))
                            <div class="nav-item" {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 3) }}>
                                <a class="nav-link dropdown-toggle collapsed" href="#navbarVerticalKycRequestMenu"
                                   role="button"
                                   data-bs-toggle="collapse" data-bs-target="#navbarVerticalKycRequestMenu"
                                   aria-expanded="false"
                                   aria-controls="navbarVerticalKycRequestMenu">
                                    <i class="bi bi-person-lines-fill nav-icon"></i>
                                    <span class="nav-link-title">@lang("KYC Request")</span>
                                </a>
                                <div id="navbarVerticalKycRequestMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 2) }}"
                                     data-bs-parent="#navbarVerticalKycRequestMenu">

                                    <a class="nav-link {{ Request::is('admin/kyc/pending') ? 'active' : '' }}"
                                       href="{{ route('admin.kyc.list', 'pending') }}">
                                        @lang('Pending KYC')
                                    </a>
                                    <a class="nav-link {{ Request::is('admin/kyc/approve') ? 'active' : '' }}"
                                       href="{{ route('admin.kyc.list', 'approve') }}">
                                        @lang('Approved KYC')
                                    </a>
                                    <a class="nav-link {{ Request::is('admin/kyc/rejected') ? 'active' : '' }}"
                                       href="{{ route('admin.kyc.list', 'rejected') }}">
                                        @lang('Rejected KYC')
                                    </a>
                                </div>
                            </div>
                        @endif


                        @if(adminAccessRoute(config('role.user_management.access.view')))
                            <span class="dropdown-header mt-4"> @lang("User Panel")</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>

                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle {{ menuActive(['admin.users'], 3) }}"
                                   href="#navbarVerticalUserPanelMenu"
                                   role="button"
                                   data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalUserPanelMenu"
                                   aria-expanded="false"
                                   aria-controls="navbarVerticalUserPanelMenu">
                                    <i class="bi-people nav-icon"></i>
                                    <span class="nav-link-title">@lang('User Management')</span>
                                </a>
                                <div id="navbarVerticalUserPanelMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.mail.all.user','admin.users','admin.users.add','admin.user.edit',
                                                                        'admin.user.view.profile','admin.user.transaction','admin.user.payment',
                                                                        'admin.user.payout','admin.user.kyc.list','admin.send.email'], 2) }}"
                                     data-bs-parent="#navbarVerticalUserPanelMenu">

                                    <a class="nav-link {{ menuActive(['admin.users']) }}" href="{{ route('admin.users') }}">
                                        @lang('All User')
                                    </a>

                                    @if(adminAccessRoute(config('role.user_management.access.edit')))
                                        <a class="nav-link {{ menuActive(['admin.mail.all.user']) }}"
                                           href="{{ route("admin.mail.all.user") }}">@lang('Mail To Users')</a>
                                    @endif

                                </div>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.subscriber.access.view')) || adminAccessRoute(config('role.withdraw_setting.access.view')) || adminAccessRoute(config('role.payment_setting.access.view')) || adminAccessRoute(config('role.manage_staff.access.view')) || adminAccessRoute(config('role.role_management.access.view')))
                            <span class="dropdown-header mt-4"> @lang('Subscriber')</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                        @endif

                        @if(adminAccessRoute(config('role.subscriber.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive('admin.subscriber.index')  }}"
                                   href="{{ route('admin.subscriber.index') }}" data-placement="left">
                                    <i class="fas fa-envelope-open text-pink nav-icon"></i>
                                    <span class="nav-link-title">@lang('Subscriber List')</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.control_panel.access.view')) || adminAccessRoute(config('role.withdraw_setting.access.view')) || adminAccessRoute(config('role.payment_setting.access.view')) || adminAccessRoute(config('role.manage_staff.access.view')) || adminAccessRoute(config('role.role_management.access.view')))
                            <span class="dropdown-header mt-4"> @lang('SETTINGS PANEL')</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                        @endif



                        @if(adminAccessRoute(config('role.control_panel.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(controlPanelRoutes()) }}"
                                   href="{{ route('admin.settings') }}" data-placement="left">
                                    <i class="bi bi-gear nav-icon"></i>
                                    <span class="nav-link-title">@lang('Control Panel')</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.manage_staff.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.role.staff']) }}"
                                   href="{{ route('admin.role.staff') }}">
                                    <i class="fa-light fa-user nav-icon"></i>
                                    <span class="nav-link-title">@lang("Manage Staff")</span>
                                </a>
                            </div>
                        @endif

                    @if(adminAccessRoute(config('role.role_management.access.view')))
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.role']) }}"
                               href="{{ route('admin.role') }}" data-placement="left">
                                <i class="fa-light fa-users-gear nav-icon"></i>
                                <span class="nav-link-title">@lang('Role & Permission')</span>
                            </a>
                        </div>
                    @endif
                    @if(adminAccessRoute(config('role.payment_setting.access.view')))
                        <div
                            class="nav-item {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 3) }}">
                            <a class="nav-link dropdown-toggle"
                               href="#navbarVerticalGatewayMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalGatewayMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalGatewayMenu">
                                <i class="bi-briefcase nav-icon"></i>
                                <span class="nav-link-title">@lang('Payment Setting')</span>
                            </a>
                            <div id="navbarVerticalGatewayMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 2) }}"
                                 data-bs-parent="#navbarVerticalGatewayMenu">

                                <a class="nav-link {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods',]) }}"
                                   href="{{ route('admin.payment.methods') }}">@lang('Payment Gateway')</a>

                                <a class="nav-link {{ menuActive([ 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit']) }}"
                                   href="{{ route('admin.deposit.manual.index') }}">@lang('Manual Gateway')</a>
                            </div>
                        </div>
                    @endif
                    @if(adminAccessRoute(config('role.withdraw_setting.access.view')))
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit','admin.payout.withdraw.days'], 3) }}"
                                   href="#navbarVerticalWithdrawMenu"
                                   role="button"
                                   data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalWithdrawMenu"
                                   aria-expanded="false"
                                   aria-controls="navbarVerticalWithdrawMenu">
                                    <i class="bi bi-wallet2 nav-icon"></i>
                                    <span class="nav-link-title">@lang('Withdraw Setting')</span>
                                </a>
                                <div id="navbarVerticalWithdrawMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit','admin.payout.withdraw.days'], 2) }}"
                                     data-bs-parent="#navbarVerticalWithdrawMenu">
                                    <a class="nav-link {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit']) }}"
                                       href="{{ route('admin.payout.method.list') }}">@lang('Withdraw Method')</a>


                                    @if(adminAccessRoute(config('role.withdraw_setting.access.edit')))
                                    <a class="nav-link  {{ menuActive(['admin.payout.withdraw.days']) }}"
                                       href="{{ route("admin.payout.withdraw.days") }}">@lang('Withdrawal Days Setup')</a>
                                    @endif
                                </div>
                            </div>
                    @endif


                        @if(adminAccessRoute(config('role.manage_theme.access.view')) || adminAccessRoute(config('role.manage_menu.access.view')) || adminAccessRoute(config('role.pages.access.view')))
                            <span class="dropdown-header mt-4">@lang("Themes Settings")</span>
                            <small class="bi-three-dots nav-subtitle-replacer"></small>
                        @endif

                    <div id="navbarVerticalThemeMenu">
                        @if(adminAccessRoute(config('role.manage_theme.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.theme']) }}"
                                   href="{{ route('admin.theme') }}"
                                   data-placement="left">
                                    <i class="fas fa-image text-pink nav-icon"></i>
                                    <span class="nav-link-title">@lang('Themes')</span>
                                </a>
                            </div>
                        @endif



                        @if(adminAccessRoute(config('role.pages.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.page.index','admin.create.page','admin.edit.page']) }}"
                                   href="{{ route('admin.page.index', basicControl()->theme) }}"
                                   data-placement="left">
                                    <i class="fa-light fa-list nav-icon"></i>
                                    <span class="nav-link-title">@lang('Pages')</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute(config('role.manage_menu.access.view')))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.manage.menu']) }}"
                                   href="{{ route('admin.manage.menu') }}" data-placement="left">
                                    <i class="bi-folder2-open nav-icon"></i>
                                    <span class="nav-link-title">@lang('Manage Menu')</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    @php
                        $segments = request()->segments();
                        $last  = end($segments);
                    @endphp
                        @if(adminAccessRoute(config('role.manage_content.access.view')))
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 3) }}"
                                   href="#navbarVerticalContentsMenu"
                                   role="button" data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalContentsMenu" aria-expanded="false"
                                   aria-controls="navbarVerticalContentsMenu">
                                    <i class="fa-light fa-pen nav-icon"></i>
                                    <span class="nav-link-title">@lang('Manage Content')</span>
                                </a>
                                <div id="navbarVerticalContentsMenu"
                                     class="content-manage nav-collapse collapse {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 2) }}"
                                     data-bs-parent="#navbarVerticalContentsMenu">
                                    @foreach(array_diff(array_keys(config('contents')[basicControl()->theme]), ['message','content_media','app_steps']) as $name)
                                        <div class="contentAll d-flex justify-content-between">
                                            <a class="nav-link contentTitle  {{($last == $name) ? 'active' : '' }}"
                                               href="{{ route('admin.manage.content', $name) }}">@lang(\Illuminate\Support\Str::limit(stringToTitle($name),16))</a>

                                            <button class="btn btn-white btn-sm sidebarContentImage contentImage" data-title="{{stringToTitle($name)}}" data-image="{{asset(config('contents.'.getTheme().'.'.$name.'.prieview'))}}" data-bs-placement="top" data-bs-toggle="tooltip" aria-label="Section Style" data-bs-original-title="{{stringToTitle($name)}}">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                        <div class="contentAll d-flex justify-content-between">
                                            <a class="nav-link contentTitle  {{($last == 'app_steps') ? 'active' : '' }}"
                                               href="{{ route('admin.manage.content', 'app_steps') }}">@lang(\Illuminate\Support\Str::limit(stringToTitle('app_steps'),16))</a>
                                        </div>
                                </div>
                            </div>
                        @endif



                        @if(adminAccessRoute(config('role.manage_blog.access.view')))
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 3) }}"
                                   href="#navbarVerticalBlogMenu"
                                   role="button" data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalBlogMenu" aria-expanded="false"
                                   aria-controls="navbarVerticalBlogMenu">
                                    <i class="fa-light fa-newspaper nav-icon"></i>
                                    <span class="nav-link-title">@lang('Manage Blog')</span>
                                </a>
                                <div id="navbarVerticalBlogMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 2) }}"
                                     data-bs-parent="#navbarVerticalBlogMenu">
                                    <a class="nav-link {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit']) }}"
                                       href="{{ route('admin.blog-category.index') }}">@lang('Blog Category')</a>

                                    <a class="nav-link {{ menuActive(['admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*']) }}"
                                       href="{{ route('admin.blogs.index') }}">@lang('Blog')</a>
                                </div>
                            </div>
                        @endif



                    @foreach(collect(config('generalsettings.settings')) as $key => $setting)
                        <div class="nav-item d-none">
                            <a class="nav-link  {{ isMenuActive($setting['route']) }}"
                               href="{{ getRoute($setting['route'], $setting['route_segment'] ?? null) }}">
                                <i class="{{$setting['icon']}} nav-icon"></i>
                                <span class="nav-link-title">{{ __(getTitle($key.' '.'Settings')) }}</span>
                            </a>
                        </div>
                    @endforeach


                </div>

                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <span class="dropdown-header">@lang('Version 8.0')</span>
                        </li>
                        <li class="navbar-vertical-footer-list-item">
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                        id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-dropdown-animation></button>
                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless"
                                     aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-moon-stars"
                                       data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate"
                                              title="Auto (system default)">@lang("Default")</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-brightness-high"
                                       data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate"
                                              title="Default (light mode)">@lang("Light Mode")</span>
                                    </a>
                                    <a class="dropdown-item active" href="javascript:void(0)" data-icon="bi-moon"
                                       data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Dark">@lang("Dark Mode")</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>


