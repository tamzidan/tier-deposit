<!-- resources/views/deposit/index.blade.php -->
@extends('layouts.app')

@section('title', 'Deposit')
@section('page-title', 'Riwayat Deposit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Saldo Saat Ini: <span class="text-primary">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span></h4>
    </div>
    <a href="{{ route('deposit.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Deposit Baru
    </a>
</div>

<div style="background-color: white" class="">
    <div class="card-body">
        @if($deposits->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Jumlah</th>
                            <th>Tier</th>
                            <th>Cashback</th>
                            <th>Total Diterima</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deposits as $deposit)
                        <tr>
                            <td>{{ $deposit->invoice_id }}</td>
                            <td>Rp {{ number_format($deposit->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $deposit->tier == 'TIER-1' ? 'success' : ($deposit->tier == 'TIER-2' ? 'warning' : 'danger') }}">
                                    {{ $deposit->tier }}
                                </span>
                            </td>
                            <td>{{ $deposit->cashback_percentage }}% (Rp {{ number_format($deposit->cashback_amount, 0, ',', '.') }})</td>
                            <td>Rp {{ number_format($deposit->total_received, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $deposit->status == 'paid' ? 'success' : ($deposit->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($deposit->status) }}
                                </span>
                            </td>
                            <td>{{ $deposit->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $deposits->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                <h5>Belum ada deposit</h5>
                <p class="text-muted">Mulai deposit untuk menambah saldo Anda</p>
                <a href="{{ route('deposit.create') }}" class="btn btn-primary">Deposit Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection
