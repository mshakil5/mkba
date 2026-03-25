@extends('frontend.layouts.master')

@section('content')



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
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Upcoming</button>
                    <button class="filter-btn">Ongoing</button>
                    <button class="filter-btn">Past</button>
                </div>
            </div>

            <div class="row g-4 mt-2">
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
        </div>
    </section>



@endsection