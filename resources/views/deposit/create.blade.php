<!-- resources/views/deposit/create.blade.php -->
@extends('layouts.app')

@section('title', 'Deposit Baru')
@section('page-title', 'Deposit Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Tier Information -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card tier-card tier-1">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">TIER-1</h5>
                        <p class="card-text">
                            <strong>Min: Rp 5.000.000</strong><br>
                            <span class="text-success">Cashback 5%</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card tier-card tier-2">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning">TIER-2</h5>
                        <p class="card-text">
                            <strong>Min: Rp 10.000.000</strong><br>
                            <span class="text-warning">Cashback 12%</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card tier-card tier-3">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">TIER-3</h5>
                        <p class="card-text">
                            <strong>Min: Rp 15.000.000</strong><br>
                            <span class="text-danger">Cashback 20%</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Deposit</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('deposit.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah Deposit</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="5000000" step="1000" required>
                        </div>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum deposit Rp 5.000.000</div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="M2" {{ old('payment_method') == 'M2' ? 'selected' : '' }}>Bank Mandiri</option>
                            <option value="I1" {{ old('payment_method') == 'I1' ? 'selected' : '' }}>BNI</option>
                            <option value="B1" {{ old('payment_method') == 'B1' ? 'selected' : '' }}>BCA</option>
                            <option value="A1" {{ old('payment_method') == 'A1' ? 'selected' : '' }}>ATM Bersama</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Ringkasan Deposit:</h6>
                                <div id="deposit-summary">
                                    <p class="mb-1"><strong>Jumlah Deposit:</strong> <span id="deposit-amount">Rp 0</span></p>
                                    <p class="mb-1"><strong>Tier:</strong> <span id="deposit-tier">-</span></p>
                                    <p class="mb-1"><strong>Cashback:</strong> <span id="deposit-cashback">0% (Rp 0)</span></p>
                                    <p class="mb-0"><strong>Total Diterima:</strong> <span id="deposit-total">Rp 0</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-credit-card me-2"></i>Proses Deposit
                    </button>
                    <a href="{{ route('deposit.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('amount').addEventListener('input', function() {
    const amount = parseInt(this.value) || 0;
    const tiers = {
        'TIER-1': { minimum: 5000000, cashback: 5 },
        'TIER-2': { minimum: 10000000, cashback: 12 },
        'TIER-3': { minimum: 15000000, cashback: 20 }
    };
    
    let selectedTier = null;
    
    if (amount >= 15000000) {
        selectedTier = 'TIER-3';
    } else if (amount >= 10000000) {
        selectedTier = 'TIER-2';
    } else if (amount >= 5000000) {
        selectedTier = 'TIER-1';
    }
    
    if (selectedTier) {
        const cashbackPercentage = tiers[selectedTier].cashback;
        const cashbackAmount = (amount * cashbackPercentage) / 100;
        const totalReceived = amount + cashbackAmount;
        
        document.getElementById('deposit-amount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
        document.getElementById('deposit-tier').textContent = selectedTier;
        document.getElementById('deposit-cashback').textContent = cashbackPercentage + '% (Rp ' + cashbackAmount.toLocaleString('id-ID') + ')';
        document.getElementById('deposit-total').textContent = 'Rp ' + totalReceived.toLocaleString('id-ID');
    } else {
        document.getElementById('deposit-amount').textContent = 'Rp 0';
        document.getElementById('deposit-tier').textContent = '-';
        document.getElementById('deposit-cashback').textContent = '0% (Rp 0)';
        document.getElementById('deposit-total').textContent = 'Rp 0';
    }
});
</script>
@endsection
