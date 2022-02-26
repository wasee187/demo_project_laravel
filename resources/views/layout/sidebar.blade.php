<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="#!">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">

                        {{-- dynamically generating user and admin sidebar --}}
                        @if (session('user') && (Session::get('user')['role']=='Admin'||Session::get('user')['role']=='admin'))
                            <a class="nav-link" href="/admin">User List</a>
                            <a class="nav-link" href="/register">Register</a>
                            <a class="nav-link" href="/logout">Logout</a>
                        @else 
                            <a class="nav-link" href="/user/file_upload">File Upload</a>
                            <a class="nav-link" href="/file">File Info</a>
                            <a class="nav-link" href="/logout">Logout</a>
                        @endif
                    </nav>
                </div>
    </nav>
</div>