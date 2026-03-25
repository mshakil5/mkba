@extends('frontend.layouts.master')

@section('content')



    <section class="gallery-hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Our Gallery</h1>
            <p class="opacity-75 lead">Capturing beautiful moments from our community events</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <div class="d-inline-flex bg-white p-2 rounded-3 shadow-sm">
                    <button class="btn btn-sm px-4 fw-bold text-success">All</button>
                    <button class="btn btn-sm px-4 fw-bold text-muted">Cultural</button>
                    <button class="btn btn-sm px-4 fw-bold text-muted">Sports</button>
                    <button class="btn btn-sm px-4 fw-bold text-muted">Social</button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#lightboxModal" onclick="showImage(this)">
                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800" alt="Cultural Event">
                        <div class="gallery-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#lightboxModal" onclick="showImage(this)">
                        <img src="https://images.unsplash.com/photo-1531415074968-036ba1b575da?auto=format&fit=crop&w=800" alt="Cricket Match">
                        <div class="gallery-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#lightboxModal" onclick="showImage(this)">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800" alt="New Year Celebration">
                        <div class="gallery-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#lightboxModal" onclick="showImage(this)">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800" alt="Youth Workshop">
                        <div class="gallery-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>
                        </div>
                    </div>
                </div>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(element) {
            const imgSrc = element.querySelector('img').src;
            document.getElementById('lightboxImage').src = imgSrc;
        }
    </script>

    
@endsection