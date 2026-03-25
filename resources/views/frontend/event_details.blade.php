@extends('frontend.layouts.master')

@section('content')



    <header class="event-hero">
        <div class="container">
            <h1>Event Details</h1>
        </div>
    </header>

    <main class="container my-5 py-4">
        <div class="event-container">
            
            <a href="event.html" class="back-link">
                <i class="bi bi-arrow-left me-2"></i> Back to Events
            </a>

            <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&q=80&w=1200" alt="Pohela Boishakh" class="event-img">

            <div class="mb-3">
                <span class="badge-custom bg-cultural">cultural</span>
                <span class="badge-custom bg-upcoming">Upcoming</span>
            </div>

            <h2 class="event-title">Pohela Boishakh Celebration 2026</h2>

            <div class="meta-row">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    Tuesday, 14 April 2026
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    12:00 PM - 8:00 PM
                </div>
                <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    Campbell Park, Milton Keynes
                </div>
            </div>

            <hr>

            <div class="event-description">
                <p>Join us for a vibrant celebration of the Bengali New Year! Featuring traditional music, dance performances, food stalls, and cultural activities for the whole family. This is one of our biggest annual events that brings the entire community together.</p>
            </div>

        </div>
    </main>


@endsection