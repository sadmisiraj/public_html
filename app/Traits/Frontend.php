<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\ContentDetails;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\ManagePlan;
use App\Models\Payout;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait Frontend
{
    protected function getSectionsData($sections, $content, $selectedTheme)
    {

        $contentDetailsModel = ContentDetails::query()->with('content');
        if ($sections == null) {
            $data = ['support' => $content,];
            return view("themes.$selectedTheme.support", $data)->toHtml();
        }
        $theme = getTheme();
        $prefix = $theme . '_';
        $updatedArray = array_map(function ($value) use ($prefix) {
            return $prefix . $value;
        }, $sections);
        $contentKeys = collect(config('contents.' . $theme))->keys()->toArray();

        if (config('demo.IS_DEMO_CONTENT')) {
            $contentData = (clone $contentDetailsModel)
                ->whereHas('content', function ($query) use ($updatedArray) {
                    $query->whereIn('name', $updatedArray);
                })
                ->get();

        } else {
            try {
                DB::connection()->getPdo();
                $contentDetails = \Cache::get('ContentDetails');
                $themeSections = array_map(function ($value) use ($prefix) {
                    return $prefix . $value;
                }, $contentKeys);
                if (!$contentDetails) {
                    $contentDetails = (clone $contentDetailsModel)
                        ->whereHas('content', function ($query) use ($themeSections) {
                            $query->whereIn('name', $themeSections);
                        })
                        ->get();
                    \Cache::put('ContentDetails', $contentDetails, now()->addMinutes(30));
                }
            } catch (\Exception $e) {

            }
            $contentData = $contentDetails->filter(function ($item) use ($updatedArray) {
                return in_array($item->content->name, $updatedArray);
            });
        }


        foreach ($sections as $section) {
            $section_name = $theme . '_' . $section;

            $singleContent = $contentData->where('content.name', $section_name)->where('content.type', 'single')->first() ?? [];
            $multipleContents = $contentData->where('content.name', $section_name)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
            });
            if ($section == 'deposit_withdrawals_section') {
                $deposits = Deposit::query()
                    ->with(['user:id,firstname,lastname,image,image_driver', 'gateway:id,name'])
                    ->whereHas('user')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                $withdraws = Payout::query()
                    ->with(['user:id,firstname,lastname,image,image_driver', 'method:id,name'])
                    ->whereHas('user')
                    ->where('status', 2)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                $data['deposits'] = $deposits;
                $data['withdraws'] = $withdraws;
            } elseif ($section == 'investor_section') {
                $investors = User::where('total_invest', '>', 1)
                    ->select('id', 'username', 'total_invest', 'image', 'image_driver')
                    ->orderBy('total_invest', 'desc')
                    ->take(4)
                    ->get();
                $data['investors'] = $investors;
            } elseif ($section == 'investment_section') {
                $plans = ManagePlan::query()
                    ->with('time')
                    ->where('status', 1)
                    ->get();
                $data['plans'] = $plans;
            } elseif ($section == 'we_accepted_section' || $section == 'payment_section') {
                $gateways = Gateway::where('status', 1)->orderBy('sort_by')->get();
                $data['gateways'] = $gateways;
            } elseif ($section == 'blog_section') {
                $blogs = Blog::query()
                    ->with(['details', 'createdBy:id,name'])
                    ->whereHas('createdBy')
                    ->take(4)->get();
                $data['blogs'] = $blogs;
            } elseif ($section == 'referral_section') {
                $referral = Referral::where('commission_type', 'deposit')->orderBy('level')->get();
                $data['referralLevel'] = $referral;
            }

            $data[$section] = [
                'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                'multiple' => $multipleContents,
            ];
            $replacement = view("themes." . $theme . ".sections.{$section}", $data)->toHtml();

            $content = str_replace('<div class="custom-block" contenteditable="false"><div class="custom-block-content">[[' . $section . ']]</div>', $replacement, $content);
            $content = str_replace('<span class="delete-block">×</span>', '', $content);
            $content = str_replace('<span class="up-block">↑</span>', '', $content);
            $content = str_replace('<span class="down-block">↓</span></div>', '', $content);
            $content = str_replace('<p><br></p>', '', $content);
        }

        return $content;
    }
}
