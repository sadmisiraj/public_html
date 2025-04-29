@auth
    @if(basicControl()->in_app_notification == 1)
        <div class="notification-panel push-notification">
            <button class="dropdown-toggle">
                <img src="{{asset(template(true).'img/icon/notification.png')}}" alt="notification">
                <span class="badge" v-cloak>@{{items.length}}</span>
            </button>
            <ul class="notification-dropdown">
                <div class="dropdown-box list-unstyled">
                    <li v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i aria-hidden="true" class="fas fa-bell"></i>
                            <div class="text notify_description">
                                <p v-cloak v-html="item.description.text"></p>
                                <span class="time" v-cloak>@{{ items.formatted_date }}</span>
                            </div>
                        </a>
                    </li>
                </div>

                <div class="clear-all fixed-bottom">
                    <a href="javascript:void(0)" v-if="items.length == 0"
                       class="">@lang('You have no notifications')</a>
                    <a href="javascript:void(0)" role="button" type="button" v-if="items.length > 0"
                       @click.prevent="readAll" class="btn-clear golden-text">@lang('Clear All')</a>
                </div>
            </ul>
        </div>
    @endif
@endauth

