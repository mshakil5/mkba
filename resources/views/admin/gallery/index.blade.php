@extends('admin.pages.master')
@section('title', 'Gallery Management')
@section('content')

<div class="container-fluid">
    <ul class="nav nav-tabs mb-3" id="galleryTab">
        <li class="nav-item">
            <button class="nav-link active" data-tab="albums">
                <i class="ri-folder-image-line me-1"></i> Albums
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-tab="images" id="imagesTabBtn" style="display:none;">
                <i class="ri-image-line me-1"></i> Media: <strong id="currentAlbumName"></strong>
                <span class="ms-2 badge bg-secondary" id="backToAlbums" style="cursor:pointer;">← Back</span>
            </button>
        </li>
    </ul>
</div>

{{-- ══ ALBUMS TAB ══ --}}
<div id="albumsTab">
    <div class="container-fluid mb-3">
        <button class="btn btn-primary" id="newAlbumBtn">
            <i class="ri-add-line me-1"></i> Add New Album
        </button>
    </div>

    <div class="container-fluid" id="albumFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header"><h4 id="albumFormTitle">Add New Album</h4></div>
                    <div class="card-body">
                        <form id="albumForm">
                            @csrf
                            <input type="hidden" id="albumId" name="id">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Album Name <span class="text-danger">*</span></label>
                                    <input type="text" id="albumName" name="name" class="form-control" placeholder="e.g. Cricket Tournament 2026">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" id="albumOrder" name="order_by" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" id="saveAlbumBtn" class="btn btn-primary" value="Create">Save Album</button>
                                <button type="button" id="cancelAlbumBtn" class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">All Albums</h4></div>
            <div class="card-body">
                <table id="albumTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th><th>Cover</th><th>Album Name</th>
                            <th>Media</th><th>Order</th><th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══ MEDIA TAB ══ --}}
