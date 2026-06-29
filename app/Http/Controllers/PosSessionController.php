<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PosSessionController extends Controller
{
    // Verify password to ENTER pos
    public function verify(Request $request)
    {
        $request->validate(['password' => 'required', 'shop_id' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }

        // Store POS session for this shop
        session(['pos_verified_shop' => $request->shop_id]);

        return response()->json(['success' => true, 'redirect' => route('shops.pos', $request->shop_id)]);
    }

    // Verify password to EXIT pos
    public function exit(Request $request)
    {
        $request->validate(['password' => 'required', 'redirect_to' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }

        session()->forget('pos_verified_shop');

        return response()->json(['success' => true, 'redirect' => $request->redirect_to]);
    }
}