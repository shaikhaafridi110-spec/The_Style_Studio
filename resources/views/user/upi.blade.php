{{-- resources/views/checkout/upi.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay via UPI</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Sora', sans-serif; }
        body { background: #f4f4f0; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem; }

        .upi-card {
            background:#fff; border-radius:24px; max-width:420px; width:100%;
            box-shadow:0 4px 32px rgba(0,0,0,.1); overflow:hidden;
        }
        .upi-header {
            background:linear-gradient(135deg,#00b09b,#96c93d);
            padding:1.5rem; text-align:center; color:#fff;
        }
        .upi-header .badge-icon {
            width:56px; height:56px; background:rgba(255,255,255,.2);
            border-radius:16px; display:flex; align-items:center; justify-content:center;
            font-size:1.8rem; margin:0 auto .6rem; backdrop-filter:blur(8px);
        }
        .upi-header h5 { margin:0; font-weight:700; }
        .upi-header .sub { color:rgba(255,255,255,.8); font-size:.8rem; margin-top:.2rem; }

        .upi-body { padding:1.75rem; }

        .qr-wrap {
            text-align:center; margin-bottom:1.25rem;
        }
        .qr-frame {
            display:inline-block;
            padding:.75rem; background:#fff;
            border-radius:20px;
            box-shadow:0 4px 20px rgba(0,0,0,.1);
            border:3px solid #e8e8e8;
        }
        .qr-frame img { display:block; border-radius:12px; }

        .amount-pill {
            background:linear-gradient(135deg,#00b09b,#96c93d);
            color:#fff; border-radius:50px; display:inline-block;
            padding:.5rem 1.5rem; font-size:1.2rem; font-weight:800;
            margin:.75rem 0; box-shadow:0 4px 12px rgba(0,176,155,.3);
        }

        .app-icons { display:flex; justify-content:center; gap:.75rem; margin-bottom:1.25rem; }
        .app-icon {
            width:44px; height:44px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.4rem; background:#f8f8f8; border:1.5px solid #eee;
        }

        .warning-box {
            background:#fffbeb; border:1.5px solid #fde68a; border-radius:12px;
            padding:.75rem 1rem; margin-bottom:1.25rem;
            font-size:.8rem; color:#92400e; line-height:1.5;
        }

        .timer-wrap { text-align:center; margin-bottom:1rem; }
        .timer-badge {
            display:inline-flex; align-items:center; gap:.4rem;
            background:#fff3cd; color:#856404; border-radius:50px;
            padding:.35rem .9rem; font-size:.8rem; font-weight:600;
        }

        .paid-btn {
            width:100%; padding:1rem; border:none; border-radius:14px;
            background:linear-gradient(135deg,#00b09b,#96c93d);
            color:#fff; font-size:1rem; font-weight:700;
            cursor:pointer; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
        }
        .paid-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,176,155,.35); }

        .back-link { display:block; text-align:center; margin-top:.9rem; font-size:.8rem; color:#aaa; text-decoration:none; }
        .back-link:hover { color:#555; }

        /* Timer countdown */
        #countdownBar { height:4px; background:#e8e8e8; border-radius:4px; overflow:hidden; margin-bottom:1rem; }
        #countdownFill { height:100%; background:linear-gradient(90deg,#00b09b,#96c93d); border-radius:4px; transition:width 1s linear; }
    </style>
</head>
<body>

<div class="upi-card">
    <div class="upi-header">
        <div class="badge-icon">📱</div>
        <h5>Pay via UPI</h5>
        <div class="sub">Order #{{ $order->order_number }}</div>
    </div>

    <div class="upi-body">

        {{-- QR Code --}}
        <div class="qr-wrap">
            <div class="qr-frame">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data={{ urlencode($qrString) }}"
                    alt="UPI QR Code" width="200" height="200">
            </div>
            <div class="amount-pill">₹{{ number_format($order->final_amount, 2) }}</div>
            <div style="font-size:.8rem;color:#999">Scan with any UPI app to pay</div>
        </div>

        {{-- UPI app icons --}}
        <div class="app-icons">
            <div class="app-icon" title="Google Pay">G</div>
            <div class="app-icon" title="PhonePe" style="background:#5f259f;color:#fff;font-size:.7rem;font-weight:700">Pe</div>
            <div class="app-icon" title="Paytm" style="background:#00baf2;color:#fff;font-size:.65rem;font-weight:700">PTM</div>
            <div class="app-icon" title="BHIM">🇮🇳</div>
        </div>

        {{-- Timer --}}
        <div id="countdownBar"><div id="countdownFill" style="width:100%"></div></div>
        <div class="timer-wrap">
            <div class="timer-badge">
                ⏱️ QR valid for <span id="timer" style="font-weight:800">10:00</span>
            </div>
        </div>

        {{-- Warning --}}
        <div class="warning-box">
            ⚠️ <strong>Do not close this page</strong> until your payment is complete. After paying, click <strong>"I've Paid"</strong> below.
        </div>

        {{-- Confirm form --}}
        <form action="{{ route('checkout.upiConfirm') }}" method="POST" onsubmit="handleConfirm(event, this)">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <button type="submit" class="paid-btn">
                ✅ I've Paid — Confirm Order
            </button>
        </form>

        <a href="{{ route('checkout') }}" class="back-link">← Go back to checkout</a>
    </div>
</div>

<script>
// ── Countdown timer: 10 minutes ────────────────────────────
let seconds = 600;
const fillEl   = document.getElementById('countdownFill');
const timerEl  = document.getElementById('timer');

const interval = setInterval(() => {
    seconds--;
    const m = String(Math.floor(seconds / 60)).padStart(2,'0');
    const s = String(seconds % 60).padStart(2,'0');
    timerEl.textContent = `${m}:${s}`;
    fillEl.style.width  = (seconds / 600 * 100) + '%';

    if (seconds <= 0) {
        clearInterval(interval);
        timerEl.textContent = 'Expired';
        fillEl.style.background = '#dc2626';
        document.querySelector('.paid-btn').disabled = true;
        document.querySelector('.paid-btn').textContent = 'QR Expired — Go Back';
        document.querySelector('.paid-btn').style.background = '#dc2626';
    }
}, 1000);

function handleConfirm(e, form) {
    const btn = form.querySelector('button');
    btn.disabled = true;
    btn.textContent = 'Confirming…';
}
</script>
</body>
</html>