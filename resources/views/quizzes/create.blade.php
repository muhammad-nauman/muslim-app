@extends('layouts.app')

@section('title') Add Quiz @endsection
@section('css')
<link href="{{ url('/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <a href="{{ route('contents.index') }}" class="btn btn-success btn-lg">All Quizzes</a>
    <h1>New Quiz</h1>
    <form class="form-horizontal" method="POST" action="{{ route('quizzes.store') }}">
        
        {{ csrf_field() }}
        <div class="form-group @error('category_id') has-error @enderror"><label class="col-lg-2 control-label">Category</label>
            <div class="col-lg-7">
                <select class="form-control m-b required" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if( old('category_id') == $category->id) selected @endif >{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group @error('name') has-error @enderror"><label class="col-lg-2 control-label">Name</label>
            <div class="col-lg-7">
                <input type="text" name="name" placeholder="Name of Quiz" class="form-control" value="{{ old('name') }}">
                @error('name')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group @error('no_of_questions') has-error @enderror"><label class="col-lg-2 control-label">Number of Questions</label>
            <div class="col-lg-7">
                <input type="number" class="form-control" placeholder="Number of Quesions in a quiz" name="no_of_questions" value="{{ old('no_of_questions') }}" >
                @error('no_of_questions')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button class="btn btn-primary" type="submit">Next</button>
                <small>Questions will be created in the next step.</small>
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

<!-- iCheck -->
<script src="{{ url('/js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ url('/js/plugins/summernote/summernote.min.js') }}"></script>

@endsection

@section('script_code')

<script>
    function checkSelectedTypeOption() {
        const selected = $('#content_type option:selected').val()
        if(selected === 'audio') {
            $('div.audio').removeClass('pace-inactive')
            $('div.article').addClass('pace-inactive')
        }
        if(selected === 'article') {
            $('div.audio').addClass('pace-inactive')
            $('div.article').removeClass('pace-inactive')
        }
        if(selected === '') {
            $('div.audio').addClass('pace-inactive')
            $('div.article').addClass('pace-inactive')
        }
    }
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write Article Content here',
        });

        checkSelectedTypeOption();
        $(document).on('change', '#content_type', function() {
            checkSelectedTypeOption();
        });
    });
</script>
@endsection
</body>

</html>