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
            <div class="form-box">
                <div class="form-tab">
                    <h3>Reset Password</h3>

                    <form method="POST" action="{{ url('reset-password') }}">
                        @csrf

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" id="pass"name="password" class="form-control" required>
                        </div>

                        <div class="form-group mt-2">
                            <label>Confirm Password</label>
                            <input type="password" id="pass1"name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check"> <input type="checkbox" class="form-check-input" id="showPassword"> <label class="form-check-label" for="showPassword"> Show Password </label> </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            Reset Password
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
            document.getElementById("pass").type = type;
            document.getElementById("pass1").type = type;
        });
    </script>

</body>

</html>