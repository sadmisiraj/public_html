
@auth
    @if(basicControl()->in_app_notification)
        <div class="notification-panel" id="pushNotificationArea">
            <button class="dropdown-toggle">
                <i class="fal fa-bell" aria-hidden="true"></i>
                <span class="count">@{{items.length}}</span>
            </button>
            <ul class="notification-dropdown">
                <div class="dropdown-box">
                    <li v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="fal fa-bell" aria-hidden="true"></i>
                            <div class="text">
                                <p>@{{item.description.text}}</p>
                                <span class="time">@{{ item.formatted_date }}</span>
                            </div>
                        </a>
                    </li>
                </div>
                <div class="clear-all fixed-bottom">
                    <a href="javascript:void(0)" v-if="items.length == 0"
                       >@lang('You have no notifications')</a>
                    <a href="javascript:void(0)" v-if="items.length > 0" @click.prevent="readAll">@lang('Clear all')</a>
                </div>
            </ul>
        </div>
    @endif
@endauth
