<div class="sidebar">
    <ul>
        <li class="{{ request()->segment(2) == 'dashboard' ? 'sidebar-active' : '' }}"><a
                href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="{{ request()->segment(2) == 'users' ? 'sidebar-active' : '' }}"><a
                href="{{ route('admin.users') }}">Users</a></li>
        <li class="{{ request()->segment(2) == 'posts' ? 'sidebar-active' : '' }}"><a
                href="{{ route('admin.posts') }}">Posts</a></li>
        <li class="{{ request()->segment(2) == 'categories' ? 'sidebar-active' : '' }}"><a
                href="{{ route('admin.categories') }}">Categories</a></li>
    </ul>
</div>
