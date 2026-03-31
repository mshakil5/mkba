@extends('frontend.layouts.master')

@section('title', $banner->meta_title ?? 'About Us')

@section('meta')
<meta name="title" content="{{ $banner->meta_title ?? 'About Us' }}">
<meta name="description" content="{{ $banner->meta_description ?? 'Learn more about our organization' }}">
<meta name="keywords" content="{{ $banner->meta_keywords ?? 'about, mission, vision' }}">
@endsection

@section('content')

<section class="about-hero text-center text-white d-flex align-items-center" 
         style="height: 350px; background: linear-gradient(rgba(0, 104, 74, 0.85), rgba(0, 104, 74, 0.85)), url('{{ $banner->image ? asset($banner->image) : asset($about->image) }}'); background-size: cover; background-position: center;">
    <div class="container">
        <h1 class="fw-bold display-4">{{ $banner->long_title ?? 'About Us' }}</h1>
        <p class="opacity-75 lead">{{ $banner->short_description ?? '' }}</p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-uppercase fw-bold" style="color: #f39c12; font-size: 0.8rem; letter-spacing: 2px;">{{ $about->subtitle }}</span>
                <h2 class="fw-bold mb-4" style="color: #0a1d37; font-size: 2.5rem;">{{ $about->title }}</h2>
                <div class="text-muted lh-lg">
                    {!! $about->description !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset($about->image) }}" alt="About MKBA" class="img-fluid rounded-4 shadow-lg">
                    <div class="position-absolute bottom-0 start-0 translate-middle-x bg-danger p-3 rounded-4 d-none d-md-block" style="width: 80px; height: 80px; z-index: -1;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center hover-lift">
                    <div class="icon-circle mx-auto mb-3" style="background: #e6f0ed; color: #00684a;">
                        <i class="fa-solid fa-bullseye fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Our Mission</h5>
                    <p class="text-muted small">{{ $about->mission }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center hover-lift">
                    <div class="icon-circle mx-auto mb-3" style="background: #e6f0ed; color: #00684a;">
                        <i class="fa-solid fa-eye fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Our Vision</h5>
                    <p class="text-muted small">{{ $about->vision }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center hover-lift">
                    <div class="icon-circle mx-auto mb-3" style="background: #e6f0ed; color: #00684a;">
                        <i class="fa-solid fa-heart fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Our Values</h5>
                    <p class="text-muted small">{{ $about->values }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding" style="background-color: #fcfdfd;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase fw-bold" style="color: #f39c12; font-size: 0.8rem; letter-spacing: 2px;">OUR JOURNEY</span>
            <h2 class="fw-bold" style="color: #0a1d37;">Our Story</h2>
        </div>

        <div class="timeline-container mx-auto" style="max-width: 800px;">
            @foreach($timelines as $timeline)
                <div class="timeline-item d-flex mb-5">
                    <div class="timeline-icon-wrap me-4">
                        <div class="timeline-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        @if(!$loop->last)
                            <div class="timeline-line"></div>
                        @endif
                    </div>
                    <div>
                        <span class="timeline-label">{{ $timeline->label }}</span>
                        <h5 class="fw-bold mb-2">{{ $timeline->title }}</h5>
                        <p class="text-muted small mb-0">{{ $timeline->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    /* General Helpers */
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }

    /* Timeline Styling */
    .timeline-icon-wrap {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .timeline-icon {
        width: 45px;
        height: 45px;
        background: #00684a;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-size: 1.1rem;
        z-index: 2;
    }
    .timeline-line {
        position: absolute;
        top: 45px;
        bottom: -48px; /* Adjusted to reach next icon */
        width: 2px;
        background: #e0e0e0;
        z-index: 1;
    }
    .timeline-label {
        color: #f39c12;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .about-hero { height: 250px; }
        .about-hero h1 { font-size: 2.5rem; }
    }
</style>






@endsection