@extends('frontend.layouts.master')

@section('content')


    <style>
        :root {
            --primary-green: #00684a;
            --secondary-green: #004d36;
            --accent-red: #ff4d4d;
            --text-dark: #0a1d37;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text-dark);
            background-color: #fff;
        }

        /* --- Navbar --- */
        .navbar {
            padding: 1rem 0;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .nav-link {
            font-weight: 600;
            color: var(--text-dark) !important;
            margin: 0 10px;
        }
        .nav-link.active {
            background-color: var(--primary-green);
            color: #fff !important;
            border-radius: 50px;
            padding: 8px 20px !important;
        }

        /* --- Hero Banner --- */
        .page-hero {
            height: 300px;
            background: linear-gradient(rgba(0, 50, 30, 0.85), rgba(0, 50, 30, 0.85)), 
                        url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }


        /* --- Event Cards --- */
        .event-card {
            border: none;
            background: transparent;
            transition: 0.3s ease;
        }
        .img-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            height: 240px;
        }
        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        .event-card:hover img { transform: scale(1.1); }

        /* Date Badge */
        .date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #fff;
            padding: 8px 12px;
            border-radius: 12px;
            text-align: center;
            min-width: 60px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .date-badge .day {
            display: block;
            font-weight: 800;
            font-size: 1.2rem;
            line-height: 1;
            color: var(--primary-green);
        }
        .date-badge .month {
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--accent-red);
            text-transform: uppercase;
        }

        /* Category Tags */
        .cat-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 4px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        .cat-tag i { font-size: 0.7rem; margin-right: 5px; }
        
        .tag-sports { background: #fef3e7; color: #b45309; }
        .tag-cultural { background: #f3e8ff; color: #7e22ce; }
        .tag-educational { background: #dbeafe; color: #1d4ed8; }
        .tag-religious { background: #d1fae5; color: #047857; }

        /* Event Details */
        .event-title {
            font-weight: 800;
            font-size: 1.2rem;
            margin-top: 15px;
            color: var(--text-dark);
        }
        .event-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .event-meta i {
            color: var(--primary-green);
            margin-right: 8px;
            width: 14px;
        }

        /* --- Responsive Tweaks --- */
        @media (max-width: 768px) {
            .page-hero h1 { font-size: 2.5rem; }
            .filter-btn { padding: 6px 15px; font-size: 0.8rem; }
        }
    </style>

<style>
    /* Filter Container Styling */
    .filter-btn {
        border: none;
        background: transparent;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #64748b;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .filter-btn:hover {
        color: #00684a;
        background: rgba(0, 104, 74, 0.05);
    }

    .filter-btn.active {
        background: #00684a;
        color: #ffffff !important;
        shadow: 0 4px 10px rgba(0, 104, 74, 0.2);
    }



</style>


    <section class="page-hero">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Events</h1>
            <p class="opacity-75 lead">Join us at our community events and celebrations</p>
        </div>
    </section>

    <section class="pb-5 pt-4">
        <div class="container">
            <div class="filter-container text-center">
                <div class="d-inline-flex bg-light p-2 rounded-3 shadow-sm">
                    {{-- Note: For these filters to work, you'd need to pass a 'status' query param in the URL --}}
                    <a href="{{ route('frontend.events') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
                    <a href="{{ route('frontend.events', ['status' => 'Upcoming']) }}" class="filter-btn {{ request('status') == 'Upcoming' ? 'active' : '' }}">Upcoming</a>
                    <a href="{{ route('frontend.events', ['status' => 'Ongoing']) }}" class="filter-btn {{ request('status') == 'Ongoing' ? 'active' : '' }}">Ongoing</a>
                    <a href="{{ route('frontend.events', ['status' => 'Past']) }}" class="filter-btn {{ request('status') == 'Past' ? 'active' : '' }}">Past</a>
                </div>
            </div>

            <div class="row g-4 mt-2">
                @forelse($events as $event)
                    <div class="col-md-4">
                        <div class="event-card">
                            <div class="position-relative overflow-hidden rounded-4 mb-3">
                                <a href="{{ route('events.show', $event->slug) }}"> 
                                    <img src="{{ asset($event->image) }}" class="img-fluid event-img" alt="{{ $event->title }}">
                                </a>
                                <div class="date-badge">
                                    <span class="day">{{ date('d', strtotime($event->event_date)) }}</span>
                                    <span class="month text-uppercase">{{ date('M', strtotime($event->event_date)) }}</span>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-2">
                                <a href="{{ route('events.show', $event->slug) }}" class="text-decoration-none" style="color: #0a1d37; transition: 0.3s;">
                                    {{ $event->title }}
                                </a>
                            </h5>
                            <div class="event-meta">
                                <p class="mb-1">
                                    <i class="fa-regular fa-clock me-2"></i>
                                    {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                                </p>
                                <p class="mb-0">
                                    <i class="fa-solid fa-location-dot me-2"></i>{{ $event->location }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No events found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $events->appends(request()->query())->links() }}
            </div>
        </div>
    </section>

@endsection