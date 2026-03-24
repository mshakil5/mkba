@extends('admin.pages.master')
@section('title', 'Blog Management')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .badge-community { background-color: #0d6efd; color: white; }
        .badge-announcement { background-color: #ffc107; color: black; }
        .badge-culture { background-color: #198754; color: white; }
        .note-editable { background-color: white !important; color: black !important; }
    </style>
@endsection

@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn"><i class="ri-add-line me-1"></i> Create New Post</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 id="cardTitle" class="mb-0">Create New Blog Post</h4>
                        <button type="button" id="FormCloseBtn" class="btn-close"></button>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter title here...">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Full Description/Content <span class="text-danger">*</span></label>
                                        <textarea id="description" name="description" class="summernote"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Short Summary (Excerpt)</label>
                                        <textarea id="summary" name="summary" class="form-control" rows="3" placeholder="Brief summary for the blog card..."></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card bg-light border">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                                <select id="category" name="category" class="form-select">
                                                    <option value="community">Community</option>
                                                    <option value="announcement">Announcement</option>
                                                    <option value="culture">Culture</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Author</label>
                                                <input type="text" id="author" name="author" class="form-control" value="MKBA Editorial Team">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Post Date <span class="text-danger">*</span></label>
                                                <input type="date" id="post_date" name="post_date" class="form-control" value="{{ date('Y-m-d') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Thumbnail Image <span class="text-danger">*</span></label>
                                                <input type="file" id="image" name="image" class="form-control">
                                                <div id="imagePreview" class="mt-2 text-center"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-light border mt-3">
                                        <div class="card-header bg-soft-info text-info fw-bold">SEO Settings</div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <label class="form-label small">Meta Title</label>
                                                <input type="text" id="meta_title" name="meta_title" class="form-control form-control-sm">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Meta Keywords</label>
                                                <input type="text" id="meta_keywords" name="meta_keywords" class="form-control form-control-sm">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label small">Meta Description</label>
                                                <textarea id="meta_description" name="meta_description" class="form-control form-control-sm" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-end border-top pt-3">
                                <button type="button" id="addBtn" class="btn btn-success px-5" value="Create">Publish Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-body">
                <table id="blogTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <script>
        $(function() {
            // Initialize Summernote
            $('.summernote').summernote({
                placeholder: 'Write your blog content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var table = $('#blogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('blog.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { 
                        data: 'category', 
                        render: function(data) {
                            return `<span class="badge badge-${data}">${data.toUpperCase()}</span>`;
                        }
                    },
                    { data: 'post_date', name: 'post_date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('.summernote').summernote('code', ''); // Clear summernote
                $('#codeid').val('');
                $('#imagePreview').html('');
                $('#cardTitle').text('Create New Blog Post');
                $('#addBtn').val('Create').text('Publish Post');
                $('#addThisFormContainer').show(300);
                $('#newBtn').hide();
            });

            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show(100);
            });

            $('#addBtn').click(function() {
                var btn = this;
                var url = $(btn).val() === 'Create' ? "{{ route('blog.store') }}" : "{{ route('blog.update') }}";
                var fd = new FormData(document.getElementById('createThisForm'));

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        showSuccess(res.message);
                        $('#addThisFormContainer').hide();
                        $('#newBtn').show();
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                    }
                });
            });

            $(document).on('click', '.EditBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/blog') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#title').val(res.title);
                    $('#category').val(res.category);
                    $('#author').val(res.author);
                    $('#post_date').val(res.post_date);
                    $('#summary').val(res.summary);
                    $('.summernote').summernote('code', res.description); // Load to summernote
                    
                    $('#meta_title').val(res.meta_title);
                    $('#meta_keywords').val(res.meta_keywords);
                    $('#meta_description').val(res.meta_description);

                    if(res.image) {
                        $('#imagePreview').html(`<img src="/${res.image}" width="150" class="img-thumbnail mt-2">`);
                    }

                    $('#cardTitle').text('Update Blog Post');
                    $('#addBtn').val('Update').text('Update Post');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();
                });
            });

            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Are you sure you want to delete this blog?')) return;
                $.ajax({
                    url: $(this).data('delete-url'),
                    type: 'DELETE',
                    success: function(res) {
                        showSuccess(res.message);
                        table.ajax.reload(null, false);
                    }
                });
            });
        });
    </script>
@endsection