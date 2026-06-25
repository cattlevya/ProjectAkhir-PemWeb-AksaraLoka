<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlist items.
     */
    public function index()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isPenjual()) {
            return redirect()->route('home')->with('error', 'Hanya pembeli yang memiliki wishlist.');
        }
        $wishlists = Wishlist::with('product.store')->where('user_id', Auth::id())->latest()->get();
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Toggle a product in the wishlist (add if not exists, remove if exists).
     */
    public function toggle(Request $request, Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('warning', 'Silakan login untuk menyimpan produk ke wishlist.');
        }
        if ($user->isAdmin() || $user->isPenjual()) {
            return redirect()->route('home')->with('error', 'Hanya pembeli yang dapat menambah wishlist.');
        }

        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Produk dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $message = 'Produk ditambahkan ke wishlist.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return redirect()->route('wishlist.index')->with('error', 'Anda tidak memiliki akses ke wishlist ini.');
        }

        $wishlist->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist.');
    }
}
