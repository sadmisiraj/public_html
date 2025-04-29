<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreviewController extends Controller
{
    public function preview(Request $request)
    {
        $route = route('page');
        if (\request()->has('route')){
            $route = \request()->route;
        }
       return redirect()->to($route);
    }
}
