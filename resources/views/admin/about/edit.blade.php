@extends('admin.pages.master')
@section('title', 'Edit About Us Content')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white">Main Page Content</h4>
                </div>
                <div class="card-body">
                    <form id="aboutUpdateForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtitle (Label)</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ $about->subtitle ?? 'WHO WE ARE' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $about->title ?? 'A Home Away From Home' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Main Description</label>
                                <textarea name="description" class="summernote">{{ $about->description ?? '' }}</textarea>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Section Image</label>
                                <input type="file" name="image" class="form-control">
                                @if(isset($about->image))
                                    <img src="{{ asset($about->image) }}" width="150" class="mt-2 img-thumbnail">
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="text-success mb-3">Mission, Vision & Values</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Our Mission</label>
                                <textarea name="mission" class="form-control" rows="4">{{ $about->mission ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Our Vision</label>
                                <textarea name="vision" class="form-control" rows="4">{{ $about->vision ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Our Values</label>
                                <textarea name="values" class="form-control" rows="4">{{ $about->values ?? '' }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="text-info mb-3">SEO Configuration</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ $about->meta_title ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ $about->meta_keywords ?? '' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2">{{ $about->meta_description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" id="submitAboutBtn" class="btn btn-primary px-5">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({ height: 200 });

        $('#submitAboutBtn').click(function() {
            var fd = new FormData($('#aboutUpdateForm')[0]);
            $.ajax({
                url: "{{ route('admin.about.update') }}",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(res) {
                    showSuccess(res.message);
                },
                error: function(xhr) {
                    showError("Check required fields.");
                }
            });
        });
    });
</script>
@endsection