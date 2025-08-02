<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\Shop;
use App\Models\FbrSetting;
use Illuminate\Http\Request;

class FbrSettingController extends Controller
{
    public function edit(Shop $shop)
    {
        $fbrSetting = $shop->fbrSetting;

        return view('shops.fbr.edit', compact('shop', 'fbrSetting'));
    }

    public function storeOrUpdate(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'pos_id' => 'required|string',
            'integration_key' => 'required|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'enabled' => 'boolean',
        ]);

        $shop->fbrSetting()->updateOrCreate(
            ['shop_id' => $shop->id],
            $validated
        );

        return redirect()->route('shops.cards')->with('success', 'FBR settings updated.');
    }
}
