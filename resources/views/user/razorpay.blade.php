<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Sora', sans-serif; }
        body { background: linear-gradient(135deg, #0f0f0f 0%, #1a1a2e 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; }

        .pay-card {
            background:#fff; border-radius:24px;
            max-width:440px; width:100%; margin:1rem;
            box-shadow: 0 25px 60px rgba(0,0,0,.4);
            overflow:hidden;
        }
        .pay-header {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            padding:2rem; text-align:center; color:#fff;
        }
        .pay-header .lock-icon {
            width:56px; height:56px; background:rgba(255,255,255,.1);
            border-radius:16px; display:flex; align-items:center; justify-content:center;
            font-size:1.6rem; margin:0 auto .75rem; backdrop-filter:blur(10px);
        }
        .pay-header h5 { font-weight:700; margin:0; font-size:1.1rem; }
        .pay-header .order-num { color:rgba(255,255,255,.5); font-size:.8rem; margin-top:.25rem; }

        .pay-body { padding:1.75rem; }

        .amount-box {
            background:#f8f8f8; border-radius:16px;
            padding:1.25rem 1.5rem; margin-bottom:1.5rem;
            display:flex; align-items:center; justify-content:space-between;
        }
        .amount-label { font-size:.8rem; color:#888; font-weight:600; }
        .amount-value { font-size:1.6rem; font-weight:800; color:#111; }

        .info-row {
            display:flex; align-items:center; gap:.75rem;
            padding:.6rem; border-radius:10px; background:#f8f8f8;
            margin-bottom:.6rem; font-size:.82rem;
        }
        .info-row .info-icon { width:32px; height:32px; border-radius:8px; background:#ede9fe; display:flex; align-items:center; justify-content:center; font-size:.9rem; flex-shrink:0; }
        .info-row .info-label { color:#888; font-size:.74rem; }
        .info-row .info-val   { font-weight:600; color:#111; }

        .pay-btn {
            width:100%; padding:1.1rem; border:none; border-radius:14px;
            background:linear-gradient(135deg,#1a1a1a,#333);
            color:#fff; font-size:1rem; font-weight:700;
            cursor:pointer; margin-top:1.25rem; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
        }
        .pay-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.25); }
        .pay-btn:active { transform:translateY(0); }
        .pay-btn:disabled { background:#aaa; transform:none; box-shadow:none; cursor:not-allowed; }

        .trust-badges { display:flex; justify-content:center; gap:1rem; margin-top:1rem; }
        .trust-badge {
            display:flex; align-items:center; gap:.3rem;
            font-size:.72rem; color:#aaa; font-weight:500;
        }

        .rzp-logo {
            display:flex; align-items:center; justify-content:center; gap:.4rem;
            color:#aaa; font-size:.74rem; margin-top:1.25rem; padding-top:1rem;
            border-top:1px solid #f0f0f0;
        }

        /* Spinner overlay */
        #loadingOverlay {
            display:none; position:fixed; inset:0;
            background:rgba(0,0,0,.6); z-index:9999;
            align-items:center; justify-content:center; flex-direction:column; gap:1rem;
        }
        #loadingOverlay.show { display:flex; }
        .spinner { width:42px; height:42px; border:4px solid rgba(255,255,255,.2); border-top-color:#fff; border-radius:50%; animation:spin .8s linear infinite; }
        @keyframes spin { to { transform:rotate(360deg); } }
        #loadingOverlay p { color:#fff; font-size:.9rem; font-weight:600; font-family:'Sora',sans-serif; }
    </style>
</head>
<body>

<div id="loadingOverlay">
    <div class="spinner"></div>
    <p>Processing your payment…</p>
</div>

<div class="pay-card">
    <div class="pay-header">
        <div class="lock-icon">🔐</div>
        <h5>Complete Your Payment</h5>
        <div class="order-num">Order #{{ $order->order_number }}</div>
    </div>
    <div class="pay-body">

        <div class="amount-box">
            <div>
                <div class="amount-label">Amount to Pay</div>
                <div class="amount-value">₹{{ number_format($order->final_amount, 2) }}</div>
            </div>
            <div style="font-size:2rem">💳</div>
        </div>

        <div class="info-row">
            <div class="info-icon">👤</div>
            <div>
                <div class="info-label">Customer</div>
                <div class="info-val">{{ $user->name }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-icon">📧</div>
            <div>
                <div class="info-label">Email</div>
                <div class="info-val">{{ $user->email }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-icon">📱</div>
            <div>
                <div class="info-label">Phone</div>
                <div class="info-val">{{ $order->phone }}</div>
            </div>
        </div>

        <button id="rzpBtn" class="pay-btn">
            Pay ₹{{ number_format($order->final_amount, 2) }} Securely →
        </button>

        <div class="trust-badges">
            <div class="trust-badge">🔒 SSL Secure</div>
            <div class="trust-badge">✅ 256-bit Encrypted</div>
            <div class="trust-badge">🛡️ PCI DSS Compliant</div>
        </div>

        <div class="rzp-logo">
            <img src="https://razorpay.com/favicon.ico" height="16" alt=""> Powered by Razorpay
        </div>
    </div>
</div>

{{-- Hidden form for POST back --}}
<form id="rzpForm" action="{{ route('checkout.razorpaySuccess') }}" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="razorpay_order_id"   id="rzp_order_id">
    <input type="hidden" name="razorpay_payment_id"  id="rzp_payment_id">
    <input type="hidden" name="razorpay_signature"   id="rzp_signature">
</form>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    key:         '{{ $rzp_key }}',
    amount:       {{ $amount }},
    currency:    'INR',
    name:        '{{ config("app.name") }}',
    description: 'Order #{{ $order->order_number }}',
    order_id:    '{{ $rzp_order }}',
    prefill: {
        name:    '{{ $user->name }}',
        email:   '{{ $user->email }}',
        contact: '{{ $user->phone }}',
    },
    theme: { color: '#1a1a1a' },
    handler: function(response) {
        document.getElementById('loadingOverlay').classList.add('show');
        document.getElementById('rzp_order_id').value   = response.razorpay_order_id;
        document.getElementById('rzp_payment_id').value = response.razorpay_payment_id;
        document.getElementById('rzp_signature').value  = response.razorpay_signature;
        document.getElementById('rzpForm').submit();
    },
    modal: {
        ondismiss: function() {
            document.getElementById('rzpBtn').disabled = false;
            document.getElementById('rzpBtn').textContent = 'Pay ₹{{ number_format($order->final_amount, 2) }} Securely →';
        }
    }
};

var rzp = new Razorpay(options);

document.getElementById('rzpBtn').addEventListener('click', function() {
    this.disabled = true;
    this.textContent = 'Opening payment…';
    rzp.open();
});

// Auto-open after short delay
setTimeout(() => { rzp.open(); }, 600);
</script>
</body>
</html>