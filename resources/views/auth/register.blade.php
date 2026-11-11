
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | EquipTrack</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(
                    90deg,
                    rgba(7, 32, 70, 0.94),
                    rgba(7, 32, 70, 0.75),
                    rgba(7, 32, 70, 0.35)
                ),
                url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=2000&q=85');

            background-size: cover;
            background-position: center;
            background-attachment: fixed;

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .register-container {
            width: 1100px;
            max-width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 50px;
        }

        /* BRANDING */

        .branding {
            color: white;
            padding: 30px;
        }

        .logo {
            font-size: 43px;
            font-weight: 800;
            margin-bottom: 25px;
        }

        .logo span {
            color: #55a6ff;
        }

        .branding h1 {
            font-size: 38px;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .branding p {
            font-size: 17px;
            line-height: 1.7;
            color: #dceaff;
        }

        .features {
            margin-top: 35px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(50, 130, 230, 0.35);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        /* REGISTER CARD */

        .register-card {
            background: rgba(255, 255, 255, 0.97);
            padding: 38px 42px;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.30);
            backdrop-filter: blur(15px);
        }

        .register-card h2 {
            text-align: center;
            color: #102c54;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            font-weight: 650;
            color: #263b58;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            height: 47px;
            border: 1px solid #d6deea;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 14px;
            outline: none;
            background: #f9fbff;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #1764dc;
            background: white;
            box-shadow: 0 0 0 3px rgba(23, 100, 220, 0.12);
        }

        .readonly-field {
            background: #eef3fa !important;
            color: #244775;
            cursor: not-allowed;
            font-weight: 600;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .show-password {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 5px 0 20px;
            font-size: 14px;
            color: #263b58;
        }

        .show-password input {
            accent-color: #1764dc;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* BUTTON */

        .submit-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(120deg, #1670ed, #103e91);
            box-shadow: 0 7px 18px rgba(23, 100, 220, 0.25);
            transition: 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(23, 100, 220, 0.35);
        }

        /* MESSAGES */

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .validation-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        /* LOGIN LINK */

        .login-link {
            text-align: center;
            margin-top: 22px;
            color: #718096;
            font-size: 14px;
        }

        .login-link a {
            color: #1764dc;
            text-decoration: none;
            font-weight: 700;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer-note {
            text-align: center;
            margin-top: 22px;
            font-size: 11px;
            color: #94a3b8;
        }

        /* RESPONSIVE */

        @media(max-width: 850px) {
            body {
                background-attachment: scroll;
            }

            .register-container {
                grid-template-columns: 1fr;
                gap: 20px;
                max-width: 520px;
            }

            .branding {
                text-align: center;
                padding: 10px;
            }

            .branding h1 {
                font-size: 27px;
            }

            .logo {
                font-size: 32px;
            }

            .features {
                display: none;
            }

            .register-card {
                padding: 30px 25px;
            }
        }

        @media(max-width: 480px) {
            .register-card {
                padding: 25px 20px;
            }

            .register-card h2 {
                font-size: 26px;
            }

            .branding h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="register-container">

    <!-- LEFT BRANDING -->

    <div class="branding">

        <div class="logo">
            📚 Equip<span>Track</span>
        </div>

        <h1>
            School Equipment & Property Management System
        </h1>

        <p>
            Manage, monitor, and organize your school equipment
            and property records in one convenient platform.
        </p>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">📦</div>
                Track School Equipment
            </div>

            <div class="feature">
                <div class="feature-icon">🛡️</div>
                Manage Property Records
            </div>

            <div class="feature">
                <div class="feature-icon">📊</div>
                Generate Reports
            </div>

        </div>

    </div>

    <!-- REGISTRATION FORM -->

    <div class="register-card">

        <h2>Create Account</h2>

        <p class="subtitle">
            Register a new account to get started with EquipTrack.
        </p>

        <!-- SUCCESS MESSAGE -->

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- VALIDATION ERRORS -->

        @if($errors->any())
            <div class="validation-message">
                <strong>Please check the following:</strong>

                <ul style="padding-left: 20px; margin-top: 5px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- FULL NAME -->

            <div class="form-group">
                <label>Full Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter your full name"
                    value="{{ old('name') }}"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- EMAIL -->

            <div class="form-group">
                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    required
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- ACCOUNT TYPE -->

            <div class="form-group">
                <label>Account Type</label>

                <input
                    type="hidden"
                    name="role"
                    value="student"
                >

                <input
                    type="text"
                    value="Student"
                    class="readonly-field"
                    readonly
                >

                <small style="color: #718096; font-size: 12px;">
                    Student account is assigned automatically.
                </small>
            </div>

            <!-- PASSWORD -->

            <div class="form-group">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="password-field"
                    placeholder="Enter your password"
                    required
                >

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->

            <div class="form-group">
                <label>Confirm Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="password-field"
                    placeholder="Confirm your password"
                    required
                >
            </div>

            <!-- SHOW PASSWORD -->

            <div class="show-password">
                <input
                    type="checkbox"
                    id="showPassword"
                >

                <label for="showPassword">
                    Show Password
                </label>
            </div>

            <!-- SUBMIT BUTTON -->

            <button type="submit" class="submit-btn">
                Create Account
            </button>

        </form>

        <!-- LOGIN LINK -->

        <div class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </div>

        <div class="footer-note">
            EQUIPTRACK © 2026 | School Equipment Management System
        </div>

    </div>

</div>

<!-- SHOW PASSWORD SCRIPT -->

<script>
    document.getElementById('showPassword')
        .addEventListener('change', function() {

            document.querySelectorAll('.password-field')
                .forEach(function(field) {
                    field.type = this.checked ? 'text' : 'password';
                }, this);

        });
</script>

</body>
</html>
