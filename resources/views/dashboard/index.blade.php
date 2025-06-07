<!-- resources/views/dashboard/index.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Balance Card -->
    <div class="col-md-4 mb-4">
        <div class="card balance-card">
            <div class="card-body text-center">
                <h5 class="card-title">
                    <i class="fas fa-wallet me-2"></i>
                    Saldo Anda
                </h5>
                <h2 class="mb-0">Rp {{ number_format($balance, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-credit-card fa-2x text-success mb-2"></i>
                <h5>Total Deposit</h5>
                <h4 class="text-success">Rp {{ number_format($total_deposits, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                <h5>Total Pesanan</h5>
                <h4 class="text-primary">{{ $total_orders }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Deposits -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Deposit Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recent_deposits->count() > 0)
                    @foreach($recent_deposits as $deposit)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-bold">{{ $deposit->invoice_id }}</div>
                            <small class="text-muted">{{ $deposit->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">Rp {{ number_format($deposit->amount, 0, ',', '.') }}</div>
                            <span class="badge bg-{{ $deposit->status == 'paid' ? 'success' : ($deposit->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($deposit->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center">Belum ada deposit</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recent_orders->count() > 0)
                    @foreach($recent_orders as $order)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-bold">{{ $order->order_number }}</div>
                            <small>{{ $order->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center">Belum ada pesanan</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
