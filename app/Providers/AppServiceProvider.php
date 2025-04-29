<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\ContentDetails;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\ManageMenu;
use App\Models\ManagePlan;
use App\Models\PageDetail;
use App\Models\Payout;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Mailchimp\Transport\MandrillTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendgrid\Transport\SendgridTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {



        try {
            DB::connection()->getPdo();

            $data['basicControl'] = basicControl();
            View::share($data);


            view()->composer([
               'themes.deepblue.partials.topbar',
                'themes.deepblue.partials.topbar-auth',
                'themes.lightorange.partials.topbar',
                'themes.lightorange.partials.topbar-auth',
            ], function ($view) {
                $languages = Language::orderBy('name')->where('status', 1)->get();
                $view->with('languages', $languages);
                $languagesStr = '';
                Language::orderBy('name')->where('status', 1)->get()->map(function ($item) use (&$languagesStr) {
                    $languagesStr .= '"' . strtoupper($item->short_name === 'en'?'us':$item->short_name) . '":"' . trim($item->name) . '",';
                    return $languagesStr;
                });
                $view->with('languagesStr', flagLanguage($languagesStr));
            });

            view()->composer([
               'themes.lightorange.partials.topbar',
            ], function ($view) {

                $topbarsection = ContentDetails::with('content')
                    ->whereHas('content', function ($query)  {
                        $query->where('name', 'lightorange_topbar_section');
                    })
                    ->get();
                $singleContent = $topbarsection->where('content.name', 'lightorange_topbar_section')->where('content.type', 'single')->first() ?? [];
                $data = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                ];

                $view->with('topbarsection', $data);
            });



            view()->composer('themes.lightyellow.sections.investment_section', function ($view) {
                $view->with('gateways', Gateway::where('status', 1)->orderBy('sort_by')->get());
            });

            view()->composer([

                'themes.deepblue.partials.topbar',
                'themes.deepblue.partials.topbar-auth',
                'themes.light_orange.partials.topbar-auth',
                'themes.light_orange.partials.topbar',

            ], function ($view) {
                $content_name = getTheme().'_'.'footer';
                $footer_section = ContentDetails::with('content')
                    ->whereHas('content', function ($query) use ($content_name) {
                        $query->where('name', $content_name);
                    })
                    ->get();
                $singleContent = $footer_section->where('content.name', $content_name)->where('content.type', 'single')->first() ?? [];
                $multipleContents = $footer_section->where('content.name', $content_name)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                    return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
                });
                $data = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' => $multipleContents,
                ];

                $view->with('footer', $data);
            });


            if (basicControl()->force_ssl == 1) {
                if ($this->app->environment('production') || $this->app->environment('local')) {
                    \URL::forceScheme('https');
                }
            }

            Mail::extend('sendinblue', function () {
                return (new SendinblueTransportFactory)->create(
                    new Dsn(
                        'sendinblue+api',
                        'default',
                        config('services.sendinblue.key')
                    )
                );
            });

            Mail::extend('sendgrid', function () {
                return (new SendgridTransportFactory)->create(
                    new Dsn(
                        'sendgrid+api',
                        'default',
                        config('services.sendgrid.key')
                    )
                );
            });

            Mail::extend('mandrill', function () {
                return (new MandrillTransportFactory)->create(
                    new Dsn(
                        'mandrill+api',
                        'default',
                        config('services.mandrill.key')
                    )
                );
            });

        } catch (\Exception $e) {
            \Cache::forget('ConfigureSetting');

        }

    }
}
