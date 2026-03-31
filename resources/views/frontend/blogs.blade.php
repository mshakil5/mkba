@extends('frontend.layouts.master')

@section('title', $banner->meta_title ?? 'Blog')

@section('meta')
<meta name="title" content="{{ $banner->meta_title ?? 'Blog' }}">
<meta name="description" content="{{ $banner->meta_description ?? 'News, stories, and updates from our community' }}">
<meta name="keywords" content="{{ $banner->meta_keywords ?? 'blog, news, stories, updates' }}">
@endsection

@section('content')

    <header class="blog-hero" style="background: linear-gradient(rgba(10, 58, 45, 0.9), rgba(10, 58, 45, 0.9)), url('{{ $banner->image ? asset($banner->image) : "https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&q=80&w=2000" }}'); background-size: cover; background-position: center;">
        <div class="container">
            <h1>{{ $banner->long_title ?? 'Blog' }}</h1>
            <p>{{ $banner->short_description ?? 'News, stories, and updates from our community' }}</p>
        </div>
    </header>

    <main class="container my-5 py-4">
        
        <div class="row g-4">
            @foreach($blogs as $blog)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card blog-card h-100">

                        <a href="{{ route('blog.details', $blog->slug) }}">
                            <img src="{{ asset($blog->image) }}" 
                                class="card-img-top" 
                                alt="{{ $blog->title }}">
                        </a>

                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge-custom bg-community">
                                    {{ $blog->category }}
                                </span>

                                <span class="post-date">
                                    {{ \Carbon\Carbon::parse($blog->post_date)->format('d M Y') }}
                                </span>
                            </div>

                            <h5 class="card-title">
                                <a href="{{ route('blog.details', $blog->slug) }}" 
                                class="text-decoration-none text-dark hover-link">
                                    {{ $blog->title }}
                                </a>
                            </h5>

                            <p class="card-text">
                                {{ $blog->summary }}
                            </p>

                            <div class="author-info">
                                <i class="bi bi-person"></i> {{ $blog->author }}
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </main>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Hero Section */
        .blog-hero {
            padding: 100px 0;
            color: white;
            text-align: center;
        }

        .blog-hero h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .blog-hero p {
            color: #a4c5bc;
            font-weight: 300;
            font-size: 1.1rem;
        }

        /* Card Styling */
        .blog-card {
            border: none;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            border-radius: 15px;
            height: 220px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px 0;
        }

        /* Badges */
        .badge-custom {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 10px;
            text-transform: lowercase;
        }

        .bg-community { background-color: #e6f7ef; color: #2d8a5f; }
        .bg-announcement { background-color: #fff9e6; color: #b08900; }
        .bg-culture { background-color: #f3eafa; color: #7b4eb3; }

        .post-date {
            font-size: 0.85rem;
            color: #999;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin: 15px 0 10px 0;
            color: #1a1a1a;
            line-height: 1.3;
        }

        .card-text {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .author-info {
            font-size: 0.8rem;
            color: #888;
            display: flex;
            align-items: center;
        }

        .author-info i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .blog-hero h1 { font-size: 2.2rem; }
            .card-img-top { height: 200px; }
        }


        /* Allow cards to have equal height */
        .blog-card {
            transition: transform 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        /* Hover effect for the title links */
        .hover-link:hover {
            color: #ff4d4d !important; /* Changes to red on hover */
            text-decoration: underline !important;
        }


    </style>



@endsection