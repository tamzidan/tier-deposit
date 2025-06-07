<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Services\DuitkuService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    private $duitkuService;

    public function __construct(DuitkuService $duitkuService)
    {
        $this->duitkuService = $duitkuService;
    }

    public function index()
    {
        $deposits = auth()->user()->deposits()->latest()->paginate(10);
        return view('deposit.index', compact('deposits'));
    }

    public function create()
    {
        $tiers = [
            'TIER-1' => ['minimum' => 5000000, 'cashback' => 5],
            'TIER-2' => ['minimum' => 10000000, 'cashback' => 12],
            'TIER-3' => ['minimum' => 15000000, 'cashback' => 20],
        ];
        
        return view('deposit.create', compact('tiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5000000',
            'payment_method' => 'required|string'
        ]);

        $amount = $request->amount;
        $tierInfo = Deposit::getTierInfo($amount);

        if (!$tierInfo) {
            return back()->with('error', 'Minimum deposit adalah Rp 5.000.000');
        }

        $invoiceId = 'DEP-' . date('YmdHis') . '-' . Str::random(6);
        
        $deposit = new Deposit([
            'user_id' => auth()->id(),
            'invoice_id' => $invoiceId,
            'amount' => $amount,
            'tier' => $tierInfo['tier'],
            'cashback_percentage' => $tierInfo['cashback_percentage'],
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'expired_at' => now()->addHour()
        ]);

        $deposit->calculateCashback();
        $deposit->save();

        $paymentData = [
            'invoice_id' => $invoiceId,
            'amount' => $amount,
            'payment_method' => $request->payment_method,
            'product_details' => 'Deposit Saldo - ' . $tierInfo['tier'],
            'customer_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];

        $paymentResponse = $this->duitkuService->createInvoice($paymentData);

        if ($paymentResponse['statusCode'] == '00') {
            $deposit->update([
                'duitku_reference' => $paymentResponse['reference'],
                'payment_response' => $paymentResponse
            ]);

            return redirect($paymentResponse['paymentUrl']);
        } else {
            $deposit->update(['status' => 'failed']);
            return back()->with('error', 'Gagal membuat pembayaran: ' . $paymentResponse['statusMessage']);
        }
    }

    public function callback(Request $request)
    {
        // Log callback untuk debugging
        Log::info('Duitku Callback received:', $request->all());

        // Cek validasi signature
        if (!$this->duitkuService->validateCallback($request)) {
            Log::error('Invalid signature in callback');
            return response('Invalid signature', 400);
        }

        $merchantOrderId = $request->input('merchantOrderId');
        $deposit = Deposit::where('invoice_id', $merchantOrderId)->first();

        if (!$deposit) {
            Log::error('Deposit not found for invoice: ' . $merchantOrderId);
            return response('Deposit not found', 404);
        }

        Log::info('Processing deposit callback for invoice: ' . $merchantOrderId);

        if ($request->input('resultCode') == '00') {
            $deposit->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);

            // Add balance to user
            $deposit->user->addBalance($deposit->total_received);
            
            Log::info('Deposit successful for invoice: ' . $merchantOrderId . ', Amount: ' . $deposit->total_received);
            return response('OK', 200);
        } else {
            $deposit->update(['status' => 'failed']);
            Log::info('Deposit failed for invoice: ' . $merchantOrderId);
            return response('Payment failed', 200);
        }
    }

    public function return(Request $request)
    {
        $merchantOrderId = $request->input('merchantOrderId');
        $deposit = Deposit::where('invoice_id', $merchantOrderId)->first();

        if ($deposit) {
            // Jika status masih pending, cek status dari Duitku
            if ($deposit->status === 'pending') {
                $status = $this->duitkuService->checkTransaction($merchantOrderId);
                
                Log::info('Checking transaction status for: ' . $merchantOrderId, ['status' => $status]);
                
                if ($status['statusCode'] == '00') {
                    // Update status jika pembayaran berhasil
                    $deposit->update([
                        'status' => 'paid',
                        'paid_at' => now()
                    ]);
                    
                    // Add balance to user
                    $deposit->user->addBalance($deposit->total_received);
                    
                    return redirect()->route('deposit.index')->with('success', 'Deposit berhasil! Saldo Anda telah ditambahkan.');
                }
            } else if ($deposit->status === 'paid') {
                return redirect()->route('deposit.index')->with('success', 'Deposit berhasil! Saldo Anda telah ditambahkan.');
            }
        }

        return redirect()->route('deposit.index')->with('info', 'Pembayaran sedang diproses.');
    }

    // Method untuk manual check status (opsional, untuk debugging)
    public function checkStatus($invoiceId)
    {
        $deposit = Deposit::where('invoice_id', $invoiceId)->first();
        
        if (!$deposit) {
            return response()->json(['error' => 'Deposit not found'], 404);
        }

        $status = $this->duitkuService->checkTransaction($invoiceId);
        
        return response()->json([
            'deposit' => $deposit,
            'duitku_status' => $status
        ]);
    }
}