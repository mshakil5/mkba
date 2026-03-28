@extends('frontend.layouts.master')

@section('content')


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

    /* Event Card Hover Effect */
    .event-card {
        transition: transform 0.3s ease;
    }
    .event-card:hover {
        transform: translateY(-5px);
    }

    /* Status Badge inside Image */
    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 10;
    }
    .bg-upcoming { background-color: #f39c12; color: white; }
    .bg-past { background-color: #94a3b8; color: white; }
    .bg-ongoing { background-color: #2ecc71; color: white; }


</style>


    <section class="page-hero">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Events</h1>
            <p class="opacity-75 lead">Join us at our community events and celebrations</p>
        </div>
    </section>

    <section class="pb-5">
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