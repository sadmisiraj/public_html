<?php
return [

    'lightagro' =>[
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'background_image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'background_image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'countable_item_name' => 'text',
                    'count' => 'number',
                    'icon' => 'file'
                ],
                'validation' => [
                    'countable_item_name.*' => 'required|max:80',
                    'count.*' => 'required|numeric',
                    'icon.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'description' => 'textarea',
                    'image_1' => 'file',
                    'image_2' => 'file',
                    'image_3' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'description.*' => 'required|max:2000',
                    'image_1.*' => 'file',
                    'image_2.*' => 'file',
                    'image_3.*' => 'file',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/about.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/referral.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/investment.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'image_1' => 'file',
                    'image_2' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'image_1.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'image_2.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/how_work.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/investor.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'field_name.*' => 'required|max:60',
                    'short_description.*' => 'required|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/why_chose.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/last_deposit.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/testimonial.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/blog.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'question' => 'text',
                    'answer' => 'textarea',
                ],
                'validation' => [
                    'question.*' => 'required|max:250',
                    'answer.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/faq.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url',
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'address' => 'text',
                    'newsletter_title' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required|email',
                    'phone.*' => 'required',
                    'address.*' => 'nullable',
                    'newsletter_title.*' => 'required | max:60',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightagro/img/privacy.png'
        ],

    ],
    'dodgerblue' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'background_image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'background_image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ],
            ],

            'multiple' => [
                'field_name' => [
                    'item_name' => 'text',
                    'item' => 'text',
                ],
                'validation' => [
                    'item_name.*' => 'required|max:80',
                    'item.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/hero.png'

        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'description' => 'textarea',
                    'image' => 'file',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'description.*' => 'required|max:2000',
                    'image' => 'file',

                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/about.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/how_work.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/investment.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'field_name.*' => 'required|max:60',
                    'short_description.*' => 'required|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/why_chose.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/last_deposit.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/referral.png'

        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/testimonial.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
             'prieview' => 'assets/themes/dodgerblue/img/sections/blog.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'question' => 'text',
                    'answer' => 'textarea',
                ],
                'validation' => [
                    'question.*' => 'required|max:250',
                    'answer.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/faq.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                    'email' => 'text',
                    'telephone_number' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                    'telephone_number.*' => 'required',
                    'email.*' => 'required',
                    'location.*' => 'required',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url',
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/contact.png'
        ],
        'login_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/login.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'address' => 'text',
                    'newsletter_title' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required|email',
                    'phone.*' => 'required',
                    'address.*' => 'nullable',
                    'newsletter_title.*' => 'required | max:60',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/dodgerblue/img/sections/privacy.png'
        ],

    ],
    'deepblack' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'image' => 'file',
                    'background_image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'short_text.*' => 'nullable|max:150',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'background_image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'description.*' => 'required|max:2000',
                    'image.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/about.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'short_description.*' => 'required|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/why_chose.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/investment.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'question' => 'text',
                    'answer' => 'textarea',
                ],
                'validation' => [
                    'question.*' => 'required|max:250',
                    'answer.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/faq.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/referral.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/testimonial.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/how_work.png'
        ],
        'know_more_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'count' => 'number',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'count.*' => 'required|numeric',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/know_more.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/last_deposit.png'
        ],
        'news_letter_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/subscribe.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/blog.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'location' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'address' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required|email',
                    'phone.*' => 'required',
                    'address.*' => 'nullable',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'text'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblack/img/sections/privacy.png'
        ],
    ],
    'lightyellow' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'description' => 'textarea',
                    'button_name' => 'text',
                    'button_link' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'description.*' => 'required|max:2000',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'image.*' => 'file',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/about.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/why-choose.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/investment.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/how_work.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/faq.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/testimonial.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'text',
                    'short_description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_description.*' => 'nullable|max:400',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/referral.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_text' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_text.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/last_deposit.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/blog.png'
        ],
        'know_more_section' =>[
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/know_more.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'location' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/contact.png'
        ],
        'login_registration_section' => [
            'single' => [
                'field_name' => [
                    'login_title' => 'text',
                    'registration_title' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'login_title.*' => 'required|max:100',
                    'registration_title.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/login.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'newsletter_title' => 'text',
                    'newsletter_sub_title' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'newsletter_title.*' => 'required',
                    'newsletter_sub_title.*' => 'required',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'text'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightyellow/img/sections/privacy.png'
        ],
    ],
    'deepblue' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'short_details.*' => 'required|max:300',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'description.*' => 'required|max:2000',
                    'image.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
             'prieview' => 'assets/themes/deepblue/images/sections/about.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/why_choose.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/investment.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'video_url' => 'url',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'video_url.*' => 'nullable',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/how_work.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/last_deposit.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'required|max:200',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/testimonial.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'newsletter_heading' => 'text',
                    'newsletter_sub_heading' => 'text',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'newsletter_heading.*' => 'nullable|max:60',
                    'newsletter_sub_heading.*' => 'required|max:100',

                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/referral.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/blog.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/faq.png'
        ],
        'we_accepted_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/we_accept.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'title' => 'text',
                    'location' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'title.*' => 'required|max:60',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required',
                    'telephone.*' => 'required',
                    'location.*' => 'required|max:150',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'text'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/deepblue/images/sections/privacy.png'
        ],
    ],
    'screaminlizard' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'background_image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'background_image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/hero.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_link.*' => 'nullable',
                    'description.*' => 'required|max:2000',
                    'image.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/about.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/how_work.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/investment.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/why_choose.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/last_deposit.png'

        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/testimonial.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:200',

                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/referral.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/faq.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/blog.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                    'newsletter_title' => 'text'
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required',
                    'telephone.*' => 'required',
                    'location.*' => 'required|max:150',
                    'newsletter_title.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/screaminlizard/img/sections/privacy.png'
        ],
    ],
    'lightpink' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                    'image' => 'file',
                    'background_image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                    'image.*' =>'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'background_image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                    'description.*' => 'required|max:2000',
                    'image.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/about.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/why_choose.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/investment.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/faq.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/referral.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/testimonial.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/how_work.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/last_deposit.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/blog.png'
        ],
        'news_letter_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/subscribe.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                    'title.*' => 'required|max:60',
                    'sub_title.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/contact.png'
        ],
        'login_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/login.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required',
                    'telephone.*' => 'required',
                    'location.*' => 'required|max:150',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightpink/img/sections/privacy.png'
        ]
    ],
    'darkpurple' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                    'description.*' => 'required|max:2000',
                    'image.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/about.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/investment.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/why_choose.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/last_deposit.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'video_url' => 'url',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'video_url.*' => 'nullable',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/how_work.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/referral.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/testimonial.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/blog.png'
        ],
        'faq_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/faq.png'
        ],
        'news_letter_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/subscribe.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'address' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'email.*' => 'required',
                    'telephone.*' => 'required',
                    'address.*' => 'required|max:150',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/darkpurple/img/sections/privacy.png'
        ],
    ],
    'lightorange' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                ],
                'validation' => [
                    'heading.*' => 'required|max:80',
                    'sub_heading.*' => 'required|max:130',
                    'short_details.*' => 'nullable|max:150',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/hero.png'
        ],
        'feature_section' => [
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:80',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/feature.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/how_work.png'
        ],
        'support_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/support.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/investment.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/last_deposit.png'
        ],
        'know_more_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/know_more.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'information' => 'text',
                    'icon' => 'file',
                ],
                'validation' => [
                    'title.*' => 'required|max:60',
                    'information.*' => 'required|max:600',
                    'icon.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/why_choose.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'nullable|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/testimonial.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'affiliate_heading' => 'text',
                    'affiliate_sub_heading' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'url',

                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'affiliate_heading.*' => 'nullable|max:80',
                    'affiliate_sub_heading.*' => 'nullable|max:80',
                    'button_name.*' => 'required|max:30',
                    'button_url.*' => 'nullable',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/referral.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/blog.png'
        ],
        'we_accepted_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/we_accept.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'title.*' => 'required|max:250',
                    'description.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/faq.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'email' => 'text',
                    'telephone' => 'text',
                    'location' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'location.*' => 'nullable|max:300',
                    'email.*' => 'nullable|max:100',
                    'telephone.*' => 'nullable|max:100',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/contact.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/footer.png'
        ],
        'topbar_section' => [
            'single' => [
                'field_name' => [
                    'email' => 'text',
                    'telephone' => 'text',
                ],
                'validation' => [
                    'email.*' => 'required',
                    'telephone.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/top_bar.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/privacy.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/lightorange/images/sections/privacy.png'
        ],
    ],
    'estate_rise' => [
        'hero_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'short_details' => 'textarea',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'video_url' => 'url',
                    'image_1' => 'file',
                    'image_2' => 'file',
                    'image_3' => 'file',
                    'image_4' => 'file',
                    'image_5' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'short_details.*' => 'nullable|max:300',
                    'button_name.*' => 'required|max:25',
                    'button_link' => 'nullable',
                    'video_url' => 'nullable',
                    'image_1' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'image_2' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'image_3' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'image_4' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'image_5' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/hero.png'
        ],
        'feature_section' => [
            'single' => [
                'field_name' => [
                    'title' => 'text',
                    'sub_title' => 'text',
                    'short_details' => 'textarea',
                    'circle_title' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'title' => 'required|max:100',
                    'sub_title' => 'required|max:200',
                    'short_details' => 'required|max:300',
                    'circle_title' => 'required|max:50',
                    'image' => 'nullable|max:2000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'countable_item_name' => 'text',
                    'count' => 'number',
                    'prefix' => 'text',
                    'icon' => 'file'
                ],
                'validation' => [
                    'countable_item_name.*' => 'required|max:80',
                    'count.*' => 'required|numeric',
                    'prefix' => 'nullable',
                    'icon.*' => 'nullable|max:2000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/feature.png'
        ],
        'about_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details_1' => 'textarea',
                    'short_details_2' => 'textarea',
                    'button_name' => 'text',
                    'button_link' => 'url',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:50',
                    'sub_heading.*' => 'required|max:100',
                    'short_details_1.*' => 'nullable|max:500',
                    'short_details_2.*' => 'nullable|max:500',
                    'button_name.*' => 'required|max:25',
                    'button_link' => 'nullable',
                    'image' => 'nullable|max:3000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/about.png'
        ],
        'why_chose_us_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'image' => 'nullable|max:3000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'field_name.*' => 'required|max:60',
                    'short_description.*' => 'required|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',

                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/why_choose.png'
        ],
        'investment_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:200',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/pricing.png'
        ],
        'how_works_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'short_details.*' => 'required|max:200',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'title' => 'text',
                    'short_description' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'title.*' => 'required|max:100',
                    'short_description.*' => 'required|max:300',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/how_work.png'
        ],
        'investor_section' =>[
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/investor.png'
        ],
        'deposit_withdrawals_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg'
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/last_deposit.png'
        ],
        'testimonial_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'name' => 'text',
                    'designation' => 'text',
                    'rating' => 'number',
                    'description' => 'textarea',
                    'image' => 'file',
                ],
                'validation' => [
                    'name.*' => 'required|max:60',
                    'designation.*' => 'required|max:100',
                    'description.*' => 'required|max:600',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'rating' => 'required|max:5'
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/testimonial.png'
        ],
        'referral_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:200',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/referral.png'
        ],
        'payment_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/we_accept.png'
        ],
        'blog_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/blog.png'
        ],
        'faq_section' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                    'short_details' => 'text',
                    'button_name' => 'text',
                    'button_url' => 'text',
                    'image' => 'file'
                ],
                'validation' => [
                    'heading.*' => 'required|max:60',
                    'sub_heading.*' => 'required|max:100',
                    'short_details.*' => 'nullable|max:300',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                    'button_name.*' => 'required|max:20',
                    'button_url.*' => 'nullable',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'question' => 'text',
                    'answer' => 'textarea',
                ],
                'validation' => [
                    'question.*' => 'required|max:250',
                    'answer.*' => 'required|max:500',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/faq.png'
        ],
        'contact_section' => [
            'single' => [
                'field_name' => [
                    'heading_1' => 'text',
                    'heading_2' => 'text',
                    'short_details_1' => 'text',
                    'short_details_2' => 'text',
                    'telephone' => 'text',
                    'email' => 'text',
                    'address' => 'text',
                    'map_url' => 'url'

                ],
                'validation' => [
                    'heading_1.*' => 'required|max:60',
                    'heading_2.*' => 'required|max:60',
                    'short_details_1.*' => 'nullable|max:300',
                    'short_details_2.*' => 'nullable|max:300',
                    'telephone' => 'required',
                    'email' => 'required',
                    'address' => 'required',
                    'map_url' => 'nullable'
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url',
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/contact.png'
        ],
        'login_registration_section' => [
            'single' => [
                'field_name' => [
                    'login_title' => 'text',
                    'login_sub_title' => 'text',
                    'registration_title' => 'text',
                    'registration_sub_title' => 'text',
                    'image' => 'file',
                ],
                'validation' => [
                    'login_title.*' => 'required|max:80',
                    'login_sub_title.*' => 'required|max:100',
                    'registration_title.*' => 'required|max:80',
                    'registration_sub_title.*' => 'required|max:100',
                    'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/login.png'
        ],
        'footer' => [
            'single' => [
                'field_name' => [
                    'short_description' => 'text',
                    'newsletter_title' => 'text',
                ],
                'validation' => [
                    'short_description.*' => 'required|max:600',
                    'newsletter_title.*' => 'required | max:60',
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'social_link' => 'url'
                ],
                'validation' => [
                    'social_link.*' => 'required',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/footer.png'
        ],
        'privacy_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/privacy.png'
        ],
        'terms_condition_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/cookie.png'
        ],
        'cookie_policy_section' => [
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'description' => 'textarea',
                ],
                'validation' => [
                    'heading.*' => 'required|max:200',
                    'sub_heading.*' => 'required|max:2000',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/cookie.png'
        ],
        'user_dashboard' => [
            'single' => [
                'field_name' => [
                    'heading' => 'text',
                    'sub_heading' => 'text',
                ],
                'validation' => [
                    'heading.*' => 'required|max:150',
                    'sub_heading.*' => 'required|max:250',
                ]
            ],
            'prieview' => 'assets/themes/estate_rise/img/sections/dashboard.png'
        ]
    ],
    'app_steps' => [
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'textarea',
                'image' => 'file'
            ],
            'validation' => [
                'title.*' => 'required|max:200',
                'description.*' => 'required|max:500',
                'image.*' => 'nullable|max:5000|image|mimes:jpeg,png,jpg',
            ]
        ]
    ],
    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
        'integer' => 'This field must be an integer value',
    ],
    'content_media' => [
        'image' => 'file',
        'background_image' => 'file',
        'thumb_image' => 'file',
        'image_1' => 'file',
        'image_2' => 'file',
        'image_3' => 'file',
        'image_4' => 'file',
        'image_5' => 'file',
        'my_link' => 'url',
        'social_link' => 'url',
        'icon' => 'icon',
        'count' => 'number',
        'bonus' => 'number',
        'phone' => 'number',
        'rating' => 'number',
        'start_date' => 'date',
        'video_url' => 'url',
        'button_url' => 'url',
        'button_link' => 'url',
        'map_url' => 'url'
    ]
];

