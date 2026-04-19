@extends('user/layout')
@section('user-css')
<style>
    .custom-alert {
    position: fixed !important;
    top: 80px !important; /* avoid navbar overlap */
    right: 20px !important;
    background: #ff4d4d !important;
    color: #fff !important;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    z-index: 999999 !important; /* VERY IMPORTANT */
    
    display: flex;
    align-items: center;
    gap: 10px;

    box-shadow: 0 10px 25px rgba(0,0,0,0.3);

    animation: slideIn 0.4s ease;
}

/* Close */
.close-btn {
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

/* Animation */
@keyframes slideIn {
    from {
        transform: translateX(120%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
@endsection


@section('content')

<div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
    style="background-image: url('{{ asset('user/assets/images/backgrounds/login-bg.jpg') }}')">
    {{-- Error Alert --}}
   @if(session('error') || isset($error))
<div style="
    position: fixed;
    top: 80px;
    right: 20px;
    background: #ff4d4d;
    color: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 14px;
    z-index: 999999;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
">
    {{ $error ?? session('error') }}
    <span onclick="this.parentElement.remove()" 
          style="margin-left:10px; cursor:pointer;">×</span>
</div>
@endif

    {{-- Success Alert --}}
   @if(isset($success) || session('success'))
<div style="
    position: fixed;
    top: 80px;
    right: 20px;
    background: #4CAF50;
    color: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 14px;
    z-index: 999999;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    gap: 10px;
">
    <span>
        {{ $success ?? session('success') }}
    </span>

    <span onclick="this.parentElement.remove()" 
          style="cursor:pointer; font-weight:bold; font-size:18px;">
        ×
    </span>
</div>
@endif

    <div class="container">
   
        <div class="form-box">
            <div class="form-tab">

                <h3 class="text-center mb-4">Sign In</h3>

                <form method="POST" action="{{url('login_process')}}">
                    @csrf

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check"> <input type="checkbox" class="form-check-input" id="showPassword"> <label class="form-check-label" for="showPassword"> Show Password </label> </div>
                    </div>
                    <div class="text-right mt-2" style="color: blue;">
                        <a href="{{ url('forgot-password') }}">Forgot Password?</a>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-outline-primary-2 btn-block">
                            <span>LOG IN</span>
                            <i class="icon-long-arrow-right"></i>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ url('auth/google') }}" class="btn btn-danger btn-block">
                            Sign Up with Google
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("showPassword").addEventListener("change", function () {
        let passwordField = document.getElementById("password");

        if (this.checked) {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    });
    function closeAlert() {
        document.getElementById("errorAlert").style.display = "none";
    }
</script>
@endsection