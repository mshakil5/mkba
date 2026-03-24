@extends('admin.pages.master')
@section('title', 'Gallery Management')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn"><i class="ri-add-line me-1"></i> Add New Image</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 id="cardTitle">Add New Gallery Image</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Image Title/Caption</label>
                                    <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Cricket Match 2026">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select id="category_id" name="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" id="order_by" name="order_by" class="form-control" value="0">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Gallery Image <span class="text-danger">*</span></label>
                                    <input type="file" id="image" name="image" class="form-control">
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">Upload Image</button>
                                <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Gallery Assets</h4>
            </div>
            <div class="card-body">
                <table id="galleryTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#galleryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('gallery.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { 
                        data: 'category_id', 
                        name: 'category_id',
                        render: function(data) {
                            return `<span class="badge bg-soft-info text-info">${data}</span>`;
                        }
                    },
                    { data: 'order_by', name: 'order_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#imagePreview').html('');
                $('#cardTitle').text('Add New Gallery Image');
                $('#addBtn').val('Create').text('Upload Image');
                $('#addThisFormContainer').show(300);
                $('#newBtn').hide();
            });

            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show(100);
            });

            // Store & Update Logic
            $('#addBtn').click(function() {
                var btn = this;
                var url = $(btn).val() === 'Create' ? "{{ route('gallery.store') }}" : "{{ route('gallery.update') }}";
                var form = document.getElementById('createThisForm');
                var fd = new FormData(form);

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
                        if (xhr.status === 422) {
                            showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        } else {
                            showError('Error processing request');
                        }
                    }
                });
            });

            // Edit Logic
            $(document).on('click', '.EditBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/gallery') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#title').val(res.title);
                    $('#category').val(res.category);
                    $('#order_by').val(res.order_by);

                    if(res.image) {
                        $('#imagePreview').html(`<img src="/${res.image}" width="150" class="img-thumbnail mt-2">`);
                    }

                    $('#cardTitle').text('Update Gallery Image');
                    $('#addBtn').val('Update').text('Update Image');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();
                });
            });

            // Delete Logic
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Remove this image from gallery?')) return;
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