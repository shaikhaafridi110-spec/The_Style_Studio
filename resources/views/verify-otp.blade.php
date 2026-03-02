<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>The Style Studio - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('user/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/assets/css/style.css') }}">

    <style>
        .custom-alert {
            position: relative;
            padding: 14px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: linear-gradient(135deg, #ff4d4d, #cc0000);
            color: #fff;
            font-weight: 500;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.5s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-alert .close-btn {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
        style="background-image: url('{{ asset('user/assets/images/backgrounds/login-bg.jpg') }}')">

        <div class="container">
             @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show auto-close" role="alert">
        {{ session('success') }}
    </div>
@endif

            <div class="form-box">
                <div class="form-tab">
                    <h3>Verify OTP</h3>

                   @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show auto-close" role="alert">
        {{ session('error') }}
    </div>
@endif
                   
                    <form method="POST" action="{{ url('verify-otp') }}">
                        @csrf

                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" name="otp" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">
                            Verify OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('user/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/main.js') }}">

    </script>
    <script script>
        function closeAlert() {
            document.getElementById('errorAlert').style.display = 'none';
        }

        // Auto hide after 3 seconds
        setTimeout(function() {
            var alert = document.getElementById('errorAlert');
            if (alert) {
                alert.style.opacity = "0";
                setTimeout(() => alert.style.display = "none", 500);
            }
        }, 3000);
    </script>
    <script>
        setTimeout(function() {
            let alert = document.getElementById("successAlert");
            if (alert) {
                alert.style.display = "none";
            }
        }, 3000);
    </script>
    <script>
        document.getElementById("showPassword").addEventListener("change", function() {
            let type = this.checked ? "text" : "password";
            document.getElementById("password").type = type;
            // document.getElementById("confirm_password").type = type;
        });
        
    </script>
    <script>
    setTimeout(function () {
        let alertList = document.querySelectorAll('.alert');
        alertList.forEach(function (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
</body>

</html>