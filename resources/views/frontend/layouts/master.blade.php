<!DOCTYPE html>
<html lang="en">
<head>


    @php
        $company = App\Models\CompanyDetails::select('company_name', 'business_name' , 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','company_logo','copyright','google_map')->first();
    @endphp



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <title>{{ $company->meta_title ?? $company->company_name }}</title>

    <meta name="title" content="MKBA - Building Bridges, Enriching Lives">
    <meta name="description" content="MKBA is dedicated to building bridges and enriching lives through community development, cultural exchange, and social impact initiatives. Join us today.">
    <meta name="keywords" content="MKBA, community building, social impact, cultural exchange, non-profit, development">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <link rel="canonical" href="https://mkba.uk/">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mkba.uk/">
    <meta property="og:title" content="MKBA - Building Bridges, Enriching Lives">
    <meta property="og:description" content="Empowering communities through connection and social initiatives.">
    <meta property="og:image" content="https://mkba.uk/images/og-image.jpg">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mkba.uk/">
    <meta property="twitter:title" content="MKBA - Building Bridges, Enriching Lives">
    <meta property="twitter:description" content="Empowering communities through connection and social initiatives.">
    <meta property="twitter:image" content="https://mkba.uk/images/og-image.jpg">

    <!-- Favicon -->
    <link href="{{ asset('images/company/' . $company->fav_icon) }}" rel="icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/company/' . $company->fav_icon) }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link href="{{ asset('resources/frontend/css/main.css') }}" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">

</head>
<body>



    

    @include('frontend.inc.header')

    @yield('content')

    @include('frontend.cookies')

    @include('frontend.inc.footer')




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>






    
        @yield('script')



</body>
</html>