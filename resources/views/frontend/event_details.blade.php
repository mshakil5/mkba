@extends('frontend.layouts.master')

@section('content')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Hero Header */
        .event-hero {
            /* Dynamic background from the event image */
            background: linear-gradient(rgba(10, 58, 45, 0.9), rgba(10, 58, 45, 0.9)), 
                        url('{{ asset($event->image) }}');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
            text-align: center;
        }
        
        /* Added dynamic status colors */
        .bg-upcoming { background-color: #f39c12 !important; color: white !important; border: none !important; }
        .bg-past { background-color: #94a3b8 !important; color: white !important; }
        .bg-ongoing { background-color: #2ecc71 !important; color: white !important; }


        .event-hero h1 {
            font-weight: 700;
            font-size: 2.5rem;
        }

        /* Content Container - Narrower for Readability */
        .event-container {
            max-width: 850px;
            margin: 0 auto;
        }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #10b981;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 25px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #065f46;
        }

        /* Featured Image */
        .event-img {
            width: 100%;
            height: auto;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        /* Badges */
        .badge-custom {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 8px;
        }
        

        .event-title {
            font-weight: 700;
            font-size: 2rem;
            color: #0f172a;
            margin: 20px 0;
        }

        /* Metadata Row */
        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #64748b;
        }

        .meta-item i {
            color: #10b981;
            margin-right: 8px;
            font-size: 1.1rem;
        }

        hr {
            border-top: 1px solid #e2e8f0;
            margin: 30px 0;
            opacity: 1;
        }

        .event-description {
            font-size: 1rem;
            color: #475569;
            line-height: 1.8;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .event-hero h1 { font-size: 2rem; }
            .event-title { font-size: 1.5rem; }
            .meta-row { flex-direction: column; gap: 10px; }
        }
    </style>


    <header class="event-hero">
        <div class="container">
            <h1>{{ $event->title }}</h1>
        </div>
    </header>

    <main class="container my-5 py-4">
        <div class="event-container">
            
            <a href="{{ route('frontend.events') }}" class="back-link">
                <i class="bi bi-arrow-left me-2"></i> Back to Events
            </a>

            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="event-img">

            <div class="mb-3">
                <span class="badge-custom bg-cultural">{{ $event->category }}</span>
                <span class="badge-custom bg-{{ strtolower($event->status) }}">{{ $event->status }}</span>
            </div>

            <h2 class="event-title">{{ $event->title }}</h2>

            <div class="meta-row">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    {{ date('l, d F Y', strtotime($event->event_date)) }}
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                </div>
                <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    {{ $event->location }}
                </div>
            </div>

            <hr>

            <div class="event-description">
                @if($event->description)
                    {!! $event->description !!}
                @else
                    <p class="text-muted italic">No detailed description provided for this event.</p>
                @endif
            </div>

            @if($relatedEvents->count() > 0)
                <div class="mt-5 pt-5">
                    <h4 class="fw-bold mb-4">Other Recent Events</h4>
                    <div class="row g-4">
                        @foreach($relatedEvents as $related)
                            <div class="col-md-4">
                                <a href="{{ route('events.show', $related->slug) }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm rounded-4 h-100">
                                        <img src="{{ asset($related->image) }}" class="card-img-top rounded-top-4" alt="{{ $related->title }}" style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-dark mb-1">{{ Str::limit($related->title, 40) }}</h6>
                                            <small class="text-muted">{{ date('d M, Y', strtotime($related->event_date)) }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </main>

@endsection