<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FbrSetting;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    // Show all shops with their FBR settings for the logged-in user
    public function general($shopId = null)
    {
        $shops = Auth::user()->shops()->with('fbrSetting')->get();

        if (!$shopId) {
            // No shop selected, redirect back to manage shops page
            return redirect()->route('shops.cards');
        }

        $selectedShop = $shops->firstWhere('id', $shopId);

        if (!$selectedShop) {
            abort(404, 'Shop not found');
        }

        $settings = $selectedShop->fbrSetting ?? new FbrSetting(['shop_id' => $selectedShop->id]);

        return view('settings.general', compact('shops', 'selectedShop', 'settings'));
    }



    // Update FBR settings for a specific shop
    public function updateGeneral(Request $request, $shopId)
    {
        // Validate inputs
        $request->validate([
            'pos_id' => 'required|string',
            'integration_key' => 'required|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'enabled' => 'nullable|boolean',
        ]);

        // Make sure the authenticated user owns this shop
        $shop = Auth::user()->shops()->findOrFail($shopId);

        // Update or create the FBR settings for this shop
        FbrSetting::updateOrCreate(
            ['shop_id' => $shop->id],
            [
                'pos_id' => $request->pos_id,
                'integration_key' => $request->integration_key,
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'enabled' => $request->has('enabled'),
            ]
        );

        return redirect()->route('shops.cards')->with('success', 'FBR settings updated for shop: ' . $shop->name);
    }
}
