
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | EquipTrack</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;

            background:
                linear-gradient(
                    90deg,
                    rgba(5, 24, 55, 0.94),
                    rgba(10, 42, 86, 0.76),
                    rgba(10, 42, 86, 0.25)
                ),
                url('https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=2000&q=85');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            width: 1100px;
            max-width: 100%;
            display: grid;
            grid-template-columns: 1fr 0.95fr;
            align-items: center;
            gap: 50px;
        }

        /* LEFT SIDE */

        .branding {
            color: white;
            padding: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 65px;
            height: 65px;
            border: 2px solid white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            background: rgba(255,255,255,0.12);
        }

        .logo h1 {
            font-size: 43px;
            font-weight: 800;
        }

        .line {
            width: 75px;
            height: 5px;
            background: #1684ff;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .branding h2 {
            font-size: 30px;
            line-height: 1.5;
            margin-bottom: 35px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 23px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        /* LOGIN CARD */

        .login-card {
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(15px);
            padding: 50px 45px;
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .school-icon {
            text-align: center;
            font-size: 48px;
            margin-bottom: 12px;
        }

        .login-card h2 {
            text-align: center;
            color: #142e59;
            font-size: 30px;
            margin-bottom: 30px;
            font-weight: 800;
        }

        .success {
            background: #dcfce7;
            color: #15803d;
            padding: 13px;
            border-radius: 9px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 13px;
        }

        .error {
            color: #b91c1c;
            background: #fee2e2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group label {
            display: block;
            color: #142e59;
            font-weight: 700;
            margin-bottom: 9px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px;
            padding-left: 48px;
            border: 1px solid #dce3ed;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            background: white;
            transition: 0.3s;
        }

        .input-wrapper input:focus {
            border-color: #1675e8;
            box-shadow: 0 0 0 4px rgba(22,117,232,0.12);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .show-password {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 5px 0 25px;
            color: #142e59;
            font-size: 14px;
            font-weight: 600;
        }

        .show-password input {
            width: 17px;
            height: 17px;
            accent-color: #1266d6;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 17px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0879ed, #123cb1);
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(18,60,177,0.2);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(18,60,177,0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 27px;
            color: #52627a;
            font-size: 14px;
        }

        .register-link a {
            color: #0866d8;
            font-weight: 800;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            color: #718096;
            font-size: 11px;
            margin-top: 30px;
        }

        /* MOBILE RESPONSIVE */

        @media (max-width: 800px) {
            body {
                padding: 20px;
                background-attachment: scroll;
            }

            .container {
                grid-template-columns: 1fr;
                gap: 20px;
                max-width: 500px;
            }

            .branding {
                text-align: center;
                padding: 10px;
            }

            .logo {
                justify-content: center;
            }

            .logo h1 {
                font-size: 32px;
            }

            .branding h2 {
                font-size: 21px;
                margin-bottom: 15px;
            }

            .line {
                margin: 0 auto 15px;
            }

            .features {
                display: none;
            }

            .login-card {
                padding: 35px 25px;
            }
        }

        @media (max-width: 400px) {
            .login-card {
                padding: 30px 18px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- LEFT BRANDING -->
    <div class="branding">

        <div class="logo">
            <div class="logo-icon">E</div>
            <h1>EquipTrack</h1>
        </div>

        <div class="line"></div>

        <h2>
            School Equipment &amp;<br>
            Property Management System
        </h2>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">📦</div>
                <span>Track School Equipment</span>
            </div>

            <div class="feature">
                <div class="feature-icon">🛡️</div>
                <span>Manage Property Records</span>
            </div>

            <div class="feature">
                <div class="feature-icon">📊</div>
                <span>Generate Reports</span>
            </div>

        </div>

    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="login-card">

        <div class="school-icon">🎓</div>

        <h2>USER LOGIN</h2>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label for="email">Email Address</label>

                <div class="input-wrapper">
                    <span class="input-icon">✉</span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>

                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                </div>
            </div>

            <div class="show-password">
                <input
                    type="checkbox"
                    id="showPassword"
                    onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"
                >
                <label for="showPassword">Show Password</label>
            </div>

            <button type="submit" class="login-btn">
                ⇥ &nbsp; Login
            </button>

        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Create Account</a>
        </div>

        <div class="footer">
            © 2026 EquipTrack | School Equipment Management System
        </div>

    </div>

</div>

</body>
</html>
