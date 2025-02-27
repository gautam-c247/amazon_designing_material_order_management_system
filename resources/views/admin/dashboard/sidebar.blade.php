<aside class="left-sidebar p-0">
    <nav class="sidebar-nav scroll-sidebar">
        <ul id="sidebarnav" class="px-3">
            @foreach (config('admin.menus') as $menu)
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Route::is($menu['route']) ? 'active' : '' }}"
                            href="{{ route($menu['route']) }}"><span class="menu-icon iconify"
                                data-icon="{{ $menu['icon'] }}"></span>
                            <span class="hide-menu">{{ $menu['label'] }}</span>
                        </a>
                    </li>
            @endforeach
        </ul>
    </nav>
</aside>
