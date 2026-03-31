@extends('admin.pages.master')
@section('title', 'Activities Management')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn"><i class="ri-add-line me-1"></i> Add New Activity</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header">
                        <h4 id="cardTitle">Add New Activity</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Activity Title <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Annual Cricket Tournament">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select id="category" name="category" class="form-select">
                                        <option value="">Select Category</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Cultural">Cultural</option>
                                        <option value="Educational">Educational</option>
                                        <option value="Community">Community</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Activity Date <span class="text-danger">*</span></label>
                                    <input type="date" id="activity_date" name="activity_date" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Time Range (Display Text) <span class="text-danger">*</span></label>
                                    <input type="text" id="time_range" name="time_range" class="form-control" placeholder="e.g. 9:00 AM - 6:00 PM">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Activity Image</label>
                                    <input type="file" id="image" name="image" class="form-control">
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" id="location" name="location" class="form-control" placeholder="e.g. Willen Lake Sports Ground">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Briefly describe the activity..."></textarea>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-primary mb-3">SEO Configuration</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" id="meta_title" name="meta_title" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" id="meta_keyword" name="meta_keyword" class="form-control" placeholder="keyword1, keyword2">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Meta Image (Social Share)</label>
                                    <input type="file" id="meta_image" name="meta_image" class="form-control">
                                    <div id="metaImagePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">Create Activity</button>
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
                <h4 class="card-title mb-0">All Activities</h4>
            </div>
            <div class="card-body">
                <table id="activityTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Location</th>
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

            var table = $('#activityTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('activity.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { 
                        data: 'image', 
                        name: 'image',
                        render: function(data) {
                            return data ? `<img src="/${data}" width="50" class="rounded" style="object-fit: cover; height: 50px;">` : 'No Image';
                        }
                    },
                    { data: 'title', name: 'title' },
                    { 
                        data: 'category', 
                        name: 'category',
                        render: function(data) {
                            let color = 'primary';
                            if(data === 'Sports') color = 'success';
                            if(data === 'Cultural') color = 'danger';
                            if(data === 'Educational') color = 'info';
                            return `<span class="badge bg-soft-${color} text-${color} text-uppercase">${data}</span>`;
                        }
                    },
                    { data: 'activity_date', name: 'activity_date' },
                    { data: 'location', name: 'location' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#imagePreview').html('');
                $('#cardTitle').text('Add New Activity');
                $('#addBtn').val('Create').text('Create Activity');
                $('#addThisFormContainer').show(300);
                $('#newBtn').hide();
            });

            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show(100);
            });

            // Create / Update Logic
            $('#addBtn').click(function() {
                var btn = this;
                var url = $(btn).val() === 'Create' ? "{{ route('activity.store') }}" : "{{ route('activity.update') }}";
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
                            showError('Something went wrong');
                        }
                    }
                });
            });

            // Edit Logic
            $(document).on('click', '.EditBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/activity') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#title').val(res.title);
                    $('#category').val(res.category);
                    $('#activity_date').val(res.activity_date);
                    $('#time_range').val(res.time_range);
                    $('#location').val(res.location);
                    $('#description').val(res.description);

                    // SEO Fields
                    $('#meta_title').val(res.meta_title);
                    $('#meta_keyword').val(res.meta_keyword);
                    $('#meta_description').val(res.meta_description);

                    // Previews
                    if(res.image) {
                        $('#imagePreview').html(`<img src="/${res.image}" width="100" class="img-thumbnail">`);
                    }
                    if(res.meta_image) {
                        $('#metaImagePreview').html(`<img src="/${res.meta_image}" width="100" class="img-thumbnail">`);
                    }

                    $('#cardTitle').text('Update Activity');
                    $('#addBtn').val('Update').text('Update Activity');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();
                });
            });

            
        });
    </script>
@endsection