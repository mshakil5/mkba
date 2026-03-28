@extends('frontend.layouts.master')

@section('content')


    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $key => $slider)
                <button type="button" 
                        data-bs-target="#heroCarousel" 
                        data-bs-slide-to="{{ $key }}" 
                        class="{{ $loop->first ? 'active' : '' }}" 
                        aria-current="{{ $loop->first ? 'true' : 'false' }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($sliders as $slider)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" 
                    style="background-image: url('{{ asset('uploads/slider/' . $slider->image) }}');">
                    <div class="carousel-overlay"></div>
                    
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $slider->title }}</h5>
                        <p>{{ $slider->sub_title }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <section class="section-padding text-center bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="subtitle">Our Mission</span>
                    <h1 class="main-title">Building Bridges, Enriching Lives</h1>
                    <p class="text-muted lead">The Milton Keynes Bangladeshi Association is dedicated to serving the Bangladeshi community through cultural, educational, and social programmes.</p>
                </div>
            </div>

            <div class="row g-4 mt-5">
                @foreach($missions as $mission)
                    <div class="col-md-6 col-lg-3">
                        <div class="mission-card text-start">
                            <div class="icon-box">
                                <i class="{{ $mission->icon }}"></i>
                            </div>
                            <h3 class="card-title">{{ $mission->title }}</h3>
                            <p class="card-text">{{ $mission->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="stats-section py-5" style="background-color: #00684a; color: white;">
        <div class="container py-4">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="stat-icon mb-3">
                        <i class="fa-solid fa-users-line fs-3" style="color: #ff4d4d;"></i>
                    </div>
                    <h2 class="fw-bold mb-0">2,000+</h2>
                    <p class="small opacity-75">Community Members</p>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-icon mb-3">
                        <i class="fa-solid fa-calendar-check fs-3" style="color: #ff4d4d;"></i>
                    </div>
                    <h2 class="fw-bold mb-0">50+</h2>
                    <p class="small opacity-75">Events Per Year</p>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-icon mb-3">
                        <i class="fa-solid fa-heart-pulse fs-3" style="color: #ff4d4d;"></i>
                    </div>
                    <h2 class="fw-bold mb-0">500+</h2>
                    <p class="small opacity-75">Families Supported</p>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-icon mb-3">
                        <i class="fa-solid fa-award fs-3" style="color: #ff4d4d;"></i>
                    </div>
                    <h2 class="fw-bold mb-0">20+</h2>
                    <p class="small opacity-75">Years of Service</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Events-->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="subtitle" style="color: #ff4d4d; letter-spacing: 2px; font-weight: 700; font-size: 0.8rem;">WHAT'S COMING</span>
                <h2 class="fw-bold" style="color: #0a1d37; font-size: 2.5rem;">Upcoming Events</h2>
            </div>

            <div class="row g-4">
                @foreach($events as $event)
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
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('frontend.events') }}" class="btn btn-outline-success px-5 py-2 rounded-pill fw-bold" style="border-color: #00684a; color: #00684a;">
                    View All Events <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        /* Event Specific Styles */
        .event-card {
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .event-card:hover .event-img {
            transform: scale(1.1);
        }
        .event-img {
            transition: transform 0.5s ease;
            height: 250px;
            width: 100%;
            object-fit: cover;
        }
        .date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: white;
            padding: 8px 12px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            min-width: 55px;
        }
        .date-badge .day {
            display: block;
            font-weight: 800;
            font-size: 1.2rem;
            color: #0a1d37;
            line-height: 1;
        }
        .date-badge .month {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: #ff4d4d;
        }
        .event-meta {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .event-meta i {
            width: 15px;
        }
        
        /* Responsive adjustment for stats */
        @media (max-width: 768px) {
            .main-title { font-size: 2rem; }
            .event-img { height: 200px; }
        }
    </style>


    <!-- Activities -->
    <section class="section-padding" style="background-color: #fcfdfd;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="subtitle" style="color: #ff4d4d; letter-spacing: 2px; font-weight: 700; font-size: 0.8rem;">WHAT WE DO</span>
                <h2 class="fw-bold" style="color: #0a1d37; font-size: 2.5rem;">Our Activities</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">From cultural celebrations to educational workshops, we organize diverse activities that bring our community together.</p>
            </div>

            <div class="row g-4">
                @foreach($activities as $activity)
                    <div class="col-sm-6 col-lg-4">
                        <div class="activity-card">
                            <div class="img-container mb-3">
                                <img src="{{ asset($activity->image) }}" alt="{{ $activity->title }}">
                                
                                <span class="category-tag tag-{{ strtolower($activity->category) }}">
                                    <i class="fa-solid fa-tag me-1"></i> {{ $activity->category }}
                                </span>

                                <div class="activity-date">
                                    <span class="d-block fw-bold fs-5">
                                        {{ date('d', strtotime($activity->activity_date)) }}
                                    </span>
                                    <span class="month-year">
                                        {{ date('M Y', strtotime($activity->activity_date)) }}
                                    </span>
                                </div>
                            </div>
                            
                            <h5 class="fw-bold mb-2">{{ $activity->title }}</h5>
                            
                            <p class="text-muted small mb-3">
                                {{ Str::limit($activity->description, 100) }}
                            </p>
                            
                            <div class="meta-info">
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i> 
                                    {{ $activity->time_range }}
                                </span>
                                <span>
                                    <i class="fa-solid fa-location-dot"></i> 
                                    {{ $activity->location }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('frontend.activities') }}" class="btn btn-view-all px-5 py-2 rounded-pill fw-bold">
                    View All Activities <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>


    <style>
        /* Card Container & Images */
        .activity-card {
            cursor: pointer;
            transition: 0.3s ease;
        }
        .img-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            height: 240px;
        }
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .activity-card:hover img {
            transform: scale(1.08);
        }

        /* Category Tags */
        .category-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: lowercase;
        }
        .tag-sports { background: #fef3e7; color: #b45309; }
        .tag-cultural { background: #f3e8ff; color: #7e22ce; }
        .tag-educational { background: #dbeafe; color: #1d4ed8; }
        .tag-religious { background: #d1fae5; color: #047857; }

        /* Floating Date Badge */
        .activity-date {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: white;
            padding: 8px 12px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            min-width: 70px;
        }
        .activity-date span { line-height: 1.1; }
        .month-year {
            font-size: 0.65rem;
            font-weight: 800;
            color: #ff4d4d;
            display: block;
        }

        /* Meta Info (Time & Location) */
        .meta-info span {
            display: block;
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 4px;
        }
        .meta-info i {
            color: #00684a;
            margin-right: 8px;
            width: 14px;
            text-align: center;
        }

        /* View All Button */
        .btn-view-all {
            background-color: #004a35;
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-view-all:hover {
            background-color: #00684a;
            color: white;
            transform: translateY(-2px);
        }
    </style>



    <section class="cta-section text-center text-white py-5" style="background: linear-gradient(to bottom, #00684a, #004d36);">
        <div class="container py-4">
            <h2 class="fw-bold mb-3" style="font-size: 2.8rem;">Join Our Community</h2>
            <p class="mb-4 mx-auto opacity-90" style="max-width: 650px; font-size: 1.1rem;">
                Be part of a vibrant community that celebrates culture, supports one another, and builds a stronger future together in Milton Keynes.
            </p>
            <a href="{{ route('frontend.contact')}}" class="btn btn-danger px-4 py-2 rounded-pill fw-bold btn-cta-red">
                Get in Touch <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>


@endsection