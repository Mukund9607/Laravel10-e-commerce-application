<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{route('template.admin.dashboard')}}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>																
            </li>
            <li class="nav-item">
                <a href="{{route('category.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sub_category.list') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('product-list') }}" class="nav-link">
                    <i class="nav-icon fas fa-tag"></i>
                    <p>Products</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <!-- <i class="nav-icon fas fa-tag"></i> -->
                    <i class="fas fa-truck nav-icon"></i>
                    <p>Shipping</p>
                </a>
            </li>							
            <li class="nav-item">
                <a href="orders.html" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Orders</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="users.html" class="nav-link">
                    <i class="nav-icon  fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages.html" class="nav-link">
                    <i class="nav-icon  far fa-file-alt"></i>
                    <p>Pages</p>
                </a>
            </li>							
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>