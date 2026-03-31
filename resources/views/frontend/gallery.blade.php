@extends('frontend.layouts.master')

@section('title', $banner->meta_title ?? 'Gallery')

@section('meta')
<meta name="title" content="{{ $banner->meta_title ?? 'Gallery' }}">
<meta name="description" content="{{ $banner->meta_description ?? 'Browse through our photo gallery' }}">
<meta name="keywords" content="{{ $banner->meta_keywords ?? 'gallery, photos, images' }}">

@section('content')

<style>
    :root {
        --primary-green: #00684a;
        --accent-red:    #ff4d4d;
        --text-dark:     #0a1d37;
    }

    /* ── Hero ───────────────────────────────── */
    /* .gallery-hero {
        height: 300px;
        background: linear-gradient(rgba(0,50,30,0.82), rgba(0,50,30,0.82)),
                    url('https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=1600&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    } */

        .gallery-hero {
            padding: 100px 0;
            color: white;
            text-align: center;
        }

    /* ── Layout ─────────────────────────────── */
    .gallery-wrap {
        display: flex;
        gap: 0;
        min-height: 600px;
        background: #f8f9fa;
    }

    /* ── Left: Album sidebar ─────────────────── */
    .album-sidebar {
        width: 260px;
        flex-shrink: 0;
        background: #fff;
        border-right: 1px solid #e9ecef;
        padding: 1.5rem 0;
        position: sticky;
        top: 0;
        height: fit-content;
    }

    .album-sidebar h6 {
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #999;
        padding: 0 1.25rem 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 0.5rem;
    }

    .album-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.7rem 1.25rem;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: background 0.2s, border-color 0.2s;
    }
    .album-item:hover {
        background: #f8f9fa;
    }
    .album-item.is-active {
        background: #f0faf5;
        border-left-color: var(--primary-green);
    }

    .album-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        background: #e9ecef;
    }
    .album-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #aaa;
        font-size: 1.1rem;
    }

    .album-info { flex: 1; min-width: 0; }
    .album-info strong {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .album-info span {
        font-size: 0.75rem;
        color: #999;
    }
    .album-item.is-active .album-info strong { color: var(--primary-green); }

    /* ── Right: Image grid ───────────────────── */
    .image-panel {
        flex: 1;
        padding: 2rem;
        min-width: 0;
    }

    .image-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .image-panel-header h4 {
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
    }
    .image-count {
        font-size: 0.8rem;
        background: #f0faf5;
        color: var(--primary-green);
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
    }

    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        cursor: pointer;
        aspect-ratio: 1 / 1;
        background: #e9ecef;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
        display: block;
    }
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,104,74,0.65);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 10px;
    }
    .gallery-item:hover img       { transform: scale(1.1); }
    .gallery-item:hover .gallery-overlay { opacity: 1; }

    .zoom-icon {
        color: #fff;
        font-size: 1.6rem;
        transform: translateY(10px);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .zoom-icon { transform: translateY(0); }

    .img-caption-preview {
        color: rgba(255,255,255,0.92);
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        margin-top: 6px;
        max-height: 2.4em;
        overflow: hidden;
    }

    /* ── Empty state ─────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #aaa;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }

    /* ── Lightbox ────────────────────────────── */
    .lightbox-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 1.5rem;
    }
    .lightbox-backdrop.is-open { display: flex; }

    .lightbox-img-wrap {
        position: relative;
        max-width: 880px;
        width: 100%;
        text-align: center;
    }
    .lightbox-img-wrap img {
        max-height: 80vh;
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        display: block;
        margin: 0 auto;
    }
    .lightbox-caption {
        color: rgba(255,255,255,0.85);
        font-size: 0.95rem;
        margin-top: 1rem;
        font-weight: 500;
        text-align: center;
        min-height: 1.4em;
    }
    .lightbox-close {
        position: absolute;
        top: -42px;
        right: 0;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.8rem;
        cursor: pointer;
        opacity: 0.8;
        line-height: 1;
    }
    .lightbox-close:hover { opacity: 1; }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.12);
        border: 1.5px solid rgba(255,255,255,0.25);
        color: #fff;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        transition: background 0.2s;
        backdrop-filter: blur(4px);
    }
    .lightbox-nav:hover { background: var(--primary-green); border-color: var(--primary-green); }
    .lightbox-nav.prev { left: -56px; }
    .lightbox-nav.next { right: -56px; }

    @media (max-width: 768px) {
        .gallery-wrap { flex-direction: column; }
        .album-sidebar { width: 100%; position: static; border-right: none; border-bottom: 1px solid #e9ecef; padding: 1rem 0; display: flex; overflow-x: auto; gap: 0; }
        .album-sidebar h6 { display: none; }
        .album-item { flex-direction: column; text-align: center; gap: 6px; padding: 0.6rem 1rem; border-left: none; border-bottom: 3px solid transparent; min-width: 90px; }
        .album-item.is-active { border-bottom-color: var(--primary-green); border-left-color: transparent; background: #f0faf5; }
        .image-panel { padding: 1.25rem; }
        .images-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
        .lightbox-nav.prev { left: -10px; }
        .lightbox-nav.next { right: -10px; }
    }
</style>


{{-- ── Hero ──────────────────────────────────────── --}}
<section class="gallery-hero text-center" style="background: linear-gradient(rgba(10, 58, 45, 0.9), rgba(10, 58, 45, 0.9)), url('{{ $banner->image ? asset($banner->image) : "https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&q=80&w=2000" }}'); background-size: cover; background-position: center;">
    <div class="container">
        <h1>{{ $banner->long_title ?? 'Gallery' }}</h1>
        <p>{{ $banner->short_description ?? 'Browse through our photo gallery.' }}</p>
    </div>
</section>


{{-- ── Main Layout ───────────────────────────────── --}}
<section class="py-5">
    <div class="container px-0 px-md-4">
        <div class="gallery-wrap rounded-3 overflow-hidden shadow-sm">

            {{-- ── Album Sidebar (Left) ──────────────── --}}
            <aside class="album-sidebar">
                <h6>Albums</h6>
                @foreach($albums as $album)
                    @php $cover = $album->galleries()->orderBy('order_by')->first(); @endphp
                    <div class="album-item {{ $loop->first ? 'is-active' : '' }}"
                         data-album-id="{{ $album->id }}"
                         data-album-name="{{ $album->name }}">

                        @if($cover)
                            <img class="album-thumb" src="{{ asset($cover->image) }}" alt="{{ $album->name }}">
                        @else
                            <div class="album-thumb-placeholder"><i class="ri-image-line"></i></div>
                        @endif

                        <div class="album-info">
                            <strong>{{ $album->name }}</strong>
                            <span>{{ $album->galleries_count }} photo{{ $album->galleries_count != 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                @endforeach
            </aside>

            {{-- ── Image Panel (Right) ───────────────── --}}
            <div class="image-panel">
                <div class="image-panel-header">
                    <h4 id="panelTitle">{{ $albums->first()?->name ?? 'Gallery' }}</h4>
                    <span class="image-count" id="panelCount">0 photos</span>
                </div>

                <div class="images-grid" id="imagesGrid">
                    <div class="empty-state" style="grid-column:1/-1;">
                        <i class="ri-image-line"></i>
                        <p>Select an album to view photos</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ── Lightbox ───────────────────────────────────── --}}
<div class="lightbox-backdrop" id="lightbox">
    <div class="lightbox-img-wrap">
        <button class="lightbox-close" id="lightboxClose">&times;</button>
        <button class="lightbox-nav prev" id="lightboxPrev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="lightbox-nav next" id="lightboxNext"><i class="fa-solid fa-chevron-right"></i></button>
        <img src="" id="lightboxImg" alt="Gallery Image">
    </div>
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>


@endsection

@section('script')
<script>
(function () {
    // All albums data from blade
    var albums = {!! json_encode($albums) !!};

    var currentImages = [];
    var currentIndex  = 0;

    // ── Load album images into grid ──────────────────
    function loadAlbum(albumId, albumName) {
        var album = albums.find(function (a) { return a.id == albumId; });
        if (!album) return;

        currentImages = album.galleries;

        $('#panelTitle').text(albumName);
        $('#panelCount').text(currentImages.length + ' photo' + (currentImages.length !== 1 ? 's' : ''));

        var grid = $('#imagesGrid');
        grid.html('');

        if (currentImages.length === 0) {
            grid.html('<div class="empty-state" style="grid-column:1/-1;"><i class="ri-image-line"></i><p>No photos in this album yet.</p></div>');
            return;
        }

        currentImages.forEach(function (img, index) {
            var caption = img.title ? '<div class="img-caption-preview">' + img.title + '</div>' : '';
            grid.append(
                '<div class="gallery-item" data-index="' + index + '">' +
                    '<img src="/' + img.image + '" alt="' + (img.title || '') + '" loading="lazy">' +
                    '<div class="gallery-overlay">' +
                        '<i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>' +
                        caption +
                    '</div>' +
                '</div>'
            );
        });
    }

    // ── Album click ──────────────────────────────────
    $(document).on('click', '.album-item', function () {
        $('.album-item').removeClass('is-active');
        $(this).addClass('is-active');
        loadAlbum($(this).data('album-id'), $(this).data('album-name'));
    });

    // ── Image click → open lightbox ──────────────────
    $(document).on('click', '.gallery-item', function () {
        openLightbox(parseInt($(this).data('index')));
    });

    function openLightbox(index) {
        currentIndex = index;
        var img = currentImages[currentIndex];
        $('#lightboxImg').attr('src', '/' + img.image);
        $('#lightboxCaption').text(img.title || '');
        $('#lightbox').addClass('is-open');
    }

    function closeLightbox() { $('#lightbox').removeClass('is-open'); }

    function lightboxNav(dir) {
        currentIndex = (currentIndex + dir + currentImages.length) % currentImages.length;
        var img = currentImages[currentIndex];
        $('#lightboxImg').attr('src', '/' + img.image);
        $('#lightboxCaption').text(img.title || '');
    }

    $('#lightboxClose').click(closeLightbox);
    $('#lightboxPrev').click(function () { lightboxNav(-1); });
    $('#lightboxNext').click(function () { lightboxNav(1); });

    // Close on backdrop click
    $('#lightbox').click(function (e) {
        if ($(e.target).is('#lightbox')) closeLightbox();
    });

    // Keyboard nav
    $(document).keydown(function (e) {
        if (!$('#lightbox').hasClass('is-open')) return;
        if (e.key === 'ArrowLeft')  lightboxNav(-1);
        if (e.key === 'ArrowRight') lightboxNav(1);
        if (e.key === 'Escape')     closeLightbox();
    });

    // ── Auto-load first album ────────────────────────
    var first = $('.album-item').first();
    if (first.length) loadAlbum(first.data('album-id'), first.data('album-name'));
})();
</script>
@endsection