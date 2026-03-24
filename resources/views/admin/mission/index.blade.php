@extends('admin.pages.master')
@section('title', 'Mission Section')

@section('content')

<div class="container-fluid" id="newBtnSection">
    <button class="btn btn-primary" id="newBtn">Add Mission Item</button>
</div>

<div class="container-fluid mt-3" id="addThisFormContainer" style="display:none;">
    <div class="card">
        <div class="card-header">
            <h4 id="cardTitle">Add Mission</h4>
        </div>
        <div class="card-body">
            <form id="createThisForm">
                @csrf
                <input type="hidden" id="codeid">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label>Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Title *</label>
                        <input type="text" id="title" name="title" class="form-control">
                    </div>

                    <div class="col-md-12 mb-2">
                        <label>Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Icon (FontAwesome)</label>
                        <input type="text" id="icon" name="icon" class="form-control" placeholder="fa-solid fa-globe">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Serial</label>
                        <input type="number" id="serial" name="serial" class="form-control">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="button" id="addBtn" class="btn btn-primary" value="Create">Create</button>
                    <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Mission</h4>
            </div>
            <div class="card-body">
                <table id="missionTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Serial</th>
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
$(function(){

    var table = $('#missionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mission.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'title' },
            { data: 'icon' },
            { data: 'serial' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    $('#newBtn').click(function(){
        $('#createThisForm')[0].reset();
        $('#codeid').val('');
        $('#addBtn').val('Create').text('Create');
        $('#addThisFormContainer').show();
        $('#newBtn').hide();
    });

    $('#FormCloseBtn').click(function(){
        $('#addThisFormContainer').hide();
        $('#newBtn').show();
    });

    $('#addBtn').click(function(){
        let url = $(this).val() === 'Create'
            ? "{{ route('mission.store') }}"
            : "{{ route('mission.update') }}";

        let formData = new FormData($('#createThisForm')[0]);
        formData.append('id', $('#codeid').val());

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                showSuccess(res.message);
                table.ajax.reload();
                $('#addThisFormContainer').hide();
                $('#newBtn').show();
            }
        });
    });

    $(document).on('click','.EditBtn', function(){
        let id = $(this).data('id');

        $.get("{{ url('/admin/mission') }}/"+id+"/edit", function(res){
            $('#codeid').val(res.id);
            $('#subtitle').val(res.subtitle);
            $('#title').val(res.title);
            $('#description').val(res.description);
            $('#icon').val(res.icon);
            $('#serial').val(res.serial);
            $('#status').val(res.status);

            $('#addBtn').val('Update').text('Update');
            $('#addThisFormContainer').show();
            $('#newBtn').hide();
        });
    });

    $(document).on('click','.deleteBtn', function(){
        if(!confirm('Are you sure?')) return;

        $.ajax({
            url: $(this).data('delete-url'),
            type: "DELETE",
            success: function(res){
                showSuccess(res.message);
                table.ajax.reload();
            }
        });
    });

});
</script>
@endsection
