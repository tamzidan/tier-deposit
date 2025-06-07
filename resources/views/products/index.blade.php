<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Daftar Produk')

@section('content')
<div class="mb-4">
    <div class="alert alert-info">
        <i class="fas fa-wallet me-2"></i>
        <strong>Saldo Anda:</strong> Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
    </div>
</div>

@if($products->count() > 0)
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                            <span class="badge bg-secondary">Stok: {{ $product->stock }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="input-group mb-2">
                                <input type="number" class="form-control" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <span class="input-group-text">qty</span>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" 
                                    {{ $product->stock == 0 || !auth()->user()->hasBalance($product->price) ? 'disabled' : '' }}>
                                @if($product->stock == 0)
                                    <i class="fas fa-times me-2"></i>Stok Habis
                                @elseif(!auth()->user()->hasBalance($product->price))
                                    <i class="fas fa-wallet me-2"></i>Saldo Tidak Cukup
                                @else
                                    <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4 me-4">
        {{ $products->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
        <h5>Belum ada produk</h5>
        <p class="text-muted">Produk akan segera tersedia</p>
    </div>
@endif
@endsection
