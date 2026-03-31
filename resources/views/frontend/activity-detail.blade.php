@extends('frontend.layouts.master')

@section('title', $activity->title)

@section('content')

{{-- Hero Banner --}}
<div class="act-detail-hero" style="background-image: url('{{ asset($activity->image) }}');">
    <div class="act-detail-hero__overlay"></div>
    <div class="container h-100 d-flex align-items-end pb-5">
        <div class="act-detail-hero__meta">
            <span class="act-detail-category tag-{{ strtolower($activity->category) }}">
                <i class="fa-solid fa-tag me-1"></i> {{ $activity->category }}
            </span>
            <h1 class="act-detail-title mt-3">{{ $activity->title }}</h1>
        </div>
    </div>
</div>

{{-- Content --}}
<section class="act-detail-body">
    <div class="container">
        <div class="row g-5">

            {{-- Left: Description --}}
            <div class="col-lg-8">
                <div class="act-detail-card">
                    <h4 class="act-detail-section-title">About This Activity</h4>
                    <div class="act-detail-description">
                        {!! nl2br(e($activity->description)) !!}
                    </div>
                </div>
            </div>

            {{-- Right: Info sidebar --}}
            <div class="col-lg-4">
                <div class="act-detail-card act-detail-sidebar">
                    <h5 class="act-detail-section-title">Details</h5>

                    <ul class="act-detail-info-list">
                        <li>
                            <div class="act-detail-info-icon">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <div>
                                <span class="act-detail-info-label">Date</span>
                                <span class="act-detail-info-value">
                                    {{ date('d F Y', strtotime($activity->activity_date)) }}
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="act-detail-info-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <span class="act-detail-info-label">Time</span>
                                <span class="act-detail-info-value">{{ $activity->time_range }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="act-detail-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="act-detail-info-label">Location</span>
                                <span class="act-detail-info-value">{{ $activity->location }}</span>
                            </div>
                        </li>
                    </ul>

                    <a href="{{ route('frontend.activities') }}" class="act-detail-back-btn mt-4">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Activities
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* ── Hero ───────────────────────────────── */
.act-detail-hero {
    height: 480px;
    background-size: cover;
    background-position: center;
    position: relative;
}
.act-detail-hero__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.15) 60%);
}
.act-detail-hero__meta { position: relative; z-index: 2; }
.act-detail-title {
    font-size: clamp(1.8rem, 4vw, 3rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    text-shadow: 0 2px 12px rgba(0,0,0,0.4);
}
.act-detail-category {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: lowercase;
}

/* reuse existing tag colors */
.tag-sports     { background: #fef3e7; color: #b45309; }
.tag-cultural   { background: #f3e8ff; color: #7e22ce; }
.tag-educational{ background: #dbeafe; color: #1d4ed8; }
.tag-religious  { background: #d1fae5; color: #047857; }

/* ── Body section ───────────────────────── */
.act-detail-body {
    background: #F3F8F7;
    padding: 60px 0;
}

/* ── Cards ──────────────────────────────── */
.act-detail-card {
    background: #fff;
    border-radius: 16px;
    padding: 36px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}

.act-detail-section-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0a1d37;
    padding-bottom: 12px;
    margin-bottom: 20px;
    border-bottom: 2px solid #F3F8F7;
}

.act-detail-description {
    font-size: 1rem;
    color: #444;
    line-height: 1.85;
}

/* ── Sidebar info list ───────────────────── */
.act-detail-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.act-detail-info-list li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.act-detail-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #F3F8F7;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #00684a;
    font-size: 1rem;
}
.act-detail-info-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #999;
    margin-bottom: 2px;
}
.act-detail-info-value {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    color: #0a1d37;
}

/* ── Back button ─────────────────────────── */
.act-detail-back-btn {
    display: inline-flex;
    align-items: center;
    width: 100%;
    justify-content: center;
    padding: 0.7rem 1.5rem;
    background: #004a35;
    color: #fff;
    border-radius: 50px;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
}
.act-detail-back-btn:hover {
    background: #00684a;
    color: #fff;
    transform: translateY(-2px);
}
</style>

@endsection