@extends('frontend.layouts.master')

@section('content')



    <header class="blog-hero">
        <div class="container">
            <h1>Blog Post</h1>
        </div>
    </header>

    <main class="container my-5 py-4">
        <div class="blog-container">
            
            <a href="blog.html" class="back-link">
                <i class="bi bi-arrow-left me-2"></i> Back to All Stories
            </a>

            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200" alt="Celebrating 20 Years" class="featured-img">

            <div class="mb-3">
                <span class="badge-custom bg-community">Community</span>
            </div>

            <h2 class="blog-title">Celebrating 20 Years of MKBA</h2>

            <div class="meta-row">
                <div class="meta-item">
                    <i class="bi bi-person-circle"></i>
                    MKBA Editorial Team
                </div>
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    12 March 2026
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    5 Min Read
                </div>
            </div>

            <article class="blog-content">
                <p class="lead fw-bold" style="color: #0a1d37;">This year marks a special milestone — 20 years of serving the Bangladeshi community in Milton Keynes. From our humble beginnings to becoming a cornerstone of local culture, it has been an incredible journey.</p>
                
                <p>Since our founding, MKBA has worked tirelessly to build bridges between generations and cultures. What started as a small group of families looking to preserve their heritage has grown into a vibrant organization hosting massive festivals, educational workshops, and sporting events.</p>

                <blockquote class="p-4 bg-light border-start border-4 border-success my-4 italic">
                    "Community is not just about where you live, but about how you support those around you. For 20 years, MKBA has been that support system."
                </blockquote>

                <p>As we look forward to the next decade, our focus remains on the youth. By providing language classes and cultural workshops, we ensure that the rich traditions of Bangladesh continue to thrive in the heart of the UK.</p>
            </article>

        </div>
    </main>



@endsection