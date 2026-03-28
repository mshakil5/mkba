@extends('frontend.layouts.master')

@section('content')




    <section class="section-padding" style="background-color: #fcfdfd; padding: 80px 0;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="subtitle" style="color: #ff4d4d; letter-spacing: 2px; font-weight: 700; font-size: 0.8rem;">WHAT WE DO</span>
                <h2 class="fw-bold" style="color: #0a1d37; font-size: 2.5rem;">Our Activities</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">From cultural celebrations to educational workshops, we organize diverse activities that bring our community together.</p>
            </div>

            <div class="row g-4">
                @forelse($activities as $activity)
                    <div class="col-sm-6 col-lg-4">
                        <div class="activity-card">
                            <div class="img-container mb-3">
                                <img src="{{ asset($activity->image) }}" alt="{{ $activity->title }}">
                                
                                {{-- Dynamic Category Class --}}
                                @php 
                                    $catClass = 'tag-default';
                                    $cat = strtolower($activity->category);
                                    if(str_contains($cat, 'sport')) $catClass = 'tag-sports';
                                    elseif(str_contains($cat, 'cultur')) $catClass = 'tag-cultural';
                                    elseif(str_contains($cat, 'edu')) $catClass = 'tag-educational';
                                @endphp
                                
                                <span class="category-tag {{ $catClass }}">
                                    <i class="fa-solid fa-tag me-1"></i> {{ $activity->category }}
                                </span>

                                <div class="activity-date">
                                    <span class="d-block fw-bold fs-5">{{ date('d', strtotime($activity->activity_date)) }}</span>
                                    <span class="month-year">{{ date('M Y', strtotime($activity->activity_date)) }}</span>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-2" style="color: #0a1d37;">{{ $activity->title }}</h5>
                            
                            <p class="text-muted small mb-3">
                                {{ Str::limit(strip_tags($activity->description), 100) }}
                            </p>

                            <div class="meta-info">
                                <span><i class="fa-regular fa-clock"></i> {{ $activity->time_range }}</span>
                                <span><i class="fa-solid fa-location-dot"></i> {{ $activity->location }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No activities scheduled at the moment. Check back soon!</p>
                    </div>
                @endforelse
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