<aside class="left-sidebar p-0">
    <nav class="sidebar-nav scroll-sidebar">
        <ul id="sidebarnav" class="px-3">
            {{-- Merchant Routes --}}
            {{-- <li class="sidebar-item">
                <a class="sidebar-link {{ Route::is('merchant.dashboard') ? 'active' : '' }}"
                    href="{{ route('merchant.dashboard') }}"><span class="menu-icon iconify"
                        data-icon="material-symbols:dashboard-rounded"></span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li> --}}
            <li class="sidebar-item">
                <a class="sidebar-link {{ Route::is('merchant.brand.index') ? 'active' : '' }}"
                    href="{{ route('merchant.brand.index') }}"><span class="menu-icon iconify"
                        data-icon="material-symbols:branding-watermark"></span>
                    <span class="hide-menu">Brands</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ Route::is('merchant.product.index') ? 'active' : '' }}"
                    href="{{ route('merchant.product.index') }}"><span class="menu-icon iconify"
                        data-icon="material-symbols:inventory"></span>
                    <span class="hide-menu">Products</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
