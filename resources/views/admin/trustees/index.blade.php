@extends('admin.pages.master')
@section('title', 'Trustees Management')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn"><i class="ri-add-line me-1"></i> Add New Trustee</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header">
                        <h4 id="cardTitle">Add New Trustee</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Dr. Rahman Ahmed">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role/Designation <span class="text-danger">*</span></label>
                                    <input type="text" id="role" name="role" class="form-control" placeholder="e.g. Chairperson">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Initials (Manual Override)</label>
                                    <input type="text" id="initials" name="initials" class="form-control" placeholder="e.g. DA (Leave blank for auto-generate)">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profile Photo</label>
                                    <input type="file" id="trustee_image" name="image" class="form-control" accept="image/*">
                                    <div id="imagePreviewBox" class="mt-2" style="display:none;">
                                        <img id="imagePreview" src="" width="80" height="80"
                                            style="border-radius:50%; object-fit:cover; border:3px solid #dee2e6;">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" id="order_by" name="order_by" class="form-control" value="0">
                                    <small class="text-muted">Lower numbers appear first (e.g., 1 for Chair, 2 for Vice-Chair)</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Biography <span class="text-danger">*</span></label>
                                <textarea id="bio" name="bio" class="form-control" rows="4" placeholder="Brief description of the trustee's background..."></textarea>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">Save Trustee</button>
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
                <h4 class="card-title mb-0">Board of Trustees</h4>
            </div>
            <div class="card-body">
                <table id="trusteeTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Initials</th>
                            <th>Name</th>
                            <th>Role</th>
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

            var table = $('#trusteeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('trustee.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { 
                        data: 'initials', 
                        name: 'initials',
                        render: function(data) {
                            return `<div class="avatar-sm d-inline-block">
                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary fw-bold" style="padding: 10px;">${data}</span>
                                    </div>`;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'role', name: 'role' },
                    { data: 'order_by', name: 'order_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#cardTitle').text('Add New Trustee');
                $('#addBtn').val('Create').text('Save Trustee');
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
                var url = $(btn).val() === 'Create' ? "{{ route('trustee.store') }}" : "{{ route('trustee.update') }}";
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
                $.get("{{ url('/admin/trustee') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#name').val(res.name);
                    $('#role').val(res.role);
                    $('#initials').val(res.initials);
                    $('#order_by').val(res.order_by);
                    $('#bio').val(res.bio);

                    if (res.image) {
                        $('#imagePreview').attr('src', '/' + res.image);
                        $('#imagePreviewBox').show();
                    } else {
                        $('#imagePreviewBox').hide();
                    }


                    $('#cardTitle').text('Update Trustee Info');
                    $('#addBtn').val('Update').text('Update Trustee');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();
                });
            });

            // Delete Logic
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Are you sure you want to remove this trustee?')) return;
                $.ajax({
                    url: $(this).data('delete-url'),
                    type: 'DELETE',
                    success: function(res) {
                        showSuccess(res.message);
                        table.ajax.reload(null, false);
                    }
                });
            });

            // Live preview on file select
            $('#trustee_image').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreviewBox').show();
                    };
                    reader.readAsDataURL(file);
                }
            });



        });
    </script>
@endsection