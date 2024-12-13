<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ Request::is('dashboard*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ (Request::is('roles*') || Request::is('permission*') || Request::is('access*')) ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow {{ (Request::is('role*') || Request::is('permission*') || Request::is('access*')) ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-lock-open"></i>
                        <span class="hide-menu">Access Control </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line {{ (Request::is('role*') || Request::is('permission*') || Request::is('access*')) ? 'in' : '' }}">
                        <li class="sidebar-item {{ Request::is('roles*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles') }}" aria-expanded="false">
                                <i class="fas fa-check"></i>
                                <span class="nav-label">Roles</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('permission*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('permission*') ? 'active' : '' }}" href="{{ route('permission') }}" aria-expanded="false">
                                <i class="fas fa-key"></i>
                                <span class="nav-label">Permissions</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ Request::is('users*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users') }}" aria-expanded="false">
                        <i class="far fa-user-circle"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('sub-domain*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('sub-domain*') ? 'active' : '' }}" href="{{ route('sub-domain') }}" aria-expanded="false">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <span class="hide-menu">Sub Domain</span>
                    </a>
                </li>

                @if (auth()->user()->hasPermission(['product-create', 'product-view', 'product-update', 'product-delete']))
                <li class="sidebar-item {{ Request::is('products*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products') }}" aria-expanded="false">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        <span class="hide-menu">Products</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
