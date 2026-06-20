<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $products = Product::query()->orderBy('name')->get();
            $allOrders = Order::query()
                ->with(['user', 'items.product'])
                ->latest()
                ->get();

            return view('dashboard', compact('products', 'allOrders'));
        }

        $products = Product::query()->orderBy('name')->get();
        $orders = $user->orders()->with('items.product')->latest()->get();

        return view('dashboard', compact('products', 'orders'));
    }
}
