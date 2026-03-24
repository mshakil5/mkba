@extends('admin.pages.master')
@section('title', 'Events Management')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn"><i class="ri-add-line me-1"></i> Add New Event</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header">
                        <h4 id="cardTitle">Add New Event</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Pohela Boishakh 2026">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" id="category" name="category" class="form-control" placeholder="e.g. Cultural">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="Upcoming">Upcoming</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Past">Past</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" id="event_date" name="event_date" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" id="start_time" name="start_time" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">End Time</label>
                                    <input type="time" id="end_time" name="end_time" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" id="location" name="location" class="form-control" placeholder="Venue name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Event Image</label>
                                    <input type="file" id="image" name="image" class="form-control">
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Event Description <span class="text-danger">*</span></label>
                                <textarea id="description" name="description" class="form-control summernote"></textarea>
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
                                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">Create Event</button>
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
                <h4 class="card-title mb-0">All Events</h4>
            </div>
            <div class="card-body">
                <table id="eventTable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
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


            var table = $('#eventTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { 
                        data: 'image', 
                        name: 'image',
                        render: function(data) {
                            // Since 'data' now contains 'uploads/events/filename.jpg'
                            // we just prepend a forward slash to make it an absolute path from the root
                            return data ? `<img src="/${data}" width="50" class="rounded" style="object-fit: cover; height: 50px;">` : 'No Image';
                        }
                    },
                    { data: 'title', name: 'title' },
                    { data: 'event_date', name: 'event_date' },
                    { data: 'location', name: 'location' },
                    { 
                        data: 'status', 
                        name: 'status',
                        render: function(data) {
                            let color = data === 'Upcoming' ? 'info' : (data === 'Ongoing' ? 'success' : 'secondary');
                            return `<span class="badge bg-${color}">${data}</span>`;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#imagePreview').html('');
                

                $('#cardTitle').text('Add New Event');
                $('#addBtn').val('Create').text('Create Event');
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
                var url = $(btn).val() === 'Create' ? "{{ route('event.store') }}" : "{{ route('event.update') }}";
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
                $.get("{{ url('/admin/event') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#title').val(res.title);
                    $('#category').val(res.category);
                    $('#status').val(res.status);
                    $('#event_date').val(res.event_date);
                    $('#start_time').val(res.start_time);
                    $('#end_time').val(res.end_time);
                    $('#location').val(res.location);
                    $('#meta_title').val(res.meta_title);
                    $('#meta_keywords').val(res.meta_keywords);
                    $('#meta_description').val(res.meta_description);
                    $('#description').summernote('code', res.description);

                    
                    if(res.image) {
                        $('#imagePreview').html(`<img src="/storage/${res.image}" width="100" class="img-thumbnail">`);
                    }

                    $('#cardTitle').text('Update Event');
                    $('#addBtn').val('Update').text('Update Event');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();
                });
            });

            // Delete Logic
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Are you sure?')) return;
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