<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index()
    {
        $pageTitle = 'Configs';
        $configs = Config::all();
        return view('admin.config.index', compact('pageTitle', 'configs'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'config_1' => 'required|string|max:10',
            'config_2' => 'required|string|max:10',
            'config_3' => 'required|string|max:10',
            'config_1_name' => 'required|string|max:255',
            'config_2_name' => 'required|string|max:255',
            'config_3_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get all configs to update them by ID, not by name
        $configs = Config::all();
        
        // Make sure we have 3 configs
        if ($configs->count() >= 3) {
            // Update config 1
            $configs[0]->display_name = $request->config_1_name;
            $configs[0]->value = $request->config_1;
            $configs[0]->save();
            
            // Update config 2
            $configs[1]->display_name = $request->config_2_name;
            $configs[1]->value = $request->config_2;
            $configs[1]->save();
            
            // Update config 3
            $configs[2]->display_name = $request->config_3_name;
            $configs[2]->value = $request->config_3;
            $configs[2]->save();
            
            return back()->with('success', 'Configs updated successfully');
        }
        
        return back()->with('error', 'Config update failed - not enough config records');
    }
} 