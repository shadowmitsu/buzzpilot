@php
    use App\Models\WebsiteSetting;
    $setting = WebsiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | {{ $setting ? $setting->web_name : 'BuzzPilot' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $setting ? $setting->web_description : '' }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <link rel="shortcut icon" href="{{ $setting ? asset('storage/'.$setting->web_favicon) : '' }}">
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
                        <img src="{{ $setting ? asset('storage/'.$setting->web_logo) : asset('assets/images/logo-dark.png') }}" alt="dark logo" height="50" class="logo-dark">
                        <img src="{{ $setting ? asset('storage/'.$setting->web_logo) :  asset('assets/images/logo.png') }}" alt="logo light" height="50" class="logo-light">
                    </a>

                    <h4 class="fw-semibold mb-2">Welcome to {{ $setting ? $setting->web_name : 'BuzzPilot' }}</h4>

                    <p class="text-muted mb-4">Enter your name , email address and password to access account.</p>

                    <form action="{{ route('login') }}" method="POST" class="text-start mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="login">Username or Email</label>
                            <input type="text" id="login" name="login" class="form-control" placeholder="Enter your username or email" value="{{ old('login') }}">
                            @error('login')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>
                    
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    
                        @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </form>

                    <p class="text-danger fs-14 mb-4">Don't have an account? 
                        <a href="{{ route('register.page') }}" class="fw-semibold text-dark ms-1">Register !</a>
                    </p>

                    <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © {{ $setting ? $setting->web_name : 'BuzzPilot' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>