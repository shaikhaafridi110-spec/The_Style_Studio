{{-- resources/views/checkout/otp.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP — {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Sora', sans-serif; }
        body { background: #f4f4f0; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem; }

        .otp-card {
            background:#fff; border-radius:24px; max-width:420px; width:100%;
            box-shadow:0 4px 32px rgba(0,0,0,.1); overflow:hidden;
        }
        .otp-header {
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            padding:1.75rem; text-align:center; color:#fff;
        }
        .otp-header .icon-wrap {
            width:60px; height:60px; background:rgba(255,255,255,.2);
            border-radius:18px; display:flex; align-items:center; justify-content:center;
            font-size:1.8rem; margin:0 auto .75rem; backdrop-filter:blur(8px);
        }
        .otp-header h5 { margin:0; font-weight:700; font-size:1.15rem; }
        .otp-header .sub { color:rgba(255,255,255,.8); font-size:.8rem; margin-top:.3rem; }

        .otp-body { padding:2rem; }

        .email-badge {
            background:#f8f8f8; border-radius:10px; padding:.7rem 1rem;
            display:flex; align-items:center; gap:.6rem; margin-bottom:1.5rem;
            font-size:.84rem;
        }
        .email-badge .em { font-weight:700; color:#111; word-break:break-all; }

        /* OTP Boxes */
        .otp-boxes { display:flex; gap:.6rem; justify-content:center; margin-bottom:1.5rem; }
        .otp-box {
            width:52px; height:62px; border-radius:12px;
            border:2.5px solid #e0e0e0; background:#fff;
            text-align:center; font-size:1.5rem; font-weight:800; color:#111;
            outline:none; transition:all .2s;
        }
        .otp-box:focus { border-color:#f59e0b; box-shadow:0 0 0 4px rgba(245,158,11,.15); }
        .otp-box.error { border-color:#dc2626; background:#fff5f5; animation:shake .3s; }
        .otp-box.success { border-color:#22c55e; background:#f0fdf4; }

        @keyframes shake {
            0%,100% { transform:translateX(0); }
            20%,60%  { transform:translateX(-4px); }
            40%,80%  { transform:translateX(4px); }
        }

        .alert-box {
            border-radius:12px; padding:.75rem 1rem; font-size:.83rem;
            font-weight:500; margin-bottom:1rem; display:none;
        }
        .alert-box.show { display:block; }
        .alert-box.error   { background:#fef2f2; color:#dc2626; border:1.5px solid #fecaca; }
        .alert-box.success { background:#f0fdf4; color:#16a34a; border:1.5px solid #bbf7d0; }
        .alert-box.info    { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; }

        /* Verify Button */
        .verify-btn {
            width:100%; padding:1.1rem; border:none; border-radius:14px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            color:#fff; font-size:1rem; font-weight:700;
            cursor:pointer; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
        }
        .verify-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(245,158,11,.35); }
        .verify-btn:disabled { background:#ccc; cursor:not-allowed; transform:none; box-shadow:none; }

        /* Resend */
        .resend-wrap { text-align:center; margin-top:1.1rem; font-size:.82rem; color:#888; }
        .resend-btn { background:none; border:none; color:#f59e0b; font-weight:700; cursor:pointer; font-size:.82rem; font-family:inherit; }
        .resend-btn:disabled { color:#ccc; cursor:not-allowed; }

        /* Success overlay */
        #successOverlay {
            display:none; position:fixed; inset:0; background:rgba(0,0,0,.7);
            z-index:9999; align-items:center; justify-content:center;
        }
        #successOverlay.show { display:flex; }
        .success-popup {
            background:#fff; border-radius:24px; padding:2.5rem;
            text-align:center; max-width:320px; animation:popIn .4s cubic-bezier(.175,.885,.32,1.275);
        }
        @keyframes popIn {
            from { transform:scale(.6); opacity:0; }
            to   { transform:scale(1);  opacity:1; }
        }
        .check-circle {
            width:72px; height:72px; background:linear-gradient(135deg,#22c55e,#16a34a);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:2rem; margin:0 auto 1rem; box-shadow:0 8px 24px rgba(34,197,94,.3);
        }
    </style>
</head>
<body>

{{-- Success Overlay --}}
<div id="successOverlay">
    <div class="success-popup">
        <div class="check-circle">✓</div>
        <h5 style="font-weight:800;margin-bottom:.5rem">Order Confirmed!</h5>
        <p style="color:#888;font-size:.85rem;margin-bottom:0">Redirecting you to your order…</p>
    </div>
</div>

<div class="otp-card">
    <div class="otp-header">
        <div class="icon-wrap">📧</div>
        <h5>Verify Your Order</h5>
        <div class="sub">Enter the OTP sent to your email</div>
    </div>

    <div class="otp-body">

        {{-- Email display --}}
        <div class="email-badge">
            <span style="font-size:1.2rem">✉️</span>
            <div>
                <div style="font-size:.72rem;color:#999">OTP sent to</div>
                <div class="em">{{ Auth::user()->email }}</div>
            </div>
        </div>

        {{-- Order info row --}}
        <div style="display:flex;gap:.5rem;margin-bottom:1.5rem">
            <div style="flex:1;background:#f8f8f8;border-radius:10px;padding:.6rem .9rem;font-size:.78rem">
                <div style="color:#999">Order</div>
                <div style="font-weight:700;color:#111">#{{ $order->order_number }}</div>
            </div>
            <div style="flex:1;background:#f8f8f8;border-radius:10px;padding:.6rem .9rem;font-size:.78rem">
                <div style="color:#999">Total</div>
                <div style="font-weight:700;color:#111">₹{{ number_format($order->final_amount, 2) }}</div>
            </div>
            <div style="flex:1;background:#f8f8f8;border-radius:10px;padding:.6rem .9rem;font-size:.78rem">
                <div style="color:#999">Method</div>
                <div style="font-weight:700;color:#111">COD</div>
            </div>
        </div>

        {{-- Alert --}}
        <div id="alertBox" class="alert-box"></div>

        {{-- OTP Input --}}
        <div class="otp-boxes" id="otpBoxes">
            @for($i=0;$i<6;$i++)
            <input type="text" class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
            @endfor
        </div>

        {{-- Verify --}}
        <button class="verify-btn" id="verifyBtn" onclick="verifyOtp()">
            <span id="verifyBtnText">Verify OTP & Confirm Order</span>
        </button>

        {{-- Resend --}}
        <div class="resend-wrap">
            Didn't receive OTP?
            <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Resend</button>
            <span id="timerTxt"></span>
        </div>

    </div>
</div>

<script>
const ORDER_ID = {{ $order->id }};
const boxes    = document.querySelectorAll('.otp-box');

// ── Box navigation ────────────────────────────────────────
boxes.forEach((box, i) => {
    box.addEventListener('keypress', e => { if(!/[0-9]/.test(e.key)) e.preventDefault(); });
    box.addEventListener('input', e => {
        if(e.target.value && i < boxes.length-1) boxes[i+1].focus();
        if(e.target.value.length > 1) e.target.value = e.target.value.slice(-1);
    });
    box.addEventListener('keydown', e => {
        if(e.key==='Backspace' && !e.target.value && i>0) boxes[i-1].focus();
    });
    // Handle paste
    box.addEventListener('paste', e => {
        e.preventDefault();
        const digits = (e.clipboardData.getData('text')).replace(/\D/g,'').slice(0,6);
        digits.split('').forEach((d,j) => { if(boxes[j]) boxes[j].value = d; });
        if(boxes[Math.min(digits.length, 5)]) boxes[Math.min(digits.length, 5)].focus();
    });
});

function getOtp() { return Array.from(boxes).map(b=>b.value).join(''); }

function showAlert(msg, type) {
    const el = document.getElementById('alertBox');
    el.className = `alert-box ${type} show`;
    el.textContent = msg;
}

// ── Verify OTP ────────────────────────────────────────────
function verifyOtp() {
    const otp = getOtp();
    if(otp.length < 6) { showAlert('Please enter the complete 6-digit OTP.', 'error'); return; }

    const btn = document.getElementById('verifyBtn');
    document.getElementById('verifyBtnText').textContent = 'Verifying…';
    btn.disabled = true;
    boxes.forEach(b => b.classList.remove('error','success'));

    fetch('{{ route("checkout.verifyOtp") }}', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
        body: JSON.stringify({ order_id: ORDER_ID, otp })
    })
    .then(r=>r.json())
    .then(data => {
        if(data.status === 'success') {
            boxes.forEach(b => b.classList.add('success'));
            showAlert('✅ ' + data.message, 'success');
            document.getElementById('successOverlay').classList.add('show');
            setTimeout(() => window.location = data.redirect, 1500);
        } else {
            showAlert('❌ ' + data.message, 'error');
            boxes.forEach(b => { b.classList.add('error'); b.value = ''; });
            boxes[0].focus();
            document.getElementById('verifyBtnText').textContent = 'Verify OTP & Confirm Order';
            btn.disabled = false;
        }
    });
}

// ── Resend OTP with 60s cooldown ─────────────────────────
let cooldown = 0;
function startCooldown(s) {
    cooldown = s;
    document.getElementById('resendBtn').disabled = true;
    const t = setInterval(() => {
        cooldown--;
        document.getElementById('timerTxt').textContent = ` (${cooldown}s)`;
        if(cooldown <= 0) {
            clearInterval(t);
            document.getElementById('resendBtn').disabled = false;
            document.getElementById('timerTxt').textContent = '';
        }
    }, 1000);
}

function resendOtp() {
    fetch('{{ route("checkout.resendOtp") }}', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
        body: JSON.stringify({ order_id: ORDER_ID })
    })
    .then(r=>r.json())
    .then(data => {
        showAlert('📧 ' + data.message, 'info');
        startCooldown(60);
    });
}

// Start with 30s initial cooldown
startCooldown(30);
boxes[0].focus();
</script>
</body>
</html>