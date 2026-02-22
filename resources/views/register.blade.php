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

                    <h3 class="text-center mb-4">Register Account</h3>

                    <form method="POST" action="{{ url('register_process') }}">
                        @csrf

                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label>Full Name *</label>
                                <input type="text"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror">

                                @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="text"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror">

                                @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Line 1 -->
                            <div class="col-md-6 mb-3">
                                <label>Address Line 1 *</label>
                                <input type="text"
                                    name="address_line1"
                                    class="form-control @error('address_line1') is-invalid @enderror">

                                @error('address_line1')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Line 2 -->
                            <div class="col-md-6 mb-3">
                                <label>Address Line 2 (Optional)</label>
                                <input type="text"
                                    name="address_line2"
                                    class="form-control">
                            </div>

                            <!-- State -->
                            <div class="col-md-6 mb-3">
                                <label>State *</label>
                                <select id="state"
                                    name="state"
                                    class="form-control @error('state') is-invalid @enderror">

                                    <option value="">Select State</option>
                                </select>

                                @error('state')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-6 mb-3">
                                <label>City *</label>
                                <select id="city"
                                    name="city"
                                    class="form-control @error('city') is-invalid @enderror">

                                    <option value="">Select City</option>
                                </select>

                                @error('city')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Postal Code -->
                            <div class="col-md-6 mb-3">
                                <label>Postal Code *</label>
                                <input type="text"
                                    name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror">

                                @error('postal_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Password -->
<div class="col-md-6 mb-3">
    <label>Password *</label>
    <input type="password"
           id="password"
           name="password"
           class="form-control @error('password') is-invalid @enderror">

    @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<!-- Confirm Password -->
<div class="col-md-6 mb-3">
    <label>Confirm Password *</label>
    <input type="password"
           id="confirm_password"
           name="password_confirmation"
           class="form-control">
</div>

<!-- Show Password Checkbox -->     
<div class="col-12 mb-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="showPassword">
        <label class="form-check-label" for="showPassword">
            Show Password
        </label>
    </div>
</div>
                        </div>

                        <div class="form-footer mt-3">
                            <button type="submit" class="btn btn-outline-primary-2 btn-block">
                                <span>SIGN UP</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ url('/') }}">Already have an account? Login</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('user/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/main.js') }}"></script>
    <script>
        const stateDropdown = document.getElementById("state");
        const cityDropdown = document.getElementById("city");


        // 🔹 Load States Automatically
        fetch('https://countriesnow.space/api/v0.1/countries/states', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    country: "India"
                })
            })
            .then(res => res.json())
            .then(data => {

                stateDropdown.innerHTML = '<option value="">Select State</option>';

                data.data.states.forEach(state => {
                    stateDropdown.innerHTML +=
                        `<option value="${state.name}">${state.name}</option>`;
                });

            });


        // 🔹 Load Cities When State Changes
        stateDropdown.addEventListener("change", function() {

            let selectedState = this.value;

            cityDropdown.innerHTML = '<option>Loading...</option>';

            fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        country: "India",
                        state: selectedState
                    })
                })
                .then(res => res.json())
                .then(data => {

                    cityDropdown.innerHTML = '<option value="">Select City</option>';

                    data.data.forEach(city => {
                        cityDropdown.innerHTML +=
                            `<option value="${city}">${city}</option>`;
                    });

                });

        });
    </script>
<script>
document.getElementById("showPassword").addEventListener("change", function () {

    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirm_password");

    if (this.checked) {
        password.type = "text";
        confirmPassword.type = "text";
    } else {
        password.type = "password";
        confirmPassword.type = "password";
    }
});
</script>
</body>

</html>