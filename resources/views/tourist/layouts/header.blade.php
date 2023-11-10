<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="backdrop-filter: blur(2px); background-color: rgba(0, 0, 0, 0.25);">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tourist-landing-page-navbar" aria-controls="tourist-landing-page-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="tourist-landing-page-navbar">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourist.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourist.reservation') }}">Reservation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourist.tourist_attractions') }}">Tourist Attractions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourist.about_us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourist.ratings_and_reviews') }}">Ratings and Reviews</a>
                </li>
            </ul>
        </div>

        @if(!Auth::guard('tourist')->check())
            <div class="d-flex">
                <a class="btn btn-outline-warning px-5 rounded-pill" href="{{ route('tourist.login') }}">Login</a>
            </div>
        @else
            <div class="dropstart">
                <a class="dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img class="wd-30 ht-30 rounded-circle" src="{{ app()->isProduction() ? Auth::user()->photo : asset('uploads/profiles/' . Auth::user()->photo) ?? 'https://via.placeholder.com/30x30' }}" alt="profile"> --}}
                    <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
                </a>

                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('tourist.my_reservations') }}">My Reservations</a></li>
                    <li><a class="dropdown-item" href="{{ route('tourist.my_account') }}">Account</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('tourist.logout') }}">Logout</a></li>
                </ul>
            </div>
        @endif
    </div>
</nav>

<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
<script>
(function($) {
    'use strict';
    $(function() {
        let navItems = document.querySelectorAll('.navbar-nav li a');
        let url = window.location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
        url = url.replace('tourist', '');
        url = url === '' ? 'home' : url;

        // Dynamically adding .active class to nav links based on current url
        navItems.forEach((navItem) => {
            if(navItem.href === '#') return;

            if(navItem.href.indexOf(url) !== -1) {
                $(navItem).addClass('active');
            }
        });
    });
})(jQuery);
</script>
