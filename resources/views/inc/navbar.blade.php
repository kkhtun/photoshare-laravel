<div class="navbar">
    <h1 onclick="location.href='/'">
        {{ config('app.name', 'Laravel') }}
    </h1>
    <ul>
        <li class="{{ request()->is('home*') ? 'active' : '' }}">
            <a href="{{ route('home') }}">Home</a>
        </li>
        @if (Auth::guard('web')->check())
            <li class="{{ request()->is('posts/create*') ? 'active' : '' }}">
                <a href="{{ route('posts.create') }}">Create Post</a>
            </li>
            <li class="{{ request()->is('users/posts/' . auth()->user()->slug) ? 'active' : '' }}">
                <a href="{{ url('/users/posts/' . auth()->user()->slug) }}">Your
                    Posts</a>
            </li>
            <li class="drop-down {{ request()->is('users/profile*') ? 'active' : '' }}">
                <a href="{{ route('users.profile') }}"><i class="fas fa-user"></i></a>
                <ul class="sub-nav">
                    <li class="{{ request()->is('users/profile*') ? 'active' : '' }}">
                        <a href="{{ route('users.profile') }}">{{ Auth::guard('web')->user()->name }}</a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault();document.querySelector('#logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        @elseif (Auth::guard('admin')->check())
            <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.home') }}">Dashboard</a>
            </li>
            <li class="drop-down">
                <a href="#"><i class="fas fa-user"></i></a>
                <ul class="sub-nav">
                    <li class="{{ request()->is('admin/profile*') ? 'active' : '' }}">
                        <a href="#">
                            ADMIN {{ Auth::guard('admin')->user()->name }}<span class="caret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();">
                            Logout
                        </a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li class="{{ request()->is('login*') ? 'active' : '' }}">
                <a href="{{ route('login') }}">Login</a>
            </li>
            <li class="{{ request()->is('register*') ? 'active' : '' }}">
                <a href="{{ route('register') }}">Register</a>
            </li>
        @endif
    </ul>
</div>
