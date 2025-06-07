<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        if (!$product->isInStock($quantity)) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $total = $product->price * $quantity;

        if (!auth()->user()->hasBalance($total)) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'total' => $total
            ]);

            // Deduct balance and stock
            auth()->user()->deductBalance($total);
            $product->decreaseStock($quantity);

            // Complete order
            $order->update(['status' => 'completed']);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }
}
