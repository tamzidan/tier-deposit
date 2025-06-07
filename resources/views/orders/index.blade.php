<!-- resources/views/orders/index.blade.php -->
@extends('layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Riwayat Pesanan')

@section('content')
<div class="mb-4">
    <div class="alert alert-info">
        <i class="fas fa-wallet me-2"></i>
        <strong>Saldo Anda:</strong> Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-3 text-end">
                            <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="row align-items-center mb-2">
                        <div class="col-md-6">
                            <strong>{{ $item->product->name }}</strong>
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $item->quantity }}x
                        </div>
                        <div class="col-md-2 text-center">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                        <div class="col-md-2 text-end">
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            
            {{ $orders->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                <h5>Belum ada pesanan</h5>
                <p class="text-muted">Mulai berbelanja untuk melihat riwayat pesanan</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Produk</a>
            </div>
        @endif
    </div>
</div>
@endsection
