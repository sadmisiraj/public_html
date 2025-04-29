<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    public function index()
    {
        return view('admin.theme.index');
    }

    public function selectTheme($val)
    {
        if (!in_array($val, config('basic.themes'))) {
            $val = 'lightagro';
        }
        DB::beginTransaction();
        try {
            $default = collect(config('theme')[$val]['home_version'])->keys();
            $basicControl = BasicControl::firstOrFail();
            $basicControl->theme = $val;
            $basicControl->home_style = $default->first();
            $basicControl->update();

            $pagesByTheme = Page::select('id', 'slug', 'uniq_page_name', 'template_name', 'status')
                ->whereIn('uniq_page_name', $default)
                ->where('template_name', $val)
                ->get();

            foreach ($pagesByTheme as $item) {
                if ($basicControl->home_style == $item->uniq_page_name) {
                    $item->slug = '/';
                } else {
                    $item->slug = $item->uniq_page_name;
                }
                $item->save();
            }
            DB::commit();
            Artisan::call('cache:clear');
            session()->forget('theme');
            return response()->json('success');
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }


    public function homeStyle()
    {
        return view('admin.theme.home_style');
    }

    public function selectHome($home_style)
    {
        try {
            $home_styles = collect(config('theme')[getTheme()]['home_version'])->keys(); // Collection of keys

            $pagesByTheme = Page::select('id', 'slug', 'uniq_page_name', 'template_name', 'status')
                ->whereIn('uniq_page_name', $home_styles)
                ->where('template_name', getTheme())
                ->get();

            if (!in_array($home_style, $home_styles->toArray())) {
                return response()->json(['message' => 'This style is not found']);
            }

            foreach ($pagesByTheme as $item) {
                if ($home_style == $item->uniq_page_name) {
                    $item->slug = '/';
                } else {
                    $item->slug = $item->uniq_page_name;
                }
                $item->save();
            }
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }
}
