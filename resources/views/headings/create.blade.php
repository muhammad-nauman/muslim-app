@extends('layouts.app')

@section('title') Add Heading @endsection
@section('css')
    <link href="{{ url('/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ url('/css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('headings.index') }}" class="btn btn-primary">All Headings</a>
            <h1>New Content</h1>
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('headings.store') }}">

                {{ csrf_field() }}

                <div class="form-group @error('content') has-error @enderror  article"><label class="col-lg-2 control-label">Article Content</label>
                    <div class="col-lg-7">
                        <textarea id="summernote" name="content"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script_files')

    <!-- Mainly scripts -->
    <script src="{{ url('/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ url('/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('/js/inspinia.js') }}"></script>
    <script src="{{ url('/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ url('/js/plugins/summernote/summernote.min.js') }}"></script>

@endsection

@section('script_code')

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write Article Content here',
            });
        });

    </script>
    @endsection
    </body>

    </html>
