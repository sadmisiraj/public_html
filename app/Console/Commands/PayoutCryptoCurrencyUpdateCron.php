<?php

namespace App\Console\Commands;

use App\Models\PayoutMethod;
use Illuminate\Console\Command;
use Facades\App\Services\BasicCurl;

class PayoutCryptoCurrencyUpdateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout-crypto-currency-update-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to payout crypto currency conversion rate update.';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $endpoint = 'live';
        $currency_layer_access_key = basicControl()->currency_layer_access_key;

        $currency_layer_url = "http://api.currencylayer.com";
        $baseCurrency = basicControl()->base_currency;

        $source = 'USD';

        $payoutCurrencies = PayoutMethod::where('is_automatic', 1)->where('code', '!=', 'coinbase')->where('is_auto_update', 1)->pluck('supported_currency')->toArray();
        $currencyLists = array();
        foreach ($payoutCurrencies as $currency) {
            foreach ($currency as $singleCurrency) {
                $currencyLists[] = $singleCurrency;
            }
        }
        $currencyLists = array_unique($currencyLists);
        $currencies = implode(',', $currencyLists);

        $updateForMethods = PayoutMethod::where('code', '!=', 'coinbase')->where('is_automatic', 1)->where('is_auto_update', 1)->get();

        $baseCurrencyAPIUrl = "$currency_layer_url/$endpoint?access_key=$currency_layer_access_key&source=$source&currencies=$baseCurrency";
        $allCurrencyAPIUrl = "$currency_layer_url/$endpoint?access_key=$currency_layer_access_key&source=$source&currencies=$currencies";

        $baseCurrencyConvert = BasicCurl::curlGetRequest($baseCurrencyAPIUrl);
        $allCurrencyConvert = BasicCurl::curlGetRequest($allCurrencyAPIUrl);

        $baseCurrencyConvert = json_decode($baseCurrencyConvert);
        $allCurrencyConvert = json_decode($allCurrencyConvert);


        if ($baseCurrencyConvert->success && $allCurrencyConvert->success) {

            if (empty($baseCurrencyConvert->quotes)) {
                $usdToBase = 1.00;
            } else {
                $usdToBase = (array)$baseCurrencyConvert->quotes;
                $usdToBase = $usdToBase["$source$baseCurrency"];
            }

            foreach ($updateForMethods as $method) {
                $addField = [];
                foreach ($allCurrencyConvert->quotes as $key => $rate) {
                    $curCode = substr($key, -3);
                    $curRate = round($rate / $usdToBase, 2);

                    foreach ($method->supported_currency as $key => $currency) {
                        if ($key == 'USD') {
                            $addField['USD'] = round(1 / $usdToBase, 2);
                        }
                        if ($curCode == $key) {
                            $addField[$key] = $curRate;
                            break;
                        }
                    }
                }
                $method->convert_rate = $addField;
                $method->save();
            }
        }

        return 0;


    }



}
