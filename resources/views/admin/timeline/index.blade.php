@extends('admin.pages.master')
@section('title', 'Manage Timeline')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <button class="btn btn-primary mb-3" id="newBtn"><i class="ri-add-line"></i> Add History Event</button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="card">
            <div class="card-body">
                <form id="createThisForm">
                    @csrf
                    <input type="hidden" id="codeid" name="id">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Timeline Label</label>
                            <input type="text" id="label" name="label" class="form-control" placeholder="e.g., Founded / Growth">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="e.g., Establishment">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Display Order</label>
                            <input type="number" id="order_by" name="order_by" class="form-control" value="0">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" id="addBtn" class="btn btn-primary" value="Create">Save Event</button>
                        <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="timelineTable" class="table table-bordered align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Label</th>
                            <th>Title</th>
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
            var table = $('#timelineTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('timeline.index') }}",
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'label' },
                    { data: 'title' },
                    { data: 'order_by' },
                    { data: 'action', orderable: false }
                ]
            });

            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#addThisFormContainer').show(300);
                $(this).hide();
            });

            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show();
            });

            $('#addBtn').click(function() {
                var url = $(this).val() === 'Create' ? "{{ route('timeline.store') }}" : "{{ route('timeline.update') }}";
                $.post(url, $('#createThisForm').serialize(), function(res) {
                    showSuccess(res.message);
                    $('#addThisFormContainer').hide();
                    $('#newBtn').show();
                    table.ajax.reload();
                });
            });

            $(document).on('click', '.EditBtn', function() {
                $.get("{{ url('/admin/timeline') }}/" + $(this).data('id') + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#label').val(res.label);
                    $('#title').val(res.title);
                    $('#order_by').val(res.order_by);
                    $('#description').val(res.description);
                    $('#addBtn').val('Update');
                    $('#addThisFormContainer').show(300);
                });
            });

            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Delete this event?')) return;
                $.ajax({
                    url: $(this).data('delete-url'),
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    success: function(res) {
                        showSuccess(res.message);
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
@endsection