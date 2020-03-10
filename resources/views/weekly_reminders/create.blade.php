@extends('layouts.app')

@section('title') Add Weekly Reminder @endsection
@section('css')
<link href="{{ url('/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <a href="{{ route('weekly_reminders.index') }}" class="btn btn-primary">Reminders History</a>
    <h1>New Content</h1>
    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('weekly_reminders.store') }}">

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
        <div class="form-group @error('title') has-error @enderror"><label class="col-lg-2 control-label">Title</label>
            <div class="col-lg-7">
                <input type="text" name="title" placeholder="Title" class="form-control" value="{{ old('title') }}">
                @error('title')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group @error('author_name') has-error @enderror"><label class="col-lg-2 control-label">Author / Speaker</label>
            <div class="col-lg-7">
                <input type="text" name="author_name" placeholder="Author / Speaker Name" class="form-control" value="{{ old('author_name') }}">
                @error('author_name')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group @error('publishing_timestamp') has-error @enderror"><label class="col-lg-2 control-label">Publish Date & Time</label>
            <div class="col-lg-7">
                <input readonly type="text" name="publishing_timestamp" placeholder="Publish Date & Time" id="publishing_timestamp" class="form-control" value="{{ old('publishing_timestamp') }}">
                @error('publishing_timestamp')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
{{--        <div class="form-group @error('expiring_timestamp') has-error @enderror"><label class="col-lg-2 control-label">Expire Date & Time</label>--}}
{{--            <div class="col-lg-7">--}}
{{--                <input readonly type="text" name="expiring_timestamp" placeholder="Expire Date & Time" id="expiring_timestamp" class="form-control" value="{{ old('expiring_timestamp') }}">--}}
{{--                @error('expiring_timestamp')--}}
{{--                <span class="help-block text-red m-b-none">{{ $message }}</span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group @error('type') has-error @enderror"><label class="col-lg-2 control-label">Type</label>
            <div class="col-lg-7">
                <select class="form-control" id="content_type" name="type">
                    <option value="">Select Content Type</option>
                    <option value="audio" @if(old('type') === 'audio') selected @endif>Audio</option>
                    <option value="article" @if(old('type') === 'article') selected @endif>Article</option>
                </select>
                @error('type')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group @error('file') has-error @enderror pace-inactive audio"><label class="col-lg-2 control-label">Audio File</label>
            <div class="col-lg-7">
                <input type="file" name="file">
                @error('file')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group @error('content') has-error @enderror pace-inactive article"><label class="col-lg-2 control-label">Article Content</label>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

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
        $('#publishing_timestamp').datetimepicker({
            format: 'Y-MM-DD H:mm:ss',
            minDate: new Date(),
            sideBySide: true,
            showClose: true,
            ignoreReadonly: true,
            timeZone: "Europe/Stockholm"

        });
    });

</script>
@endsection
</body>

</html>
