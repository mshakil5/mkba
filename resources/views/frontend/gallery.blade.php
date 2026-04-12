@extends('frontend.layouts.master')

@section('title', $banner->meta_title ?? 'Gallery')

@section('meta')
<meta name="title"       content="{{ $banner->meta_title ?? 'Gallery' }}">
<meta name="description" content="{{ $banner->meta_description ?? 'Browse through our gallery' }}">
<meta name="keywords"    content="{{ $banner->meta_keywords ?? 'gallery, photos, videos' }}">
@endsection

@section('content')

<style>
    :root {
        --primary-green: #00684a;
        --accent-red:    #ff4d4d;
        --text-dark:     #0a1d37;
    }

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

    /* ── Album Sidebar ───────────────────────── */
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
    .album-item:hover { background: #f8f9fa; }
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
    .album-info span { font-size: 0.75rem; color: #999; }
    .album-item.is-active .album-info strong { color: var(--primary-green); }

    /* ── Image / Video Grid ──────────────────── */
    .image-panel { flex: 1; padding: 2rem; min-width: 0; }
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

    /* ── Gallery item (shared for image & video) ── */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        cursor: pointer;
        aspect-ratio: 1 / 1;
        background: #1a1a1a;
    }
    .gallery-item img,
    .gallery-item video {
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
    .gallery-item:hover img,
    .gallery-item:hover video    { transform: scale(1.08); }
    .gallery-item:hover .gallery-overlay { opacity: 1; }

    /* Video badge (always visible, bottom-left) */
    .video-badge {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
        backdrop-filter: blur(4px);
        z-index: 2;
        transition: opacity 0.3s;
    }
    .gallery-item:hover .video-badge { opacity: 0; }

    .zoom-icon {
        color: #fff;
        font-size: 1.6rem;
        transform: translateY(10px);
        transition: transform 0.3s ease;
    }
    /* Play icon for video items */
    .play-icon {
        color: #fff;
        font-size: 2rem;
        transform: translateY(10px);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .zoom-icon,
    .gallery-item:hover .play-icon { transform: translateY(0); }

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
    .empty-state { text-align: center; padding: 4rem 2rem; color: #aaa; }
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
        max-width: 900px;
        width: 100%;
        text-align: center;
    }
    /* Shared img + video styles inside lightbox */
    .lightbox-img-wrap img,
    .lightbox-img-wrap video {
        max-height: 80vh;
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        display: block;
        margin: 0 auto;
    }
    .lightbox-img-wrap video { background: #000; width: 100%; }

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
        .album-sidebar {
            width: 100%; position: static;
            border-right: none; border-bottom: 1px solid #e9ecef;
            padding: 1rem 0; display: flex; overflow-x: auto; gap: 0;
        }
        .album-sidebar h6 { display: none; }
        .album-item {
            flex-direction: column; text-align: center; gap: 6px;
            padding: 0.6rem 1rem; border-left: none;
            border-bottom: 3px solid transparent; min-width: 90px;
        }
        .album-item.is-active {
            border-bottom-color: var(--primary-green);
            border-left-color: transparent;
            background: #f0faf5;
        }
        .image-panel { padding: 1.25rem; }
        .images-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
        .lightbox-nav.prev { left: -10px; }
        .lightbox-nav.next { right: -10px; }
    }
</style>


{{-- ── Hero ──────────────────────────────────────── --}}
<section class="gallery-hero" style="background: linear-gradient(rgba(10,58,45,0.9), rgba(10,58,45,0.9)), url('{{ $banner->image ? asset($banner->image) : "https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&q=80&w=2000" }}'); background-size:cover; background-position:center;">
    <div class="container">
        <h1>{{ $banner->long_title ?? 'Gallery' }}</h1>
        <p>{{ $banner->short_description ?? 'Browse through our gallery.' }}</p>
    </div>
</section>


{{-- ── Main Layout ───────────────────────────────── --}}
<section class="py-5">
    <div class="container px-0 px-md-4">
        <div class="gallery-wrap rounded-3 overflow-hidden shadow-sm">

            {{-- ── Album Sidebar ──────────────────────── --}}
            <aside class="album-sidebar">
                <h6>Albums</h6>

                @foreach($albums as $album)
                    @php
                        $videoExts = ['mp4','mov','avi','webm','mkv','ogg'];
                        $cover     = $album->galleries->first();
                        $coverExt  = $cover ? strtolower(pathinfo($cover->image, PATHINFO_EXTENSION)) : '';
                        $coverIsVideo = $cover && (in_array($coverExt, $videoExts) || ($cover->type ?? '') === 'video');

                        // Count images vs videos
                        $totalMedia  = $album->galleries_count;
                        $videoCount  = $album->galleries->filter(function($g) use ($videoExts) {
                            $ext = strtolower(pathinfo($g->image, PATHINFO_EXTENSION));
                            return in_array($ext, $videoExts) || ($g->type ?? '') === 'video';
                        })->count();
                        $imageCount  = $totalMedia - $videoCount;
                    @endphp

                    <div class="album-item {{ $loop->first ? 'is-active' : '' }}"
                         data-album-id="{{ $album->id }}"
                         data-album-name="{{ $album->name }}">

                        {{-- Cover: use logo.png if cover is a video or missing --}}
                        @if($cover && !$coverIsVideo)
                            <img class="album-thumb" src="{{ asset($cover->image) }}" alt="{{ $album->name }}">
                        @elseif($coverIsVideo)
                            {{-- Album has media but first item is a video — use logo --}}
                            <img class="album-thumb" src="{{ asset('logo.webp') }}" alt="{{ $album->name }}"
                                 style="object-fit:contain; padding:4px; background:#f0f0f0;">
                        @else
                            <div class="album-thumb-placeholder"><i class="ri-image-line"></i></div>
                        @endif

                        <div class="album-info">
                            <strong>{{ $album->name }}</strong>
                            <span>
                                @if($imageCount > 0 && $videoCount > 0)
                                    {{ $imageCount }} photo{{ $imageCount != 1 ? 's' : '' }},
                                    {{ $videoCount }} video{{ $videoCount != 1 ? 's' : '' }}
                                @elseif($videoCount > 0)
                                    {{ $videoCount }} video{{ $videoCount != 1 ? 's' : '' }}
                                @else
                                    {{ $imageCount }} photo{{ $imageCount != 1 ? 's' : '' }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </aside>

            {{-- ── Media Panel (Right) ────────────────── --}}
            <div class="image-panel">
                <div class="image-panel-header">
                    <h4 id="panelTitle">{{ $albums->first()?->name ?? 'Gallery' }}</h4>
                    <span class="image-count" id="panelCount">0 media</span>
                </div>

                <div class="images-grid" id="imagesGrid">
                    <div class="empty-state" style="grid-column:1/-1;">
                        <i class="ri-image-line"></i>
                        <p>Select an album to view media</p>
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

        {{-- Image (shown for images) --}}
        <img src="" id="lightboxImg" alt="Gallery Image" style="display:none;">

        {{-- Video (shown for videos) --}}
        <video id="lightboxVideo" controls playsinline style="display:none;">
            <source id="lightboxVideoSrc" src="" type="video/mp4">
        </video>
    </div>
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>


@endsection

@section('script')
<script>
(function () {
    var VIDEO_EXTS = ['mp4','mov','avi','webm','mkv','ogg'];

    function isVideo(item) {
        var ext = (item.image || '').split('.').pop().toLowerCase();
        return VIDEO_EXTS.indexOf(ext) !== -1 || item.type === 'video';
    }

    // Albums data passed from blade
    var albums = {!! json_encode($albums) !!};

    var currentImages = [];
    var currentIndex  = 0;

    // ── Build media count label ──────────────────────
    function mediaLabel(items) {
        var vCount = items.filter(isVideo).length;
        var iCount = items.length - vCount;
        if (iCount > 0 && vCount > 0) {
            return iCount + ' photo' + (iCount !== 1 ? 's' : '') + ', ' + vCount + ' video' + (vCount !== 1 ? 's' : '');
        } else if (vCount > 0) {
            return vCount + ' video' + (vCount !== 1 ? 's' : '');
        }
        return iCount + ' photo' + (iCount !== 1 ? 's' : '');
    }

    // ── Load album into grid ─────────────────────────
    function loadAlbum(albumId, albumName) {
        var album = albums.find(function (a) { return a.id == albumId; });
        if (!album) return;

        currentImages = album.galleries;

        $('#panelTitle').text(albumName);
        $('#panelCount').text(mediaLabel(currentImages));

        var grid = $('#imagesGrid');
        grid.html('');

        if (currentImages.length === 0) {
            grid.html('<div class="empty-state" style="grid-column:1/-1;"><i class="ri-image-line"></i><p>No media in this album yet.</p></div>');
            return;
        }

        currentImages.forEach(function (item, index) {
            var caption  = item.title ? '<div class="img-caption-preview">' + item.title + '</div>' : '';
            var src      = '/' + item.image;
            var video    = isVideo(item);

            var mediaEl, overlayIcon, badge;

            if (video) {
                // Video: show the video element (muted, no controls — lightbox handles playback)
                mediaEl = '<video src="' + src + '#t=0.5" muted playsinline preload="metadata" ' +
                          'style="width:100%;height:100%;object-fit:cover;pointer-events:none;"></video>';
                overlayIcon = '<i class="fa-solid fa-circle-play play-icon"></i>';
                badge = '<span class="video-badge"><i class="fa-solid fa-video" style="font-size:0.65rem;"></i> Video</span>';
            } else {
                mediaEl     = '<img src="' + src + '" alt="' + (item.title || '') + '" loading="lazy">';
                overlayIcon = '<i class="fa-solid fa-magnifying-glass-plus zoom-icon"></i>';
                badge       = '';
            }

            grid.append(
                '<div class="gallery-item" data-index="' + index + '">' +
                    mediaEl +
                    badge +
                    '<div class="gallery-overlay">' +
                        overlayIcon +
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

    // ── Grid item click → lightbox ───────────────────
    $(document).on('click', '.gallery-item', function () {
        openLightbox(parseInt($(this).data('index')));
    });

    // ── Lightbox open ────────────────────────────────
    function openLightbox(index) {
        currentIndex = index;
        showLightboxItem();
        $('#lightbox').addClass('is-open');
    }

    function showLightboxItem() {
        var item  = currentImages[currentIndex];
        var src   = '/' + item.image;
        var video = isVideo(item);

        // Stop any playing video first
        var $vid = $('#lightboxVideo');
        $vid[0].pause();
        $vid[0].currentTime = 0;

        if (video) {
            $('#lightboxImg').hide().attr('src', '');
            $('#lightboxVideoSrc').attr('src', src);
            $vid[0].load();
            $vid.show();
        } else {
            $vid.hide();
            $('#lightboxVideoSrc').attr('src', '');
            $('#lightboxImg').attr('src', src).show();
        }

        $('#lightboxCaption').text(item.title || '');
    }

    function closeLightbox() {
        // Pause video on close
        var $vid = $('#lightboxVideo');
        $vid[0].pause();
        $vid[0].currentTime = 0;
        $('#lightbox').removeClass('is-open');
    }

    function lightboxNav(dir) {
        currentIndex = (currentIndex + dir + currentImages.length) % currentImages.length;
        showLightboxItem();
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