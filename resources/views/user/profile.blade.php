{{-- resources/views/profile/index.blade.php --}}

@extends('user.layout')

@section('content')

<style>
    /* ── Google Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500&display=swap');

    /* ── Root ── */
    .profile-page {
        font-family: 'DM Sans', sans-serif;
        background: #f9f8f6;
        min-height: 100vh;
    }

    /* ── Hero Banner ── */
    .profile-hero-banner {
        background-image: url("{{ asset('user/assets/images/banners/banner-3.jfif') }}");
        background-size: cover;
        background-position: center;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        margin-bottom: 2rem;
    }

    .profile-hero-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .45);
    }

    .profile-hero-banner h1 {
        position: relative;
        z-index: 1;
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.8rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        letter-spacing: 0.03em;
    }

    .profile-hero-banner h1 span {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: 1.05rem;
        font-weight: 400;
        color: rgba(255, 255, 255, .75);
        margin-top: .4rem;
        letter-spacing: 0;
    }

    .profile-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 16px 80px;
    }

    /* ── Alert ── */
    .alert-success {
        background: #eaf3de;
        color: #3b6d11;
        border: 0.5px solid #c0dd97;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fcebeb;
        color: #a32d2d;
        border: 0.5px solid #f09595;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* ── Avatar + Header Card ── */
    .profile-header-card {
        background: #fff;
        border: 0.5px solid #e0ddd6;
        border-radius: 16px;
        padding: 24px 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .avatar-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #C8A96E;
        padding: 3px;
        flex-shrink: 0;
    }

    .avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #1a1a1a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 600;
        color: #C8A96E;
        letter-spacing: 0.05em;
    }

    .header-meta h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 4px;
        color: #1a1a1a;
    }

    .header-meta p {
        font-size: 13px;
        color: #888;
        margin: 0 0 6px;
    }

    .role-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        background: #C8A96E22;
        color: #9a7840;
        border: 0.5px solid #C8A96E66;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* ── Cards ── */
    .section-card {
        background: #fff;
        border: 0.5px solid #e0ddd6;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 20px;
    }

    .section-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #999;
        margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 0.5px solid #ece9e2;
    }

    /* ── Grid ── */
    .field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .field-grid.full {
        grid-template-columns: 1fr;
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .field-group.span-2 {
        grid-column: span 2;
    }

    /* ── Labels & Inputs ── */
    .field-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #aaa;
    }

    .field-input {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #1a1a1a;
        background: #f9f8f6;
        border: 0.5px solid #d8d4cc;
        border-radius: 8px;
        padding: 10px 14px;
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }

    .field-input:focus {
        border-color: #C8A96E;
        box-shadow: 0 0 0 3px #C8A96E18;
        background: #fff;
    }

    .field-input::placeholder {
        color: #bbb;
    }

    select.field-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23aaa' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
        cursor: pointer;
    }

    .field-error {
        font-size: 11px;
        color: #a32d2d;
        margin-top: 2px;
    }

    /* ── Divider ── */
    .form-divider {
        border: none;
        border-top: 0.5px solid #ece9e2;
        margin: 24px 0;
    }

    /* ── Buttons ── */
    .btn-gold {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.04em;
        padding: 11px 28px;
        background: #1a1a1a;
        color: #C8A96E;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-gold:hover {
        background: #2e2e2e;
    }

    .btn-gold:active {
        transform: scale(0.98);
    }

    .btn-outline {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 400;
        padding: 11px 24px;
        background: transparent;
        color: #555;
        border: 0.5px solid #d8d4cc;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline:hover {
        background: #f4f2ee;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    /* ── Password ── */
    .password-hint {
        font-size: 12px;
        color: #aaa;
        margin-top: 4px;
    }

    /* ── Password Toggle ── */
    .pass-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .pass-wrap .field-input {
        padding-right: 42px;
    }

    .eye-btn {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        color: #aaa;
        transition: color 0.15s;
    }

    .eye-btn:hover {
        color: #C8A96E;
    }

    .eye-icon {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* ── Strength Meter ── */
    .strength-bar-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .strength-bars {
        display: flex;
        gap: 4px;
        flex: 1;
    }

    .sbar {
        height: 4px;
        flex: 1;
        border-radius: 4px;
        background: #e5e2da;
        transition: background 0.25s;
    }

    .strength-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.04em;
        min-width: 52px;
        text-align: right;
    }

    /* ── Match message ── */
    .match-msg {
        font-size: 11px;
        font-weight: 500;
        margin-top: 5px;
        display: block;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .profile-hero-banner h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 600px) {
        .field-grid {
            grid-template-columns: 1fr;
        }

        .field-group.span-2 {
            grid-column: span 1;
        }

        .profile-header-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>



<div class="profile-page">

    {{-- Hero Banner --}}
    <div class="profile-hero-banner">
        <h1>My Profile<span>Manage your personal information and account settings</span></h1>
    </div>

    <div class="profile-wrap">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 6px 0 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ── Avatar / Summary Card ── --}}
        <div class="profile-header-card">
            <div class="avatar-wrap">
                <div class="avatar-inner">
                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strstr($user->name, ' '), 1, 1)) }}
                </div>
            </div>
            <div class="header-meta">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <span class="role-badge">{{ ucfirst($user->role ?? 'Customer') }}</span>
                @if($user->age)
                <span class="role-badge" style="margin-left: 6px;">Age {{ $user->age }}</span>
                @endif
            </div>
        </div>

        {{-- ── Personal Information Form ── --}}
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="section-card">
                <p class="section-card-title">Personal Information</p>

                <div class="field-grid">
                    {{-- Name --}}
                    <div class="field-group">
                        <label class="field-label" for="name">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="field-input"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Your full name"
                            required />
                        @error('name')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="field-group">
                        <label class="field-label" for="email">Email Address</label>
                        <input disabled
                            type="email"
                            id="email"
                            name="email"
                            class="field-input"
                            value="{{ old('email', $user->email) }}"
                            placeholder="you@example.com"
                            required />
                        @error('email')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="field-group">
                        <label class="field-label" for="phone">Phone Number</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="field-input"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="+91 00000 00000" />
                        @error('phone')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Birthdate --}}
                    <div class="field-group">
                        <label class="field-label" for="birthdate">Date of Birth</label>
                        <input
                            type="date"
                            id="birthdate"
                            name="birthdate"
                            class="field-input"
                            value="{{ old('birthdate', $user->birthdate?->format('Y-m-d')) }}" />
                        @error('birthdate')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="field-group">
                        <label class="field-label" for="gender">Gender</label>
                        <select id="gender" name="gender" class="field-input">
                            <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
    <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
    <option value="other" {{ old('gender', $user->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>

                        </select>
                        @error('gender')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr class="form-divider">

                {{-- ── Address Section ── --}}
                <p class="section-card-title" style="margin-top: 0;">Shipping Address</p>

                <div class="field-grid">
                    {{-- Address Line 1 --}}
                    <div class="field-group span-2">
                        <label class="field-label" for="address_line1">Address Line 1</label>
                        <input
                            type="text"
                            id="address_line1"
                            name="address_line1"
                            class="field-input"
                            value="{{ old('address_line1', $user->address_line1) }}"
                            placeholder="House / Flat / Building" />
                        @error('address_line1')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address Line 2 --}}
                    <div class="field-group span-2">
                        <label class="field-label" for="address_line2">Address Line 2</label>
                        <input
                            type="text"
                            id="address_line2"
                            name="address_line2"
                            class="field-input"
                            value="{{ old('address_line2', $user->address_line2) }}"
                            placeholder="Street / Area / Landmark" />
                        @error('address_line2')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="field-group">
                        <label class="field-label" for="city">City</label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            class="field-input"
                            value="{{ old('city', $user->city) }}"
                            placeholder="Ahmedabad" />
                        @error('city')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div class="field-group">
                        <label class="field-label" for="state">State</label>
                        <input
                            type="text"
                            id="state"
                            name="state"
                            class="field-input"
                            value="{{ old('state', $user->state) }}"
                            placeholder="Gujarat" />
                        @error('state')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Postal Code --}}
                    <div class="field-group">
                        <label class="field-label" for="postal_code">Postal Code</label>
                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            class="field-input"
                            value="{{ old('postal_code', $user->postal_code) }}"
                            placeholder="380009" />
                        @error('postal_code')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold">Save Changes</button>
                    <a href="{{ route('profile.index') }}" class="btn-outline">Cancel</a>
                </div>
            </div>
        </form>

        {{-- ── Change Password Form ── --}}
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="section-card">
                <p class="section-card-title">Change Password</p>

                <div class="field-grid">
                    {{-- Current Password --}}
                    <div class="field-group span-2">
                        <label class="field-label" for="current_password">Current Password</label>
                        <div class="pass-wrap">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="field-input"
                                placeholder="Enter current password"
                                autocomplete="current-password" />
                            <button type="button" class="eye-btn" onclick="togglePass('current_password', this)" aria-label="Show password">
                                <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                                <svg class="eye-icon eye-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="field-group">
                        <label class="field-label" for="password">New Password</label>
                        <div class="pass-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="field-input"
                                placeholder="Min. 8 characters"
                                autocomplete="new-password"
                                oninput="checkStrength(this.value)" />
                            <button type="button" class="eye-btn" onclick="togglePass('password', this)" aria-label="Show password">
                                <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                                <svg class="eye-icon eye-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>

                        {{-- Strength Meter --}}
                        <div class="strength-bar-wrap" id="strength-bar-wrap" style="display:none;">
                            <div class="strength-bars">
                                <span class="sbar" id="sb1"></span>
                                <span class="sbar" id="sb2"></span>
                                <span class="sbar" id="sb3"></span>
                                <span class="sbar" id="sb4"></span>
                            </div>
                            <span class="strength-label" id="strength-label"></span>
                        </div>

                        <span class="password-hint">At least 8 characters.</span>
                        @error('password')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="field-group">
                        <label class="field-label" for="password_confirmation">Confirm New Password</label>
                        <div class="pass-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="field-input"
                                placeholder="Repeat new password"
                                autocomplete="new-password"
                                oninput="checkMatch()" />
                            <button type="button" class="eye-btn" onclick="togglePass('password_confirmation', this)" aria-label="Show password">
                                <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                                <svg class="eye-icon eye-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <span class="match-msg" id="match-msg"></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold">Update Password</button>
                </div>
            </div>
        </form>

    </div>
