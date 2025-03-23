<div data-simplebar>
    <ul class="side-nav">
        <!-- Dashboard -->
        <li class="side-nav-item">
            <a href="{{ route('dashboard') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                    </svg>
                </span>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="#" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-layers-intersect">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 4m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                        <path d="M4 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                    </svg>
                </span>
                <span class="menu-text"> Services </span>
            </a>
        </li>

        <!-- Buat Pesanan -->
        <li class="side-nav-item">
            <a href="{{ route('users.transactions.create') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-package">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="12 1 3 6 12 11 21 6 12 1" />
                        <line x1="3" y1="6" x2="3" y2="12" />
                        <line x1="21" y1="6" x2="21" y2="12" />
                        <line x1="3" y1="12" x2="12" y2="17" />
                        <line x1="21" y1="12" x2="12" y2="17" />
                        <line x1="12" y1="22" x2="12" y2="17" />
                    </svg>
                </span>
                <span class="menu-text"> Buat Pesanan </span>
            </a>
        </li>

        <!-- History Pesanan -->
        <li class="side-nav-item">
            <a href="{{ route('users.transactions.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-history">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 7v5l3 3" />
                        <path d="M12 3a9 9 0 1 0 9 9" />
                    </svg>
                </span>
                <span class="menu-text"> History Pesanan </span>
            </a>
        </li>

        <!-- Topup -->
        <li class="side-nav-item">
            <a href="{{ route('user.deposit.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-cash">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="7" y="9" width="14" height="10" rx="2" />
                        <circle cx="14" cy="14" r="2" />
                        <path d="M3 9v10m0 -5l4 0" />
                    </svg>
                </span>
                <span class="menu-text"> Topup </span>
            </a>
        </li>

        <!-- AI Generator -->
        <li class="side-nav-item">
            <a href="{{ route('ai.generate') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-cpu">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="6" y="6" width="12" height="12" rx="2" />
                        <path d="M9 3v3m6-3v3m-6 12v3m6-3v3m3-6h3m-3-6h3m-12 0h-3m3 6h-3" />
                        <rect x="10" y="10" width="4" height="4" />
                    </svg>
                </span>
                <span class="menu-text"> AI Generator </span>
            </a>
        </li>


        <!-- Pengaduan -->
        <li class="side-nav-item">
            <a href="#" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-alert-circle">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="12" r="9" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12" y2="16.01" />
                    </svg>
                </span>
                <span class="menu-text"> Pengaduan </span>
            </a>
        </li>
    </ul>
</div>
