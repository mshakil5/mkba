
    @php
        $company = App\Models\CompanyDetails::select('company_name', 'business_name' , 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','company_logo','copyright','google_map')->first();
    @endphp


<footer class="footer-main text-white pt-5 pb-3" style="background-color: #003d2b;">
    <div class="container">
        <div class="row g-4 pb-5 border-bottom border-secondary border-opacity-25">
            <div class="col-lg-3 col-md-6">
                <div class="footer-logo mb-3">
                    <div class="bg-white p-2 rounded d-inline-block">
                        {{-- Dynamic Logo --}}
                        <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }}" style="max-width: 120px;">
                    </div>
                </div>
                {{-- Dynamic Footer Content/About --}}
                <div class="small opacity-75 lh-base">
                    {!! $company->footer_content !!}
                </div>
            </div>

            <div class="col-lg-2 col-md-6 ms-lg-auto">
                <h6 class="footer-heading mb-4 text-danger text-uppercase fw-bold small">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Home</a></li>
                    <li><a href="{{ route('frontend.about') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> About</a></li>
                    <li><a href="{{ route('frontend.events') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Events</a></li>
                    <li><a href="{{ route('frontend.gallery') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Gallery</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading mb-4 text-danger text-uppercase fw-bold small">More Pages</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('frontend.blogs') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Blog</a></li>
                    <li><a href="{{ route('frontend.trustee') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Trustees</a></li>
                    <li><a href="{{ route('frontend.contact') }}"><i class="fa-solid fa-circle me-2" style="font-size: 0.4rem;"></i> Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading mb-4 text-danger text-uppercase fw-bold small">Get in Touch</h6>
                <ul class="list-unstyled contact-info">
                    <li class="d-flex align-items-start mb-3">
                        <i class="fa-solid fa-location-dot mt-1 me-3 text-white-50"></i>
                        <span class="small opacity-75">{{ $company->address1 }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-envelope me-3 text-white-50"></i>
                        <a href="mailto:{{ $company->email1 }}" class="small opacity-75 text-decoration-none text-white">{{ $company->email1 }}</a>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fa-solid fa-phone me-3 text-white-50"></i>
                        <span class="small opacity-75">{{ $company->phone1 }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row pt-4 align-items-center">
            <div class="col-md-6 text-center text-md-start">
                {{-- Dynamic Copyright --}}
                <p class="small opacity-50 mb-0">&copy; {{ date('Y') }} {{ $company->copyright }}.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                {{-- Dynamic Social Links --}}
                @if($company->facebook)
                    <a href="{{ $company->facebook }}" target="_blank" class="social-icon-btn me-2"><i class="fa-brands fa-facebook-f"></i></a>
                @endif
                @if($company->twitter)
                    <a href="{{ $company->twitter }}" target="_blank" class="social-icon-btn me-2"><i class="fa-brands fa-twitter"></i></a>
                @endif
                @if($company->linkedin)
                    <a href="{{ $company->linkedin }}" target="_blank" class="social-icon-btn me-2"><i class="fa-brands fa-linkedin-in"></i></a>
                @endif
                <a href="mailto:{{ $company->email1 }}" class="social-icon-btn"><i class="fa-solid fa-envelope"></i></a>
            </div>
        </div>
    </div>
</footer>