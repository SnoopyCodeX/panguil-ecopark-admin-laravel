<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/admin/dashboard') }}" class="sidebar-brand">
            <span class="mdi mdi-leaf"></span>Eco<span>Park</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">

            <li class="nav-item nav-category">Quick Summary</li>
            <li class="nav-item">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ url('/admin/reservations') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Reservations</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#tourists" role="button" aria-expanded="false"
                    aria-controls="tourists">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Tourists</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="tourists">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/registered-tourists') }}" class="nav-link">Registered Tourists</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/add-tourist') }}" class="nav-link">Add Tourist</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#tourguides" role="button" aria-expanded="false"
                    aria-controls="tourguides">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Tour Guides</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="tourguides">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/tour-guides') }}" class="nav-link">Assigned Tour Guides</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/assign-tour-guide') }}" class="nav-link">Assign Tour Guide</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/tracking') }}" class="nav-link">
                    <i class="link-icon" data-feather="map"></i>
                    <span class="link-title">Tracking</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
