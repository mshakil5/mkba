@extends('admin.pages.master')
@section('title', 'Copyright')
@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">

                @if (session()->has('success'))
                    <div class="alert alert-success pt-3 mb-3" id="successMessage">{{ session()->get('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0 flex-grow-1">Copyright</h3>
                    </div>

                    <form action="{{ route('admin.copyright') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Copyright <span class="text-danger">*</span></label>
                                        <textarea name="copyright" class="form-control summernote2 @error('copyright') is-invalid @enderror"
                                            rows="4">{!! $companyDetails->copyright !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-secondary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote2').summernote({
            height: 300,
            toolbar: [
                ['style',   ['style']],
                ['font',    ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname',['fontname']],
                ['fontsize',['fontsize']],
                ['color',   ['color']],
                ['para',    ['ul', 'ol', 'paragraph']],
                ['height',  ['height']],
                ['table',   ['table']],
                ['insert',  ['link', 'picture', 'video', 'hr']],
                ['view',    ['fullscreen', 'codeview', 'undo', 'redo']],
            ],
            fontSizes: ['8','9','10','11','12','14','16','18','20','24','28','32','36','48','64'],
            lineHeights: ['1.0', '1.2', '1.4', '1.5', '1.6', '1.8', '2.0', '2.5', '3.0'],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'pre'],
        });

    });
</script>
@endsection