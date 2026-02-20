<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Style Studio - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('user/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/assets/css/style.css') }}">
</head>

<body>

<div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
     style="background-image: url('{{ asset('user/assets/images/backgrounds/login-bg.jpg') }}')">

    <div class="container">
        <div class="form-box">
            <div class="form-tab">
                <h3 class="text-center mb-4">Register</h3>

                <form method="POST" action="#">
                    @csrf

                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>Select Role *</label>
                        <select class="form-control" name="role" required>
                            <option value="">Select Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-outline-primary-2 btn-block">
                            <span>SIGN UP</span>
                            <i class="icon-long-arrow-right"></i>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ url('login') }}">Already have an account? Login</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('user/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('user/assets/js/main.js') }}"></script>

</body>
</html>