@php
    use App\Models\WebsiteSetting;
    $setting = WebsiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password | {{ $setting ? $setting->web_name : 'BuzzPilot' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $setting ? $setting->web_description : '' }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <link rel="shortcut icon" href="{{ $setting ? asset('storage/' . $setting->web_favicon) : '' }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="h-100">

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="index.html" class="auth-brand mb-3">
                        <img src="{{ $setting ? asset('storage/' . $setting->web_logo) : asset('assets/images/logo-dark.png') }}"
                            alt="dark logo" height="50" class="logo-dark">
                        <img src="{{ $setting ? asset('storage/' . $setting->web_logo) : asset('assets/images/logo.png') }}"
                            alt="logo light" height="50" class="logo-light">
                    </a>

                    <h4 class="fw-semibold mb-2">Forgot Password</h4>

                    <p class="text-muted mb-4">Enter your username or email address to reset your password.</p>

                    <form action="{{ route('forgot.password.email') }}" method="POST" class="text-start mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Username or Email</label>
                            <input type="text" id="login" name="email" class="form-control"
                                placeholder="Enter your username or email" value="{{ old('login') }}">
                            @error('login')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
                        </div>
                    </form>

                    @if (session('status'))
                        <div class="alert alert-success mt-3">{{ session('status') }}</div>
                    @endif

                    <p class="text-danger fs-14 mb-4">Remembered your password?
                        <a href="{{ route('login') }}" class="fw-semibold text-dark ms-1">Login here</a>
                    </p>

                    <p class="mt-auto mb-0">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ $setting ? $setting->web_name : 'BuzzPilot' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
