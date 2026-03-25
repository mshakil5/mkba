@extends('frontend.layouts.master')

@section('content')


    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1600&q=80');">
                <div class="carousel-overlay"></div>
            </div>
            <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=1600&q=80');">
                <div class="carousel-overlay"></div>
            </div>
            <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1600&q=80');">
                <div class="carousel-overlay"></div>
            </div>
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
                <div class="col-md-6 col-lg-3">
                    <div class="mission-card text-start">
                        <div class="icon-box">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h3 class="card-title">Cultural Preservation</h3>
                        <p class="card-text">Celebrating and preserving Bangladeshi heritage, language, and traditions in the UK.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mission-card text-start">
                        <div class="icon-box">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <h3 class="card-title">Education & Learning</h3>
                        <p class="card-text">Providing educational support, language classes, and mentorship programmes.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mission-card text-start">
                        <div class="icon-box">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <h3 class="card-title">Community Welfare</h3>
                        <p class="card-text">Supporting families with welfare services, advice, and community resources.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mission-card text-start">
                        <div class="icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="card-title">Social Integration</h3>
                        <p class="card-text">Fostering harmony and integration within the wider Milton Keynes community.</p>
                    </div>
                </div>
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
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="position-relative overflow-hidden rounded-4 mb-3">
                            <a href="event-details.html"> <img src="https://images.unsplash.com/photo-1531415074968-036ba1b575da?auto=format&fit=crop&w=800&q=80" class="img-fluid event-img" alt="Cricket">
                            </a>
                            <div class="date-badge">
                                <span class="day">20</span>
                                <span class="month">MAY</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">
                            <a href="event-details.html" class="text-decoration-none" style="color: #0a1d37; transition: 0.3s;">Annual Cricket Tournament</a>
                        </h5>
                        <div class="event-meta">
                            <p class="mb-1"><i class="fa-regular fa-clock me-2"></i>9:00 AM - 6:00 PM</p>
                            <p class="mb-0"><i class="fa-solid fa-location-dot me-2"></i>Willen Lake Sports Ground</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="event-card">
                        <div class="position-relative overflow-hidden rounded-4 mb-3">
                            <a href="event-details.html">
                                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80" class="img-fluid event-img" alt="Festival">
                            </a>
                            <div class="date-badge">
                                <span class="day">14</span>
                                <span class="month">APR</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">
                            <a href="event-details.html" class="text-decoration-none" style="color: #0a1d37; transition: 0.3s;">Pohela Boishakh Celebration 2026</a>
                        </h5>
                        <div class="event-meta">
                            <p class="mb-1"><i class="fa-regular fa-clock me-2"></i>12:00 PM - 8:00 PM</p>
                            <p class="mb-0"><i class="fa-solid fa-location-dot me-2"></i>Campbell Park, Milton Keynes</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="event-card">
                        <div class="position-relative overflow-hidden rounded-4 mb-3">
                            <a href="event-details.html">
                                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80" class="img-fluid event-img" alt="Workshop">
                            </a>
                            <div class="date-badge">
                                <span class="day">05</span>
                                <span class="month">APR</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">
                            <a href="event-details.html" class="text-decoration-none" style="color: #0a1d37; transition: 0.3s;">Youth Education Workshop</a>
                        </h5>
                        <div class="event-meta">
                            <p class="mb-1"><i class="fa-regular fa-clock me-2"></i>10:00 AM - 4:00 PM</p>
                            <p class="mb-0"><i class="fa-solid fa-location-dot me-2"></i>MK Library, Central Milton Keynes</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="event.html" class="btn btn-outline-success px-5 py-2 rounded-pill fw-bold" style="border-color: #00684a; color: #00684a;">
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
                <div class="col-sm-6 col-lg-4">
                    <div class="activity-card">
                        <div class="img-container mb-3">
                            <img src="https://images.unsplash.com/photo-1531415074968-036ba1b575da?auto=format&fit=crop&w=800&q=80" alt="Sports">
                            <span class="category-tag tag-sports"><i class="fa-solid fa-tag me-1"></i> sports</span>
                            <div class="activity-date">
                                <span class="d-block fw-bold fs-5">20</span>
                                <span class="month-year">MAY 2026</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">Annual Cricket Tournament</h5>
                        <p class="text-muted small mb-3">Annual community cricket tournament — register your team now!</p>
                        <div class="meta-info">
                            <span><i class="fa-regular fa-calendar-check"></i> 9:00 AM - 6:00 PM</span>
                            <span><i class="fa-solid fa-location-dot"></i> Willen Lake Sports Ground</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="activity-card">
                        <div class="img-container mb-3">
                            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80" alt="Cultural">
                            <span class="category-tag tag-cultural"><i class="fa-solid fa-tag me-1"></i> cultural</span>
                            <div class="activity-date">
                                <span class="d-block fw-bold fs-5">14</span>
                                <span class="month-year">APR 2026</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">Pohela Boishakh Celebration 2026</h5>
                        <p class="text-muted small mb-3">Celebrate the Bengali New Year with music, dance, food and family fun!</p>
                        <div class="meta-info">
                            <span><i class="fa-regular fa-calendar-check"></i> 12:00 PM - 8:00 PM</span>
                            <span><i class="fa-solid fa-location-dot"></i> Campbell Park, Milton Keynes</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="activity-card">
                        <div class="img-container mb-3">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80" alt="Educational">
                            <span class="category-tag tag-educational"><i class="fa-solid fa-tag me-1"></i> educational</span>
                            <div class="activity-date">
                                <span class="d-block fw-bold fs-5">05</span>
                                <span class="month-year">APR 2026</span>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2">Youth Education Workshop</h5>
                        <p class="text-muted small mb-3">Education and career support workshop for young community members.</p>
                        <div class="meta-info">
                            <span><i class="fa-regular fa-calendar-check"></i> 10:00 AM - 4:00 PM</span>
                            <span><i class="fa-solid fa-location-dot"></i> MK Library, Central Milton Keynes</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <a href="event.html" class="btn btn-view-all px-5 py-2 rounded-pill fw-bold">
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
            <a href="contact.html" class="btn btn-danger px-4 py-2 rounded-pill fw-bold btn-cta-red">
                Get in Touch <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>


@endsection