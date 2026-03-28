    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home')}}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/company/' . $company->company_logo) }}" alt="Logo" class="me-2">
                    <div>
                        <strong class="d-block" style="line-height: 1; color: var(--primary-green);"> {{$company->company_name}}</strong>
                        <small style="font-size: 0.7rem; color: #555;"> {{$company->business_name}}</small>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}" href="{{ route('frontend.about')}}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.events') ? 'active' : '' }}" href="{{ route('frontend.events')}}">Events</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.gallery') ? 'active' : '' }}" href="{{ route('frontend.gallery')}}">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.blogs') ? 'active' : '' }}" href="{{ route('frontend.blogs')}}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.trustee') ? 'active' : '' }}" href="{{ route('frontend.trustee')}}">Trustees</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}" href="{{ route('frontend.contact')}}">Contact</a></li>    </ul>
            </div>
        </div>
    </nav>