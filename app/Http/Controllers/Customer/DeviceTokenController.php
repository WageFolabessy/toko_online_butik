<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $request->user()->deviceTokens()->updateOrCreate(
            ['token' => $request->token]
        );

        return response()->json(['message' => 'Token berhasil disimpan.']);
    }
}
