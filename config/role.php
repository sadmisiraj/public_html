<?php

return [
    'dashboard' => [
        'label' => "Dashboard",
        'access' => [
            'view' => ['admin.dashboard','admin.invest.history'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ],
    ],
    'schedule' => [
        'label' => "Schedule",
        'access' => [
            'view' => ['admin.schedule'],
            'add' => ['admin.schedule.store'],
            'edit' => ['admin.schedule.update'],
            'delete' => [],
        ]
    ],
    'manage_plan' => [
        'label' => "Manage Plan",
        'access' => [
            'view' => ['admin.plan','admin.plan.list'],
            'add' => ['admin.plan.create','admin.plan.store'],
            'edit' => ['admin.plan.edit','admin.plan.update'],
            'delete' => [],
        ]
    ],
    'referral' => [
        'label' => "Referral",
        'access' => [
            'view' => ['admin.referral-commission'],
            'add' => [],
            'edit' => ['admin.referral-commission.action','admin.referral-commission.store'],
            'delete' => [],
        ]
    ],
    'ranking' => [
        'label' => "User Ranking",
        'access' => [
            'view' => ['admin.rankingsUser'],
            'add' => ['admin.rankCreate','admin.rankStore'],
            'edit' => ['admin.rankEdit','admin.rankUpdate'],
            'delete' => ['admin.rankDelete'],
        ]
    ],

    'investment' => [
        'label' => "Investment",
        'access' => [
            'view' => ['admin.investments','admin.investment.list'],
            'add' => [],
            'edit' => ['admin.terminate.investment'],
            'delete' => [],
        ]
    ],
    'commission' => [
        'label' => "Commission",
        'access' => [
            'view' => ['admin.commission','admin.commission.list'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ]
    ],
    'transaction' => [
        'label' => "Transaction",
        'access' => [
            'view' => ['admin.transaction','admin.transaction.search'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ]
    ],
    'withdraw' => [
        'label' => "Withdraw Log",
        'access' => [
            'view' => ['admin.payout.log','admin.payout.search','admin.payout.pending'],
            'add' => [],
            'edit' => ['admin.payout.action'],
            'delete' => [],
        ]
    ],
    'payment' => [
        'label' => "Payment Log",
        'access' => [
            'view' => ['admin.payment.log','admin.payment.search'],
            'add' => [],
            'edit' => ['admin.payment.action'],
            'delete' => []
        ]
    ],
    'payment_request' => [
        'label' => "Payment Request",
        'access' => [
            'view' => ['admin.payment.pending','admin.payment.request'],
            'add' => [],
            'edit' => ['admin.payment-request.multiple.approved'],
            'delete' => [],
        ]
    ],
    'support_ticket' => [
        'label' => "Support Ticket",
        'access' => [
            'view' => ['admin.ticket','admin.ticket.search'],
            'add' => [],
            'edit' => ['admin.ticket.reply','admin.ticket.download','admin.ticket.closed','admin.ticket.view'],
            'delete' => []
        ]
    ],

    'kyc' => [
        'label' => "KYC",
        'access' => [
            'view' => ['admin.kyc.form.list'],
            'add' => ['admin.kyc.store','admin.kyc.create'],
            'edit' => ['admin.kyc.edit','admin.kyc.update'],
            'delete' => [],
        ]
    ],
    'kyc_request' => [
        'label' => "KYC Request",
        'access' => [
            'view' => ['admin.kyc.list','admin.kyc.search','admin.kyc.view'],
            'add' => [],
            'edit' => ['admin.kyc.action'],
            'delete' => []
        ]
    ],
    'user_management' => [
        'label' => "User Management",
        'access' => [
            'view' => ['admin.users','admin.users.search','admin.user.kyc.list','admin.user.kyc.search','admin.user.transaction','admin.user.transaction.search','admin.user.payment','admin.user.payment.search','admin.user.payout','admin.user.payout.search','admin.user.create.success.message','admin.user.view.profile'],
            'add' => ['admin.users.add','admin.user.store'],
            'edit' => ['admin.login.as.user','admin.block.profile','admin.user.edit','admin.badgeUpdate','admin.user.update','admin.user.email.update','admin.user.username.update','admin.user.update.balance','admin.user.password.update','admin.user.preferences.update','admin.user.twoFa.update','admin.send.email','admin.user.email.send','admin.mail.all.user'],
            'delete' => ['admin.user.delete.multiple','admin.user.delete'],
        ]
    ],
    'subscriber' => [
        'label' => "Subscriber",
        'access' => [
            'view' => [
                'admin.subscriber.index',
                'admin.subscriber.sendEmail',
                'admin.subscriber.list',
            ],
            'add' => [],
            'edit' => [
                'admin.subscriber.mail',
            ],
            'delete' => [
                'admin.subscriber.remove'
            ],
        ],
    ],

    'control_panel' => [
        'label' => "Control Panel",
        'access' => [
            'view' => ['admin.settings','admin.app.settings','admin.cookie','admin.basic.control','admin.currency.exchange.api.config','admin.storage.index','admin.maintenance.index','admin.logo.settings','admin.firebase.config','admin.pusher.config','admin.email.control','admin.email.template.default','admin.email.templates','admin.sms.templates','admin.in.app.notification.templates','admin.push.notification.templates','admin.sms.controls','admin.sms.controls','admin.plugin.config','admin.tawk.configuration','admin.fb.messenger.configuration','admin.google.recaptcha.configuration','admin.google.analytics.configuration','admin.manual.recaptcha','admin.translate.api.setting','admin.language.index'],
            'add' => ['admin.language.create','admin.language.store'],
            'edit' => ['admin.basic.control.update','admin.app.settings.update','admin.update.cookie','admin.basic.control.activity.update','admin.currency.exchange.api.config.update','admin.storage.edit','admin.storage.update','admin.storage.setDefault','admin.maintenance.mode.update','admin.logo.update','admin.firebase.config.update','admin.pusher.config.update','admin.email.config.edit','admin.email.config.update','admin.email.set.default','admin.test.email','admin.email.template.edit','admin.email.template.update','admin.sms.template.edit','admin.sms.template.update','admin.in.app.notification.template.edit','admin.in.app.notification.template.update','admin.push.notification.template.edit','admin.push.notification.template.update','admin.sms.config.edit','admin.sms.config.update','admin.manual.sms.method.update','admin.sms.set.default','admin.tawk.configuration.update','admin.fb.messenger.configuration.update','admin.google.recaptcha.Configuration.update','admin.google.analytics.configuration.update','admin.manual.recaptcha.update','admin.active.recaptcha','admin.translate.api.config.edit','admin.translate.api.setting.update','admin.translate.set.default','admin.language.edit','admin.language.update','admin.change.language.status'],
            'delete' => ['admin.language.delete']
        ]
    ],
    'manage_staff' => [
        'label' => "Manage Staff",
        'access' => [
            'view' => ['admin.role.staff','admin.get.staff.list'],
            'add' => ['admin.staff.create','admin.role.usersCreate'],
            'edit' => ['admin.edit.staff','admin.staff.role.update','admin.role.statusChange','admin.role.usersLogin'],
            'delete' => []
        ]
    ],
    'role_management' => [
        'label' => "Role & Permission",
        'access' => [
            'view' => ['admin.role','admin.get.role.list','admin.get.role'],
            'add' => ['admin.role.create'],
            'edit' => ['admin.role.update'],
            'delete' => ['admin.role.delete'],
        ]
    ],
    'payment_setting' => [
        'label' => 'Payment Setting',
        'access' => [
            'view' => ['admin.payment.methods','admin.deposit.manual.index'],
            'add' => ['admin.deposit.manual.create','admin.deposit.manual.store'],
            'edit' => ['admin.edit.payment.methods','admin.update.payment.methods','admin.sort.payment.methods','admin.payment.methods.deactivate','admin.deposit.manual.edit','admin.deposit.manual.update'],
            'delete' => []
        ]
    ],
    'withdraw_setting' => [
        'label' => 'Withdraw Setting',
        'access' => [
            'view' => ['admin.payout.method.list'],
            'add' => ['admin.payout.method.create','admin.payout.method.store'],
            'edit' => ['admin.payout.manual.method.edit','admin.payout.method.edit','admin.payout.method.update','admin.payout.method.auto.update','admin.payout.active.deactivate','admin.payout.withdraw.days','admin.withdrawal.days.update'],
            'delete' => []
        ]
    ],
    'manage_theme' => [
        'label' => 'Manage Theme',
        'access' => [
            'view' => ['admin.theme'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ]
    ],
    'pages' => [
        'label' => 'Pages',
        'access' => [
            'view' => ['admin.page.index'],
            'add' => ['admin.create.page','admin.create.page.store'],
            'edit' => ['admin.edit.page','admin.update.page','admin.update.slug','admin.edit.static.page','admin.update.static.page','admin.page.seo','admin.page.seo.update'],
            'delete' => ['admin.page.delete'],
        ]
    ],
    'manage_menu' => [
        'label' => 'Manage Menu',
        'access' => [
            'view' => ['admin.manage.menu','admin.get.custom.link'],
            'add' => ['admin.header.menu.item.store','admin.footer.menu.item.store','admin.add.custom.link'],
            'edit' => ['admin.edit.custom.link','admin.update.custom.link'],
            'delete' => ['admin.delete.custom.link'],
        ]
    ],
    'manage_content' => [
        'label' => 'Manage Content',
        'access' => [
            'view' => ['admin.manage.content'],
            'add' => ['admin.content.store','admin.manage.content.multiple','admin.content.multiple.store'],
            'edit' => ['admin.content.item.edit','admin.multiple.content.item.update'],
            'delete' => ['admin.content.item.delete'],
        ]
    ],

    'manage_blog' => [
        'label' => 'Manage Blog',
        'access' => [
            'view' => ['admin.blogs.index','admin.blog-category.index'],
            'add' => ['admin.blogs.create','admin.blogs.store','admin.blog-category.create','admin.blog-category.store'],
            'edit' => ['admin.blogs.edit','admin.blogs.update','admin.blog-category.edit','admin.blog-category.update',],
            'delete' => ['admin.blogs.delete','admin.blog-category.delete'],
        ]
    ]
];
