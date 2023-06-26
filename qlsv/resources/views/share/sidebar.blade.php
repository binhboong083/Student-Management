<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/theme/index3.html" class="brand-link">
        <img src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/theme/dist/img/son.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Nguyễn Công Bình</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Bảng quản lý lớp học quản lý --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Quản lý lớp học
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/lopquanly/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách lớp học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/lopquanly/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm mới lớp học</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Bảng quản lý lớp môn học --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Quản lý môn học
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/lopmonhoc/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách lớp môn học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/lopmonhoc/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm mới lớp môn học</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Quản lý sinh viên --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Quản lý sinh viên
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/sinhvien/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách sinh viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/sinhvien/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm mới sinh viên</p>
                            </a>
                        </li>
                        {{-- Đăng ký môn học cho sinh viên --}}
                        <li class="nav-item">
                            <a href="/admin/dkhocphan/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đăng ký lớp môn học</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
