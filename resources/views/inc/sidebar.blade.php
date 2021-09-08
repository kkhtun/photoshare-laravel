<!-- Sidebar-->
<div class="border-end bg-white col-2" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-light">Admin Panel</div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-2 {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}"
            href="{{ route('admin.home') }}">
            &nbsp;Home</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-2 {{ request()->segment(2) == 'users' ? 'active' : '' }}"
            href="{{ route('admin.users') }}">
            &nbsp;Users</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-2 {{ request()->segment(2) == 'posts' ? 'active' : '' }}"
            href="{{ route('admin.posts') }}">
            &nbsp;Posts</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-2 {{ request()->segment(2) == 'categories' ? 'active' : '' }}"
            href="{{ route('admin.categories') }}">
            &nbsp;Categories</a>
    </div>
</div>
