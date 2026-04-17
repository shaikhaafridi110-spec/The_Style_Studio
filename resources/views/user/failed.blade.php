{{-- resources/views/checkout/failed.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family:'Sora',sans-serif; }
        body { background:#f4f4f0; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem; }
        .fail-card {
            background:#fff; border-radius:24px; max-width:420px; width:100%;
            box-shadow:0 4px 32px rgba(0,0,0,.1); overflow:hidden; text-align:center;
        }
        .fail-header {
            background:linear-gradient(135deg,#dc2626,#b91c1c);
            padding:2.5rem 2rem; color:#fff;
        }
        .x-circle {
            width:72px; height:72px; background:rgba(255,255,255,.15); border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:2.2rem; margin:0 auto 1rem;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow:0 0 0 0 rgba(255,255,255,.3); }
            50%      { box-shadow:0 0 0 12px rgba(255,255,255,.0); }
        }
        .fail-header h4 { font-weight:800; margin:0; }
        .fail-header p  { color:rgba(255,255,255,.7); margin-top:.4rem; font-size:.85rem; margin-bottom:0; }

        .fail-body { padding:2rem; }
        .error-msg-box {
            background:#fef2f2; border:1.5px solid #fecaca;
            border-radius:12px; padding:.9rem 1.1rem;
            color:#dc2626; font-size:.83rem; font-weight:500;
            margin-bottom:1.5rem; text-align:left;
        }

        .tip-row {
            display:flex; align-items:flex-start; gap:.75rem;
            text-align:left; padding:.6rem; border-radius:10px;
            background:#f8f8f8; margin-bottom:.6rem; font-size:.8rem;
        }
        .tip-icon { font-size:1.1rem; flex-shrink:0; margin-top:.05rem; }
        .tip-text { color:#555; line-height:1.5; }
        .tip-text strong { color:#111; }

        .retry-btn {
            width:100%; padding:1rem; border:none; border-radius:14px;
            background:#111; color:#fff; font-size:.95rem; font-weight:700;
            cursor:pointer; margin-top:1rem; transition:all .2s;
            text-decoration:none; display:block;
        }
        .retry-btn:hover { background:#333; color:#fff; transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,.18); }
        .home-link { display:block; text-align:center; margin-top:.75rem; font-size:.82rem; color:#aaa; text-decoration:none; }
        .home-link:hover { color:#555; }
    </style>
</head>
<body>

<div class="fail-card">
    <div class="fail-header">
        <div class="x-circle">✕</div>
        <h4>Payment Failed</h4>
        <p>Your order could not be processed</p>
    </div>

    <div class="fail-body">

        @if(session('error'))
        <div class="error-msg-box">⚠️ {{ session('error') }}</div>
        @else
        <div class="error-msg-box">⚠️ Your payment was not completed. No amount has been charged.</div>
        @endif

        <div style="font-size:.8rem;font-weight:700;color:#888;margin-bottom:.6rem;text-align:left">Common reasons:</div>

        <div class="tip-row">
            <span class="tip-icon">💳</span>
            <div class="tip-text"><strong>Insufficient balance</strong> — Check your card/UPI balance before retrying.</div>
        </div>
        <div class="tip-row">
            <span class="tip-icon">📶</span>
            <div class="tip-text"><strong>Network issue</strong> — A poor connection can interrupt payment.</div>
        </div>
        <div class="tip-row">
            <span class="tip-icon">🔒</span>
            <div class="tip-text"><strong>Bank declined</strong> — Your bank may have flagged the transaction.</div>
        </div>

        <a href="{{ route('checkout') }}" class="retry-btn">
            🔄 Try Again
        </a>

        <a href="{{ url('/') }}" class="home-link">← Back to Home</a>
    </div>
</div>

</body>
</html>