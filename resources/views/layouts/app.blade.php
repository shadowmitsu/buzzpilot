@php
    use App\Models\WebsiteSetting;
    $setting = WebsiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ $setting ? $setting->web_name : 'BuzzPilot' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $setting ? $setting->web_description : '' }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <link rel="shortcut icon" href="{{ $setting ? asset('storage/'.$setting->web_favicon) : '' }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="wrapper">
        <div class="sidenav-menu">
            <a href="{{ route('dashboard') }}" class="logo" style="display: flex; align-items: center;">
                <span class="logo-light" style="display: flex; align-items: center;">
                    <img src="{{ $setting ? asset('storage/'.$setting->web_logo) : 'https://www.pngkey.com/png/full/877-8776052_booster-apk-icon.png' }}" width="30" alt="Logo" style="margin-right: 10px;">
                    <span class="logo-lg" style="font-size: 24px; color: #FFF;">{{ $setting ? $setting->web_name : 'BuzzPilot' }}</span>
                </span>
            </a>
            <button class="button-sm-hover">
                <i class="ti ti-circle align-middle"></i>
            </button>
            <button class="button-close-fullsidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            @if (Auth::user()->role == 'superadmin')
                @include('layouts.components.menu_superadmin')
            @elseif (Auth::user()->role == 'operator')

            @else
            @include('layouts.components.menu_user')
            @endif
        </div>

        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="logo">
                        <span class="logo-light" style="display: flex; align-items: center;">
                            <img src="{{ $setting ? asset('storage/'.$setting->web_logo) : 'https://www.pngkey.com/png/full/877-8776052_booster-apk-icon.png' }}" width="20" alt="Logo" style="margin-right: 10px;">
                            <span class="logo-lg" style="font-size: 24px; color: #FFF;">{{ $setting ? $setting->web_name : 'BuzzPilot' }}</span>
                        </span>
                    </a>

                    <button class="sidenav-toggle-button btn btn-secondary btn-icon">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </button>
                    <button class="topnav-toggle-button" data-bs-toggle="collapse"
                        data-bs-target="#topnav-menu-content">
                        <i class="ti ti-menu-deep fs-22"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link btn btn-outline-primary btn-icon" id="light-dark-mode"
                            type="button">
                            <i class="ti ti-moon fs-22"></i>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item">
                        <div class="dropdown">
                            <a class="topbar-link btn btn-outline-primary dropdown-toggle drop-arrow-none"
                                data-bs-toggle="dropdown" data-bs-offset="0,22" type="button"
                                aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" width="24"
                                    class="rounded-circle me-lg-2 d-flex" alt="user-image">
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    {{ Auth::user()->full_name }}.
                                </span>
                                <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if (Auth::user()->role == "user")     
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="ti ti-wallet me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Saldo : <span class="fw-semibold">Rp {{ number_format(Auth::user()->userBalance->balance, 0, '.', '.') }}</span></span>
                                </a>
                            @endif
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <a href="javascript:void(0);" class="dropdown-item active fw-semibold text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                <span class="align-middle">Sign Out</span>
                            </a>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card mb-0 shadow-none">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" id="search-modal-input"
                                placeholder="Search for actions, people,">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal"
                                aria-label="Close">[esc]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">

            <div class="page-container">

                @yield('content')

            </div>


            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Buzz Pilot
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
