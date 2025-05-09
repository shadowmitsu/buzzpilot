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

        <!-- Services -->
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#servicesMenu" aria-expanded="false" aria-controls="servicesMenu"
                class="side-nav-link">
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
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="servicesMenu">
                <ul class="sub-menu">
                    <li class="side-nav-item">
                        <a href="{{ route('digital_platforms.index') }}" class="side-nav-link">
                            <span class="menu-text">Digital & Interaction</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('original_services.index') }}" class="side-nav-link">
                            <span class="menu-text">Original Services</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('primary_services.index') }}" class="side-nav-link">
                            <span class="menu-text">Primary Services</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Transaction -->
        <li class="side-nav-item">
            <a href="{{ route('transactions.deposits.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-replace">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M15 15m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" />
                        <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" />
                    </svg>
                </span>
                <span class="menu-text"> Transaction Deposit</span>
            </a>
        </li>

        <!-- Ticketing -->
        <li class="side-nav-item">
            <a href="{{ route('tickets.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ticket">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 5l0 2" />
                        <path d="M15 11l0 2" />
                        <path d="M15 17l0 2" />
                        <path
                            d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
                    </svg>
                </span>
                <span class="menu-text"> Ticketing </span>
            </a>
        </li>

        <!-- Users -->
        <li class="side-nav-item">
            <a href="{{ route('user-managements.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </span>
                <span class="menu-text"> Users </span>
            </a>
        </li>

        <!-- Setting Website -->
        <li class="side-nav-item">
            <a href="{{ route('website-settings.index') }}" class="side-nav-link">
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                </span>
                <span class="menu-text"> Setting Website </span>
            </a>
        </li>
    </ul>

    <div class="clearfix"></div>
</div>
