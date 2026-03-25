@extends('frontend.layouts.master')

@section('content')




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



@endsection