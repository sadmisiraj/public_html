<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        {
            $pages = [
//                ['name' => 'Blog','slug' => 'blogs', 'template_name' => 'estate_rise', 'type' => 1],
//                ['name' => 'Login','slug' => 'login', 'template_name' => 'estate_rise', 'type' => 1],
//                ['name' => 'Registration','slug' => 'registration', 'template_name' => 'estate_rise', 'type' => 1],
//
//                ['name' => 'Forget Password','slug' => 'password-reset', 'template_name' => 'estate_rise', 'type' => 1],
//                ['name' => 'SMS Verification','slug' => 'sms-verification', 'template_name' => 'estate_rise', 'type' => 1],
//                ['name' => 'Email Verification','slug' => 'email-verification', 'template_name' => 'estate_rise', 'type' => 1],
//                ['name' => '2FA Verification','slug' => 'two-fa-verification', 'template_name' => 'estate_rise', 'type' => 1],

            ];
            foreach ($pages as $page) {
                Page::Create(
                    [
                        'name' => $page['name'],
                        'slug' => $page['slug'],
                        'template_name' => $page['template_name'],
                        'type' => $page['type'],
                    ],
                    [
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
             }
        }

    }
}
