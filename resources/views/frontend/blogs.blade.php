@extends('frontend.layouts.master')

@section('content')

    <header class="blog-hero">
        <div class="container">
            <h1>Blog</h1>
            <p>News, stories, and updates from our community</p>
        </div>
    </header>

    <main class="container my-5 py-4">
        <div class="row g-4">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <a href="blog-details.html">
                        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=800" class="card-img-top" alt="Community">
                    </a>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge-custom bg-community">community</span>
                            <span class="post-date">12 Mar 2026</span>
                        </div>
                        <h5 class="card-title">
                            <a href="blog-details.html" class="text-decoration-none text-dark hover-link">Celebrating 20 Years of MKBA</a>
                        </h5>
                        <p class="card-text">This year marks a special milestone — 20 years of serving the Bangladeshi community in Milton Keynes.</p>
                        <div class="author-info">
                            <i class="bi bi-person"></i> MKBA Editorial Team
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <a href="blog-details.html">
                        <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&q=80&w=800" class="card-img-top" alt="Announcement">
                    </a>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge-custom bg-announcement">announcement</span>
                            <span class="post-date">12 Mar 2026</span>
                        </div>
                        <h5 class="card-title">
                            <a href="blog-details.html" class="text-decoration-none text-dark hover-link">Bengali Language Classes Now Open for Registration</a>
                        </h5>
                        <p class="card-text">Registration is now open for Bengali language classes for children and adults.</p>
                        <div class="author-info">
                            <i class="bi bi-person"></i> Education Committee
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <a href="blog-details.html">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&q=80&w=800" class="card-img-top" alt="Culture">
                    </a>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge-custom bg-culture">culture</span>
                            <span class="post-date">12 Mar 2026</span>
                        </div>
                        <h5 class="card-title">
                            <a href="blog-details.html" class="text-decoration-none text-success hover-link">Preserving Our Cultural Heritage in the UK</a>
                        </h5>
                        <p class="card-text">How MKBA is working to preserve Bangladeshi culture and traditions for future generations.</p>
                        <div class="author-info">
                            <i class="bi bi-person"></i> Cultural Affairs Team
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>




@endsection