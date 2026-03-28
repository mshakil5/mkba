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




@endsection