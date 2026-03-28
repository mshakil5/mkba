@extends('frontend.layouts.master')

@section('content')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Shared Hero Section */
        .hero-section {
            background: linear-gradient(rgba(10, 58, 45, 0.9), rgba(10, 58, 45, 0.9)), 
                        url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            color: white;
            text-align: center;
        }

        .hero-section h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .hero-section p {
            color: #4ade80; /* Light teal/green from design */
            font-weight: 400;
            font-size: 1.1rem;
        }

        /* Content Headers */
        .label-orange {
            color: #f59e0b;
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .main-title {
            color: #0f172a;
            font-weight: 700;
            margin: 10px 0 20px 0;
        }

        .intro-text {
            color: #64748b;
            max-width: 700px;
            margin: 0 auto 60px auto;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Trustee Card Styling */
        .trustee-card {
            text-align: center;
            margin-bottom: 40px;
        }

        .initial-box {
            width: 140px;
            height: 140px;
            background-color: #065f46; /* Dark green */
            color: white;
            font-size: 3rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 25px auto;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .trustee-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .trustee-role {
            color: #059669;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: block;
        }

        .trustee-bio {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.6;
            padding: 0 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section { padding: 80px 0; }
            .hero-section h1 { font-size: 2.2rem; }
            .initial-box { width: 120px; height: 120px; font-size: 2.5rem; }
        }
    </style>

    <header class="hero-section">
        <div class="container">
            <h1>Our Trustees</h1>
            <p>Meet the dedicated team leading our community</p>
        </div>
    </header>

    <section class="container my-5 py-5 text-center">
        <span class="label-orange">LEADERSHIP</span>
        <h2 class="main-title h1">Board of Trustees</h2>
        <p class="intro-text">
            Our trustees volunteer their time and expertise to guide the association and serve the community with dedication and integrity.
        </p>

        <div class="row g-4">
            @foreach($trustees as $trustee)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="trustee-card">

                        @php
                            $words = explode(' ', $trustee->name);
                            $initials = strtoupper(substr($words[0],0,1) . (isset($words[1]) ? substr($words[1],0,1) : ''));
                        @endphp

                        <div class="initial-box">
                            {{ $initials }}
                        </div>

                        <h3 class="trustee-name">
                            {{ $trustee->name }}
                        </h3>

                        <span class="trustee-role">
                            {{ $trustee->role }}
                        </span>

                        <p class="trustee-bio">
                            {{ \Illuminate\Support\Str::limit($trustee->bio, 120) }}
                        </p>

                    </div>
                </div>
            @endforeach
        </div>
    </section>



@endsection