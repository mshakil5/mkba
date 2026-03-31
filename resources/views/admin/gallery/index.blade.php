@extends('admin.pages.master')
@section('title', 'Gallery Management')
@section('content')

{{-- ── Tab Navigation ─────────────────────────── --}}
<div class="container-fluid">
    <ul class="nav nav-tabs mb-3" id="galleryTab">
        <li class="nav-item">
            <button class="nav-link active" data-tab="albums">
                <i class="ri-folder-image-line me-1"></i> Albums
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-tab="images" id="imagesTabBtn" style="display:none;">
                <i class="ri-image-line me-1"></i> Images: <strong id="currentAlbumName"></strong>
                <span class="ms-2 badge bg-secondary" id="backToAlbums" style="cursor:pointer;">← Back</span>
            </button>
        </li>
    </ul>
</div>

{{-- ══════════════════════════════════════════════
     ALBUMS TAB
══════════════════════════════════════════════ --}}
<div id="albumsTab">

    {{-- Add Album Form --}}
    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-auto">
                <button class="btn btn-primary" id="newAlbumBtn">
                    <i class="ri-add-line me-1"></i> Add New Album
                </button>
            </div>
        </div>
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
                            <th>Sl</th>
                            <th>Cover</th>
                            <th>Album Name</th>
                            <th>Images</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     IMAGES TAB
══════════════════════════════════════════════ --}}
<div id="imagesTab" style="display:none;">

    {{-- Upload Form --}}
    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-auto">
                <button class="btn btn-success" id="newImageBtn">
                    <i class="ri-upload-2-line me-1"></i> Upload Images
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="imageFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header"><h4 id="imageFormTitle">Upload Images</h4></div>
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

                            {{-- Multiple upload (hidden on edit) --}}
                            <div class="mb-3" id="multiUploadBox">
                                <label class="form-label">Select Images <span class="text-danger">*</span></label>
                                <input type="file" id="imagesInput" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple images. Max 5MB each.</small>
                                
                                {{-- Dynamic preview with per-image caption --}}
                                <div id="multiPreview" class="mt-3 d-flex flex-wrap gap-3"></div>
                            </div>

                            {{-- Single replace (shown on edit) --}}
                            <div class="mb-3" id="singleUploadBox" style="display:none;">
                                <label class="form-label">Replace Image <span class="text-muted">(optional)</span></label>
                                <input type="file" id="singleImageInput" name="image" class="form-control" accept="image/*">
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
            <div class="card-header"><h4 class="mb-0" id="imageTableTitle">Images</h4></div>
            <div class="card-body">
                <table id="imageTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Preview</th>
                            <th>Caption</th>
                            <th>Order</th>
                            <th>Action</th>
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

    // ── Album DataTable ──────────────────────────────
    var albumTable = $('#albumTable').DataTable({
        processing: true,
        serverSide: true,
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

    // ── Switch to Images tab ─────────────────────────
    function openAlbum(id, name) {
        currentCategoryId = id;
        $('#currentAlbumName').text(name);
        $('#imageCategoryId').val(id);
        $('#imageTableTitle').text('Images — ' + name);

        // Show images tab button
        $('#imagesTabBtn').show();

        // Switch tabs
        $('#albumsTab').hide();
        $('#imagesTab').show();
        $('#imageFormContainer').hide();
        $('#newImageBtn').show();

        // Init or reload image DataTable
        if (imageTable) {
            imageTable.ajax.url("{{ url('/admin/gallery') }}/" + id + "/images").load();
        } else {
            imageTable = $('#imageTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admin/gallery') }}/" + id + "/images",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'preview',     orderable: false, searchable: false },
                    { data: 'title',       defaultContent: '<span class="text-muted">—</span>' },
                    { data: 'order_by' },
                    { data: 'action',      orderable: false, searchable: false }
                ]
            });
        }
    }

    // ── Back to Albums ───────────────────────────────
    $('#backToAlbums').click(function () {
        $('#imagesTab').hide();
        $('#albumsTab').show();
        $('#imagesTabBtn').hide();
        albumTable.ajax.reload(null, false);
    });

    // ── Manage Images button in album table ──────────
    $(document).on('click', '.ManageBtn', function () {
        openAlbum($(this).data('id'), $(this).data('name'));
    });

    // ════════════════════════════════════════════════
    // ALBUM CRUD
    // ════════════════════════════════════════════════

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
            url: url, type: 'POST',
            data: $('#albumForm').serialize(),
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



    // ════════════════════════════════════════════════
    // IMAGE CRUD
    // ════════════════════════════════════════════════

    $('#newImageBtn').click(function () {
        $('#imageForm')[0].reset();
        $('#imageId').val('');
        $('#multiPreview').html('');
        $('#singlePreview').html('');
        $('#multiUploadBox').show();
        $('#singleUploadBox').hide();
        $('#imageFormTitle').text('Upload Images');
        $('#saveImageBtn').val('Create').text('Upload');
        $('#imageFormContainer').show(300);
        $(this).hide();
    });

    $('#cancelImageBtn').click(function () {
        $('#imageFormContainer').hide(200);
        $('#newImageBtn').show();
    });

    // Multiple image preview
    $('#imagesInput').on('change', function () {
        $('#multiPreview').html('');
        Array.from(this.files).forEach(function (file, index) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#multiPreview').append(`
                    <div style="width:140px;">
                        <img src="${e.target.result}" 
                            style="width:140px; height:110px; object-fit:cover; border-radius:8px; border:2px solid #dee2e6;">
                        <textarea name="captions[]" 
          class="form-control form-control-sm mt-1" 
          placeholder="Caption (optional)"
          rows="2"
          style="font-size:0.78rem; resize:none;"></textarea>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // Single image preview (edit mode)
    $('#singleImageInput').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#singlePreview').html('<img src="' + e.target.result + '" width="120" class="img-thumbnail mt-1">');
        };
        reader.readAsDataURL(file);
    });

    // Save images (upload or update)
    $('#saveImageBtn').click(function () {
        var isCreate = $(this).val() === 'Create';
        var url = isCreate ? "{{ route('gallery.store') }}" : "{{ route('gallery.update') }}";
        var fd = new FormData(document.getElementById('imageForm'));

        $.ajax({
            url: url, type: 'POST',
            data: fd, contentType: false, processData: false,
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

    // Edit image
    $(document).on('click', '.EditImageBtn', function () {
        var btn = $(this);
        $('#imageId').val(btn.data('id'));
        $('#imageTitle').val(btn.data('title'));
        $('#imageOrder').val(btn.data('order'));
        $('#multiUploadBox').hide();
        $('#singleUploadBox').show();
        $('#singlePreview').html(
            '<img src="/' + btn.data('image') + '" width="120" class="img-thumbnail mt-1">'
        );
        $('#imageFormTitle').text('Edit Image');
        $('#saveImageBtn').val('Update').text('Update Image');
        $('#imageFormContainer').show(300);
        $('#newImageBtn').hide();
    });

    // Delete image
    $(document).on('click', '.deleteImageBtn', function () {
        if (!confirm('Delete this image?')) return;
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