</div>
@push('scripts')
<script>
    /* ── Show / Hide Password ── */
    function togglePass(id, btn) {
        var inp = document.getElementById(id);
        var isHidden = inp.type === 'password';
        inp.type = isHidden ? 'text' : 'password';
        btn.querySelector('.eye-off').style.display = isHidden ? 'none' : '';
        btn.querySelector('.eye-on').style.display = isHidden ? '' : 'none';
    }

    /* ── Password Strength ── */
    function checkStrength(val) {
        var wrap = document.getElementById('strength-bar-wrap');
        var label = document.getElementById('strength-label');
        var bars = [document.getElementById('sb1'), document.getElementById('sb2'),
            document.getElementById('sb3'), document.getElementById('sb4')
        ];

        if (!val) {
            wrap.style.display = 'none';
            return;
        }
        wrap.style.display = 'flex';

        var score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var colors = ['#e24b4a', '#ef9f27', '#1d9e75', '#0f6e56'];
        var labels = ['Weak', 'Fair', 'Good', 'Strong'];

        bars.forEach(function(b, i) {
            b.style.background = i < score ? colors[score - 1] : '#e5e2da';
        });

        label.textContent = labels[score - 1] || '';
        label.style.color = colors[score - 1] || '#aaa';

        checkMatch();
    }

    /* ── Confirm Match ── */
    function checkMatch() {
        var pw = document.getElementById('password').value;
        var conf = document.getElementById('password_confirmation').value;
        var msg = document.getElementById('match-msg');
        if (!conf) {
            msg.textContent = '';
            return;
        }
        if (pw === conf) {
            msg.textContent = 'Passwords match';
            msg.style.color = '#3b6d11';
        } else {
            msg.textContent = 'Passwords do not match';
            msg.style.color = '#a32d2d';
        }
    }
</script>
@endpush

@endsection