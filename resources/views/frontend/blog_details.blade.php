@extends('frontend.layouts.master')

@section('content')


    <style>
        body {
            font-family: 'Manrope', sans-serif; /* Consistent with your font-link */
            background-color: #ffffff;
            color: #333;
        }

        /* Hero Header adapted for Blog */
        .blog-hero {
            background: linear-gradient(rgba(10, 58, 45, 0.85), rgba(10, 58, 45, 0.85)), 
                        url('{{ asset($blog->image) }}');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        /* Dynamic category badge colors */
        .bg-community { background-color: #e6f4ea; color: #00684a; }
        .bg-news { background-color: #e0f2fe; color: #0369a1; }
        .bg-event { background-color: #fef3c7; color: #92400e; }






        .blog-hero h1 { font-weight: 800; font-size: 2.5rem; }

        /* Content Container */
        .blog-container { max-width: 800px; margin: 0 auto; }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #00684a;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 25px;
            transition: 0.3s;
        }
        .back-link:hover { color: #ff4d4d; }

        /* Featured Image */
        .featured-img {
            width: 100%;
            height: auto;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }

        /* Badges */
        .badge-custom {
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .bg-community { background-color: #e6f4ea; color: #00684a; }

        .blog-title {
            font-weight: 800;
            font-size: 2.8rem;
            color: #0a1d37;
            margin: 20px 0;
            line-height: 1.2;
        }

        /* Metadata Row */
        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: #64748b;
        }

        .meta-item i {
            color: #ff4d4d;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Article Content */
        .blog-content {
            font-size: 1.1rem;
            color: #475569;
            line-height: 1.9;
        }
        
        .blog-content p { margin-bottom: 25px; }

        @media (max-width: 768px) {
            .blog-title { font-size: 2rem; }
            .blog-hero { padding: 60px 0; }
        }
    </style>


    <header class="blog-hero">
        <div class="container">
            <h1>{{ $blog->title }}</h1>
        </div>
    </header>

    <main class="container my-5 py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-container">
                    <a href="{{ route('frontend.blogs') }}" class="back-link">
                        <i class="bi bi-arrow-left me-2"></i> Back to All Stories
                    </a>

                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="featured-img">

                    <div class="mb-3">
                        <span class="badge-custom bg-{{ strtolower($blog->category) }}">
                            {{ $blog->category }}
                        </span>
                    </div>

                    <h2 class="blog-title">{{ $blog->title }}</h2>

                    <div class="meta-row">
                        <div class="meta-item">
                            <i class="bi bi-person-circle"></i>
                            {{ $blog->author ?? 'MKBA Team' }}
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            {{ date('d M Y', strtotime($blog->post_date)) }}
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-clock"></i>
                            @php
                                $wordCount = str_word_count(strip_tags($blog->description ?? $blog->summary));
                                $minutes = ceil($wordCount / 200); // Average 200 wpm
                            @endphp
                            {{ $minutes }} Min Read
                        </div>
                    </div>

                    <article class="blog-content">
                        @if($blog->summary)
                            <p class="lead fw-bold" style="color: #0a1d37;">{{ $blog->summary }}</p>
                        @endif

                        @if($blog->description)
                            {!! $blog->description !!}
                        @else
                            <p class="text-muted italic">Full article content is coming soon.</p>
                        @endif
                    </article>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ps-lg-4 mt-5 mt-lg-0">
                    <h4 class="fw-bold mb-4" style="color: #0a1d37;">Recent Stories</h4>
                    @foreach($recentBlogs as $recent)
                        <div class="d-flex mb-4 align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset($recent->image) }}" class="rounded-3" alt="..." style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">
                                    <a href="{{ route('blog.details', $recent->slug) }}" class="text-decoration-none text-dark hover-red">
                                        {{ Str::limit($recent->title, 45) }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ date('d M, Y', strtotime($recent->post_date)) }}</small>
                            </div>
                        </div>
                    @endforeach
                    
                    <hr class="my-4">
                    
                    @if($blog->meta_keywords)
                        <h5 class="fw-bold mb-3">Tags</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $blog->meta_keywords) as $tag)
                                <span class="badge bg-light text-secondary border p-2">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

@endsection