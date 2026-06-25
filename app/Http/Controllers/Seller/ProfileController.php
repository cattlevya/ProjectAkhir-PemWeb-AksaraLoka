<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateStore(Request $request)
    {
        $user = $request->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['store_name', 'description', 'address']);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $path = $request->file('logo')->store('stores', 'public');
            $data['logo'] = $path;
        }

        $store->update($data);

        return back()->with('status', 'store-updated');
    }
}