<div id="imagesTab" style="display:none;">
    <div class="container-fluid mb-3">
        <button class="btn btn-success" id="newImageBtn">
            <i class="ri-upload-2-line me-1"></i> Upload Media
        </button>
    </div>

    <div class="container-fluid" id="imageFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header"><h4 id="imageFormTitle">Upload Media</h4></div>
                    <div class="card-body">
                        <form id="imageForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="imageId" name="id">
                            <input type="hidden" id="imageCategoryId" name="category_id">

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Caption <span class="text-muted">(optional)</span></label>
                                    <input type="text" id="imageTitle" name="title" class="form-control" placeholder="e.g. Opening Ceremony">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" id="imageOrder" name="order_by" class="form-control" value="0">
                                </div>
                            </div>

                            {{-- Multi-upload (create mode) --}}
                            <div class="mb-3" id="multiUploadBox">
                                <label class="form-label">
                                    Select Images or Videos <span class="text-danger">*</span>
                                </label>

                                {{-- Toggle buttons --}}
                                <div class="mb-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <input type="radio" class="btn-check" name="uploadType" id="typeImage" value="image" checked>
                                        <label class="btn btn-outline-success" for="typeImage">
                                            <i class="ri-image-line me-1"></i> Images
                                        </label>
                                        <input type="radio" class="btn-check" name="uploadType" id="typeVideo" value="video">
                                        <label class="btn btn-outline-primary" for="typeVideo">
                                            <i class="ri-video-line me-1"></i> Videos
                                        </label>
                                        <input type="radio" class="btn-check" name="uploadType" id="typeBoth" value="both">
                                        <label class="btn btn-outline-secondary" for="typeBoth">
                                            <i class="ri-file-line me-1"></i> Both
                                        </label>
                                    </div>
                                </div>

                                <input type="file" id="filesInput" name="files[]" class="form-control" multiple
                                       accept="image/*">
                                <small class="text-muted">
                                    Images: JPG, PNG, GIF, WebP — max 5 MB each. &nbsp;|&nbsp;
                                    Videos: MP4, MOV, AVI, WebM — max 50 MB each.
                                </small>

                                <div id="multiPreview" class="mt-3 d-flex flex-wrap gap-3"></div>
                            </div>

                            {{-- Single replace (edit mode) --}}
                            <div class="mb-3" id="singleUploadBox" style="display:none;">
                                <label class="form-label">Replace File <span class="text-muted">(optional)</span></label>
                                <input type="file" id="singleFileInput" name="file" class="form-control"
                                       accept="image/*,video/mp4,video/quicktime,video/webm,video/x-msvideo">
                                <div id="singlePreview" class="mt-2"></div>
                            </div>

                            <div class="text-end">
                                <button type="button" id="saveImageBtn" class="btn btn-success" value="Create">Upload</button>
                                <button type="button" id="cancelImageBtn" class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h4 class="mb-0" id="imageTableTitle">Media</h4></div>
            <div class="card-body">
                <table id="imageTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th><th>Preview</th><th>Type</th>
                            <th>Caption</th><th>Order</th><th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var currentCategoryId = null;
    var imageTable = null;

    // ── Accept filter based on upload type toggle ────
    $('input[name="uploadType"]').on('change', function () {
        var val = $(this).val();
        var acceptMap = {
            image : 'image/*',
            video : 'video/mp4,video/quicktime,video/webm,video/x-msvideo',
            both  : 'image/*,video/mp4,video/quicktime,video/webm,video/x-msvideo'
        };
        $('#filesInput').attr('accept', acceptMap[val]).val('');
        $('#multiPreview').html('');
    });

    // ── Album DataTable ──────────────────────────────
    var albumTable = $('#albumTable').DataTable({
        processing: true, serverSide: true,
        ajax: "{{ route('gallery.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'cover',       orderable: false, searchable: false },
            { data: 'name' },
            { data: 'galleries_count', name: 'galleries_count' },
            { data: 'order_by' },
            { data: 'action',      orderable: false, searchable: false }
        ]
    });

    // ── Open album → media tab ───────────────────────
    function openAlbum(id, name) {
        currentCategoryId = id;
        $('#currentAlbumName').text(name);
        $('#imageCategoryId').val(id);
        $('#imageTableTitle').text('Media — ' + name);
        $('#imagesTabBtn').show();
        $('#albumsTab').hide();
        $('#imagesTab').show();
        $('#imageFormContainer').hide();
        $('#newImageBtn').show();

        if (imageTable) {
            imageTable.ajax.url("{{ url('/admin/gallery') }}/" + id + "/images").load();
        } else {
            imageTable = $('#imageTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ url('/admin/gallery') }}/" + id + "/images",
                columns: [
                    { data: 'DT_RowIndex',  orderable: false, searchable: false },
                    { data: 'preview',      orderable: false, searchable: false },
                    { data: 'type_badge',   orderable: false, searchable: false },
                    { data: 'title',        defaultContent: '<span class="text-muted">—</span>' },
                    { data: 'order_by' },
                    { data: 'action',       orderable: false, searchable: false }
                ]
            });
        }
    }

    $('#backToAlbums').click(function () {
        $('#imagesTab').hide();
        $('#albumsTab').show();
        $('#imagesTabBtn').hide();
        albumTable.ajax.reload(null, false);
    });

    $(document).on('click', '.ManageBtn', function () {
        openAlbum($(this).data('id'), $(this).data('name'));
    });

    // ── Album CRUD ───────────────────────────────────
    $('#newAlbumBtn').click(function () {
        $('#albumForm')[0].reset();
        $('#albumId').val('');
        $('#albumFormTitle').text('Add New Album');
        $('#saveAlbumBtn').val('Create').text('Save Album');
        $('#albumFormContainer').show(300);
        $(this).hide();
    });

    $('#cancelAlbumBtn').click(function () {
        $('#albumFormContainer').hide(200);
        $('#newAlbumBtn').show();
    });

    $('#saveAlbumBtn').click(function () {
        var isCreate = $(this).val() === 'Create';
        var url = isCreate ? "{{ route('gallery.album.store') }}" : "{{ route('gallery.album.update') }}";
        $.ajax({
            url: url, type: 'POST', data: $('#albumForm').serialize(),
            success: function (res) {
                showSuccess(res.message);
                $('#albumFormContainer').hide();
                $('#newAlbumBtn').show();
                albumTable.ajax.reload(null, false);
            },
            error: function (xhr) {
                showError(xhr.status === 422
                    ? Object.values(xhr.responseJSON.errors)[0][0]
                    : 'Something went wrong');
            }
        });
    });

    $(document).on('click', '.EditAlbumBtn', function () {
        $('#albumId').val($(this).data('id'));
        $('#albumName').val($(this).data('name'));
        $('#albumOrder').val($(this).data('order'));
        $('#albumFormTitle').text('Update Album');
        $('#saveAlbumBtn').val('Update').text('Update Album');
        $('#albumFormContainer').show(300);
        $('#newAlbumBtn').hide();
    });

    // ── Media CRUD ───────────────────────────────────
    $('#newImageBtn').click(function () {
        $('#imageForm')[0].reset();
        $('#imageId').val('');
        $('#multiPreview').html('');
        $('#singlePreview').html('');
        $('#multiUploadBox').show();
        $('#singleUploadBox').hide();
        $('#imageFormTitle').text('Upload Media');
        $('#saveImageBtn').val('Create').text('Upload');
        $('#imageFormContainer').show(300);
        $(this).hide();
    });

    $('#cancelImageBtn').click(function () {
        $('#imageFormContainer').hide(200);
        $('#newImageBtn').show();
    });

    // ── Multi-file preview (images + videos) ─────────
    $('#filesInput').on('change', function () {
        $('#multiPreview').html('');
        Array.from(this.files).forEach(function (file, index) {
            var isVideo = file.type.startsWith('video/');
            var url = URL.createObjectURL(file);

            var mediaTag = isVideo
                ? `<video src="${url}" style="width:140px;height:110px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;" muted playsinline></video>`
                : `<img src="${url}" style="width:140px;height:110px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;">`;

            var badge = isVideo
                ? `<span class="badge bg-primary mb-1"><i class="ri-video-line"></i> Video</span>`
                : `<span class="badge bg-success mb-1"><i class="ri-image-line"></i> Image</span>`;

            $('#multiPreview').append(`
                <div style="width:140px;">
                    ${badge}
                    ${mediaTag}
                    <textarea name="captions[]" class="form-control form-control-sm mt-1"
                        placeholder="Caption (optional)" rows="2"
                        style="font-size:0.78rem;resize:none;"></textarea>
                </div>
            `);
        });
    });

    // ── Single file preview (edit mode) ─────────────
    $('#singleFileInput').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var url = URL.createObjectURL(file);
        var isVideo = file.type.startsWith('video/');
        var tag = isVideo
            ? `<video src="${url}" width="160" class="img-thumbnail mt-1" controls muted></video>`
            : `<img src="${url}" width="160" class="img-thumbnail mt-1">`;
        $('#singlePreview').html(tag);
    });

    // ── Save media ───────────────────────────────────
    $('#saveImageBtn').click(function () {
        var isCreate = $(this).val() === 'Create';
        var url = isCreate ? "{{ route('gallery.store') }}" : "{{ route('gallery.update') }}";
        var fd = new FormData(document.getElementById('imageForm'));

        $.ajax({
            url: url, type: 'POST', data: fd,
            contentType: false, processData: false,
            success: function (res) {
                showSuccess(res.message);
                $('#imageFormContainer').hide();
                $('#newImageBtn').show();
                imageTable.ajax.reload(null, false);
            },
            error: function (xhr) {
                showError(xhr.status === 422
                    ? Object.values(xhr.responseJSON.errors)[0][0]
                    : 'Something went wrong');
            }
        });
    });

    // ── Edit media ───────────────────────────────────
    $(document).on('click', '.EditImageBtn', function () {
        var btn = $(this);
        var type = btn.data('type');  // 'image' or 'video'
        $('#imageId').val(btn.data('id'));
        $('#imageTitle').val(btn.data('title'));
        $('#imageOrder').val(btn.data('order'));
        $('#multiUploadBox').hide();
        $('#singleUploadBox').show();

        var currentSrc = '/' + btn.data('image');
        var preview = type === 'video'
            ? `<video src="${currentSrc}" width="160" class="img-thumbnail mt-1" controls muted></video>`
            : `<img src="${currentSrc}" width="160" class="img-thumbnail mt-1">`;
        $('#singlePreview').html(preview);

        $('#imageFormTitle').text('Edit Media');
        $('#saveImageBtn').val('Update').text('Update');
        $('#imageFormContainer').show(300);
        $('#newImageBtn').hide();
    });

    // ── Delete media ─────────────────────────────────
    $(document).on('click', '.deleteImageBtn', function () {
        if (!confirm('Delete this file?')) return;
        $.ajax({
            url: $(this).data('delete-url'), type: 'DELETE',
            success: function (res) {
                showSuccess(res.message);
                imageTable.ajax.reload(null, false);
            }
        });
    });
});
</script>
@endsection