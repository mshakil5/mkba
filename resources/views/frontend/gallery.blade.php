@extends('frontend.layouts.master')

@section('content')
    
    <style>
        :root {
            --primary-green: #00684a;
            --accent-red: #ff4d4d;
            --text-dark: #0a1d37;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text-dark);
        }

        /* --- Hero Section --- */
        .gallery-hero {
            height: 300px;
            background: linear-gradient(rgba(0, 50, 30, 0.8), rgba(0, 50, 30, 0.8)), 
                        url('https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        /* --- Gallery Grid --- */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            aspect-ratio: 1 / 1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 104, 74, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .zoom-icon {
            color: white;
            font-size: 2rem;
            transform: translateY(20px);
            transition: 0.3s ease;
        }

        .gallery-item:hover .zoom-icon {
            transform: translateY(0);
        }

        /* --- Custom Modal (Lightbox) --- */
        .modal-content {
            background-color: transparent;
            border: none;
        }
        .modal-body {
            padding: 0;
            position: relative;
        }
        .btn-close-white {
            position: absolute;
            top: -40px;
            right: 0;
            filter: invert(1);
            opacity: 1;
        }
        #lightboxImage {
            max-height: 85vh;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
    </style>


    <section class="gallery-hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Our Gallery</h1>
            <p class="opacity-75 lead">Capturing beautiful moments from our community events</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <div class="d-inline-flex bg-white p-2 rounded-3 shadow-sm flex-wrap">

                    <button class="btn btn-sm px-4 fw-bold text-success filter-btn" data-filter="all">
                        All
                    </button>

                    @foreach($categories as $cat)
                        <button class="btn btn-sm px-4 fw-bold text-muted filter-btn" data-filter="cat-{{ $cat }}">
                            Category {{ $cat }}
                        </button>
                    @endforeach

                </div>
            </div>

            <div class="row g-4" id="galleryContainer">
                @foreach($images as $image)
                    <div class="col-6 col-md-4 col-lg-3 gallery-col cat-{{ $image->category_id }}">
                        <div class="gallery-item" 
                            data-bs-toggle="modal" 
                            data-bs-target="#lightboxModal" 
                            onclick="showImage(this)">
                            
                            <img src="{{ asset($image->image) }}" alt="Gallery Image">

                            <div class="gallery-overlay">
                                <i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" id="lightboxImage" class="img-fluid" alt="Enlarged view">
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function () {

                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('text-success');
                        btn.classList.add('text-muted');
                    });

                    this.classList.add('text-success');

                    let filter = this.getAttribute('data-filter');
                    let items = document.querySelectorAll('.gallery-col');

                    items.forEach(item => {
                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else {
                            item.style.display = item.classList.contains(filter) ? 'block' : 'none';
                        }
                    });
                });
            });

        });


        function showImage(element) {
            let img = element.querySelector('img');
            console.log(img.src); // check in browser console

            document.getElementById('lightboxImage').src = img.src;
        }


    </script>

    
@endsection