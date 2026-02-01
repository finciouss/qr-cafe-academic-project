@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24 max-w-4xl">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('order.confirmation') }}" class="text-orange-500 hover:text-orange-600">← Pembayaran</a>
    </div>

    <h1 class="text-4xl font-bold mb-8">Detail Pembayaran</h1>

    <!-- Payment Method Selection -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">Pilih Metode Pembayaran</h2>
        
        <div id="paymentForm">
            @csrf
            
            <!-- QR Code (Midtrans) -->
            <label class="block bg-white border-2 rounded-lg p-5 mb-4 cursor-pointer hover:border-orange-500 transition payment-option" data-value="digital_wallet">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="radio" 
                               name="payment_method" 
                               value="digital_wallet"
                               class="w-5 h-5 text-orange-500 focus:ring-orange-500 payment-radio">
                        <span class="ml-3 font-semibold">QR Code (Midtrans / QRIS)</span>
                    </div>
                    <div class="payment-indicator w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full hidden indicator-dot"></div>
                    </div>
                </div>
            </label>

            <!-- Bayar di Kasir -->
            <label class="block bg-white border-2 rounded-lg p-5 mb-6 cursor-pointer hover:border-orange-500 transition payment-option" data-value="cash">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="radio" 
                               name="payment_method" 
                               value="cash"
                               checked
                               class="w-5 h-5 text-orange-500 focus:ring-orange-500 payment-radio">
                        <span class="ml-3 font-semibold">Bayar di Kasir</span>
                    </div>
                    <div class="payment-indicator w-5 h-5 border-2 border-orange-500 rounded-full flex items-center justify-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full indicator-dot"></div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <!-- Rincian Pembayaran -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
        <h2 class="text-xl font-bold mb-4">Rincian Pembayaran</h2>
        
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total</span>
                <span class="font-bold text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Confirm Button -->
    <button onclick="confirmPayment()" 
            id="pay-button"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-4 rounded-lg transition">
        Konfirmasi Pembayaran
    </button>
</div>

<!-- Success Modal (Pop-up) -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center">
        <!-- Success Icon -->
        <div class="mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-2">Pesanan Berhasil!</h2>
        <p class="text-gray-600 mb-2">Nomor Pesanan</p>
        <p id="orderNumber" class="text-2xl font-bold text-orange-600 mb-6">#20260116001</p>
        
        <p class="text-gray-600 mb-8">Pesanan Anda sedang diproses. Silakan menunggu pesanan Anda siap.</p>

        <div class="flex gap-3">
            <a href="{{ route('menu') }}" 
               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg transition">
                Pesan Lagi
            </a>
            <a href="{{ route('home') }}" 
               class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                Kembali ke Home
            </a>
        </div>
    </div>
</div>

@php
    $midtransClientKey = config('midtrans.client_key');
@endphp

<!-- Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransClientKey }}"></script>

<script>
// Update visual indicator when payment method is selected
document.querySelectorAll('.payment-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        // Reset all indicators
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('border-orange-500');
            option.querySelector('.payment-indicator').classList.remove('border-orange-500');
            option.querySelector('.payment-indicator').classList.add('border-gray-300');
            option.querySelector('.indicator-dot').classList.add('hidden');
        });
        
        // Set selected indicator
        const selectedOption = this.closest('.payment-option');
        selectedOption.classList.add('border-orange-500');
        const indicator = selectedOption.querySelector('.payment-indicator');
        indicator.classList.remove('border-gray-300');
        indicator.classList.add('border-orange-500');
        indicator.querySelector('.indicator-dot').classList.remove('hidden');
    });
});

function confirmPayment() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (!paymentMethod) {
        alert('Silakan pilih metode pembayaran');
        return;
    }

    const payButton = document.getElementById('pay-button');
    payButton.disabled = true;
    payButton.innerHTML = 'Memproses...';

    // Create FormData
    const formData = new FormData();
    formData.append('payment_method', paymentMethod.value);

    // 1. Create Order First
    fetch('{{ route("process.payment") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const orderId = data.order_id; // Database ID
            const orderNumber = data.order_number;

            // If method is digital_wallet, call Snap
            if (paymentMethod.value === 'digital_wallet') {
                getSnapToken(orderId, orderNumber);
            } else {
                // Cash -> Show Success Modal directly
                showSuccessModal(orderNumber);
            }
        } else {
            alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
            resetButton();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        resetButton();
    });
}

function getSnapToken(orderId, orderNumber) {
    fetch('{{ route("payment.snap-token") }}?order_id=' + orderId)
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            // Trigger Snap Popup
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Payment success -> show success modal
                    showSuccessModal(orderNumber);
                },
                onPending: function(result) {
                    // Waiting for payment -> show success modal or redirect
                    showSuccessModal(orderNumber);
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    resetButton();
                },
                onClose: function() {
                    alert('Anda menutup popup pembayaran tanpa menyelesaikan pembayaran');
                    resetButton();
                }
            });
        } else {
            alert('Gagal mendapatkan token pembayaran');
            resetButton();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal memproses pembayaran');
        resetButton();
    });
}

function showSuccessModal(orderNumber) {
    document.getElementById('orderNumber').textContent = '#' + orderNumber;
    const modal = document.getElementById('successModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    resetButton();
}

function resetButton() {
    const payButton = document.getElementById('pay-button');
    payButton.disabled = false;
    payButton.innerHTML = 'Konfirmasi Pembayaran';
}

// Close modal when clicking outside
document.getElementById('successModal').addEventListener('click', function(e) {
    if(e.target === this) {
        this.classList.add('hidden');
        this.classList.remove('flex');
    }
});

// Set default selection visual
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
