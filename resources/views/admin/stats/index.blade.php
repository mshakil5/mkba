@extends('admin.pages.master')
@section('title', 'Manage Stats')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <button class="btn btn-primary mb-3" id="newBtn"><i class="ri-add-line"></i> Add Stat</button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="card">
            <div class="card-body">
                <form id="createThisForm">
                    @csrf
                    <input type="hidden" id="codeid" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Select Icon</label>
                            <select id="icon_class" name="icon_class" class="form-control select2" style="width:100%;" required>
                                <option value="">-- Choose an Icon --</option>
                                
                                <!-- People & Community -->
                                <optgroup label="People & Community">
                                    <option value="fa-solid fa-users-line">Users Line</option>
                                    <option value="fa-solid fa-users">Users</option>
                                    <option value="fa-solid fa-people-group">People Group</option>
                                    <option value="fa-solid fa-user-group">User Group</option>
                                    <option value="fa-solid fa-child">Child</option>
                                    <option value="fa-solid fa-person">Person</option>
                                </optgroup>
                                
                                <!-- Events & Time -->
                                <optgroup label="Events & Time">
                                    <option value="fa-solid fa-calendar-check">Calendar Check</option>
                                    <option value="fa-solid fa-calendar-days">Calendar Days</option>
                                    <option value="fa-solid fa-clock">Clock</option>
                                    <option value="fa-solid fa-hourglass-half">Hourglass</option>
                                </optgroup>
                                
                                <!-- Health & Care -->
                                <optgroup label="Health & Care">
                                    <option value="fa-solid fa-heart-pulse">Heart Pulse</option>
                                    <option value="fa-solid fa-hand-holding-heart">Holding Heart</option>
                                    <option value="fa-solid fa-heart">Heart</option>
                                    <option value="fa-solid fa-hospital">Hospital</option>
                                    <option value="fa-solid fa-stethoscope">Stethoscope</option>
                                    <option value="fa-solid fa-wheelchair">Wheelchair</option>
                                </optgroup>
                                
                                <!-- Achievement & Success -->
                                <optgroup label="Achievement & Success">
                                    <option value="fa-solid fa-award">Award</option>
                                    <option value="fa-solid fa-trophy">Trophy</option>
                                    <option value="fa-solid fa-star">Star</option>
                                    <option value="fa-solid fa-medal">Medal</option>
                                    <option value="fa-solid fa-certificate">Certificate</option>
                                </optgroup>
                                
                                <!-- Business & Growth -->
                                <optgroup label="Business & Growth">
                                    <option value="fa-solid fa-chart-line">Chart Line</option>
                                    <option value="fa-solid fa-chart-bar">Chart Bar</option>
                                    <option value="fa-solid fa-briefcase">Briefcase</option>
                                    <option value="fa-solid fa-building">Building</option>
                                    <option value="fa-solid fa-coins">Coins</option>
                                    <option value="fa-solid fa-hand-holding-dollar">Holding Dollar</option>
                                </optgroup>
                                
                                <!-- Education & Knowledge -->
                                <optgroup label="Education & Knowledge">
                                    <option value="fa-solid fa-graduation-cap">Graduation Cap</option>
                                    <option value="fa-solid fa-book-open">Book Open</option>
                                    <option value="fa-solid fa-lightbulb">Lightbulb</option>
                                </optgroup>
                                
                                <!-- Global & Places -->
                                <optgroup label="Global & Places">
                                    <option value="fa-solid fa-globe">Globe</option>
                                    <option value="fa-solid fa-earth-americas">Earth Americas</option>
                                    <option value="fa-solid fa-location-dot">Location Dot</option>
                                    <option value="fa-solid fa-house">House</option>
                                </optgroup>
                                
                                <!-- Misc -->
                                <optgroup label="Miscellaneous">
                                    <option value="fa-solid fa-handshake">Handshake</option>
                                    <option value="fa-solid fa-bullhorn">Bullhorn</option>
                                    <option value="fa-solid fa-dove">Dove</option>
                                    <option value="fa-solid fa-check-circle">Check Circle</option>
                                    <option value="fa-solid fa-folder-open">Folder Open</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Icon Preview</label>
                            <div class="p-3 border rounded d-flex align-items-center justify-content-center" id="iconPreview" style="min-height:60px; background:#f8f9fa;">
                                <span class="text-muted small">Select an icon to preview</span>
                            </div>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label>Count / Number</label>
                            <input type="text" id="count" name="count" class="form-control" placeholder="e.g., 2,000+">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Label</label>
                            <input type="text" id="label" name="label" class="form-control" placeholder="e.g., Community Members">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Display Order</label>
                            <input type="number" id="order_by" name="order_by" class="form-control" value="0">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" id="addBtn" class="btn btn-primary" value="Create">Save Stat</button>
                        <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="statsTable" class="table table-bordered align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Icon</th>
                            <th>Count</th>
                            <th>Label</th>
                            <th>Order</th>
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
            var table = $('#statsTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('stats.index') }}",
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'icon_preview' },
                    { data: 'count' },
                    { data: 'label' },
                    { data: 'order_by' },
                    { data: 'status' },
                    { data: 'action', orderable: false }
                ]
            });

            
            // Live icon preview on dropdown change
            $('#icon_class').on('change', function() {
                var icon = $(this).val();
                if (icon) {
                    $('#iconPreview').html('<i class="' + icon + ' fs-3" style="color:#ff4d4d;"></i>');
                } else {
                    $('#iconPreview').html('<span class="text-muted small">Select an icon to preview</span>');
                }
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#is_active').prop('checked', true);
                $('#iconPreview').html('<i class="fa-solid fa-question fs-3 text-muted"></i>');
                $('#addBtn').val('Create');
                $('#addThisFormContainer').show(300);
                $(this).hide();
            });

            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show();
            });

            $('#addBtn').click(function() {
                var url = $(this).val() === 'Create' 
                    ? "{{ route('stats.store') }}" 
                    : "{{ route('stats.update') }}";
                
                $.post(url, $('#createThisForm').serialize(), function(res) {
                    showSuccess(res.message);
                    setTimeout(function() {
                        resetForm();
                    }, 3000);
                    $('#addThisFormContainer').hide();
                    $('#newBtn').show();
                    table.ajax.reload();
                }).fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val) {
                        showError(val[0]);
                        return false;
                    });
                });
            });

            $(document).on('click', '.EditBtn', function() {
                $.get("{{ url('/admin/stats') }}/" + $(this).data('id') + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#icon_class').val(res.icon_class);
                    $('#count').val(res.count);
                    $('#label').val(res.label);
                    $('#order_by').val(res.order_by);
                    $('#is_active').prop('checked', res.is_active == 1);
                    $('#iconPreview').html('<i class="' + res.icon_class + ' fs-3" style="color:#ff4d4d;"></i>');
                    $('#addBtn').val('Update');
                    $('#addThisFormContainer').show(300);
                });
            });
        });
    </script>
@endsection