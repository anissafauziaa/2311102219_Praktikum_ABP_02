<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        abort_if(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'quantities' => ['required', 'array'],
            'quantities.*' => ['integer', 'min:0'],
        ]);

        $quantities = collect($data['quantities'] ?? [])
            ->map(fn ($q) => (int) $q)
            ->filter(fn (int $q) => $q > 0);

        if ($quantities->isEmpty()) {
            return back()
                ->withErrors(['order' => 'Pilih minimal satu produk dengan jumlah lebih dari 0.'])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($quantities) {
                $productIds = $quantities->keys()->map(fn ($id) => (int) $id)->all();
                $products = Product::query()
                    ->whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($quantities as $productId => $qty) {
                    $productId = (int) $productId;
                    $product = $products->get($productId);
                    if (! $product || $qty > $product->stock) {
                        throw ValidationException::withMessages([
                            'order' => 'Stok tidak mencukupi atau produk tidak tersedia.',
                        ]);
                    }
                }

                $order = Order::query()->create([
                    'user_id' => auth()->id(),
                    'status' => Order::STATUS_PENDING,
                    'total_price' => 0,
                ]);

                $total = 0;
                foreach ($quantities as $productId => $qty) {
                    $productId = (int) $productId;
                    $product = $products->get($productId);
                    $lineTotal = $qty * $product->price;
                    $total += $lineTotal;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                    ]);

                    $product->decrement('stock', $qty);
                }

                $order->update(['total_price' => $total]);
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('dashboard')->with('status', 'Pesanan berhasil dibuat.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_if(auth()->user()->isAdmin(), 403);
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->status !== Order::STATUS_PENDING) {
            return back()->withErrors(['order' => 'Hanya pesanan berstatus menunggu yang dapat dibatalkan.']);
        }

        DB::transaction(function () use ($order) {
            $order->load('items.product');
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            $order->update(['status' => Order::STATUS_CANCELLED]);
        });

        return redirect()->route('dashboard')->with('status', 'Pesanan dibatalkan dan stok dikembalikan.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Order::STATUSES)],
        ]);

        $old = $order->status;
        $new = $validated['status'];

        if ($new === $old) {
            return back();
        }

        if ($old === Order::STATUS_CANCELLED) {
            return back()->withErrors(['status' => 'Tidak dapat mengubah status pesanan yang sudah dibatalkan.']);
        }

        DB::transaction(function () use ($order, $old, $new) {
            if ($old !== Order::STATUS_CANCELLED && $new === Order::STATUS_CANCELLED) {
                $order->load('items.product');
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => $new]);
        });

        return redirect()->route('dashboard')->with('status', 'Status pesanan diperbarui.');
    }
}
