@extends('frontend.layouts.master')
@section('title', 'Contact Us')

@section('meta')
<meta name="title" content="Contact Us">
<meta name="description" content="Get in touch with us for any queries or support">
<meta name="keywords" content="contact, support, help">
@endsection

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Hero Section */
        .contact-hero {
            background: linear-gradient(rgba(10, 58, 45, 0.9), rgba(10, 58, 45, 0.9)), 
                        url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
            text-align: center;
        }

        .contact-hero h1 { font-weight: 700; font-size: 3rem; }
        .contact-hero p { color: #a4c5bc; font-size: 1.1rem; }

        /* Left Side Info */
        .label-orange {
            color: #f59e0b;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .section-title {
            color: #0f172a;
            font-weight: 700;
            margin: 10px 0 20px 0;
        }

        .contact-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Contact Detail Items */
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .icon-box {
            width: 44px;
            height: 44px;
            background-color: #e6f7ef;
            color: #10b981;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .item-content h6 {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 2px;
            color: #1e293b;
        }

        .item-content p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
        }

        /* Form Card */
        .form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-send {
            background-color: #047857;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: background 0.3s;
        }

        .btn-send:hover {
            background-color: #065f46;
            color: white;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .form-card { margin-top: 40px; padding: 25px; }
        }
    </style>

    <header class="contact-hero">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you. Get in touch with MKBA.</p>
        </div>
    </header>

    <main class="container my-5 py-5">
        <div class="row align-items-center">
            
            <div class="col-lg-5 pe-lg-5">
                <span class="label-orange">REACH OUT</span>
                <h2 class="section-title h1">Get in Touch</h2>
                <p class="contact-desc">
                    Whether you have a question, want to volunteer, or need support — we're here for you. Reach out and a member of our team will get back to you shortly.
                </p>

                <div class="contact-item">
                    <div class="icon-box"><i class="bi bi-geo-alt"></i></div>
                    <div class="item-content">
                        <h6>Address</h6>
                        <p>{{ $company->address1 }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box"><i class="bi bi-envelope"></i></div>
                    <div class="item-content">
                        <h6>Email</h6>
                        <p>{{ $company->email1 }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box"><i class="bi bi-telephone"></i></div>
                    <div class="item-content">
                        <h6>Phone</h6>
                        <p>{{ $company->phone1 }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box"><i class="bi bi-clock"></i></div>
                    <div class="item-content">
                        <h6>Office Hours</h6>
                        <p>Mon-Fri: 10am – 6pm</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="form-card">


                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                                @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-send">
                                    <i class="bi bi-send me-2"></i> Send Message
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>




@endsection