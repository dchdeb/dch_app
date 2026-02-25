<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DCH Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{ asset('image/logo/eHustle icon.png') }}">

    {{-- Early theme boot: default = dark, prevents flash --}}
    {{-- <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const theme = (saved === 'light' || saved === 'dark') ? saved : 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script> --}}
    <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">
</head>

<body class="login-bg-img ">
    <!-- Theme toggle (no inline JS here!) -->
    {{-- <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">☀️</button> --}}

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-theme">
                    <img class="logo-light" src="{{ asset('images/logo/e.png') }}" alt="dch-cloud-hospital-logo"
                        width="60%">
                    <img class="logo-dark " src="{{ asset('images/logo/e.png') }}" alt="dch-cloud-hospital-logo"
                        width="60%">
                </div>
                <div>
                    <p class="text-center fw-normal fs-6  ">  Manage patients as well as hospital related all tasks </p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm" novalidate>
                @csrf

                <div class="input-group">
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@hospital.com') }}"
                        required autocomplete="email" placeholder=" ">
                    <label for="email">Email address</label>
                    <span class="input-border"></span>
                    <span class="error-message" id="emailError">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password" value="12345678" required
                        autocomplete="current-password" placeholder=" ">
                    <label for="password">Password</label>
                    <button type="button" class="password-toggle" id="passwordToggle"
                        aria-label="Toggle password visibility">
                        <svg class="eye-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            aria-hidden="true">
                            <path
                                d="M8 3C4.5 3 1.6 5.6 1 8c.6 2.4 3.5 5 7 5s6.4-2.6 7-5c-.6-2.4-3.5-5-7-5zm0 8.5A3.5 3.5 0 118 4.5a3.5 3.5 0 010 7zm0-5.5a2 2 0 100 4 2 2 0 000-4z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <span class="input-border"></span>
                    <span class="error-message" id="passwordError">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkmark">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                                <path d="M1 4l2.5 2.5L9 1" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        Remember me
                    </label>

                   
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="btn-text">Sign in</span>
                    <div class="btn-loader" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <circle cx="9" cy="9" r="7" stroke="currentColor" stroke-width="2"
                                opacity="0.25" />
                            <path d="M16 9a7 7 0 01-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <animateTransform attributeName="transform" type="rotate" dur="1s"
                                    values="0 9 9;360 9 9" repeatCount="indefinite" />
                            </path>
                        </svg>
                    </div>
                </button>
            </form>

        
            <div class="success-message" id="successMessage" hidden>
                <div class="success-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="12" fill="#635BFF" />
                        <path d="M8 12l3 3 5-5" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3>Welcome back!</h3>
                <p>Redirecting to your dashboard...</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth/script.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
