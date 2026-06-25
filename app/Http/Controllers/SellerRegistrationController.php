<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Services\StoreService;

class SellerRegistrationController extends Controller
{
    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mendaftar sebagai penjual.');
        }
        if (auth()->user()->isPenjual()) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai penjual.');
        }

        return view('seller.register');
    }

    public function store(StoreStoreRequest $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin() || $user->isPenjual() || $user->hasStore()) {
            return redirect()->route('home')->with('error', 'Aksi tidak diizinkan.');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('store-logos', 'public');
        }

        $this->storeService->createStore($request->user(), $data);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Selamat! Toko Anda berhasil didaftarkan.');
    }
}
