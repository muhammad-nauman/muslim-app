@extends('layouts.app')

@section('title') Add Category @endsection
@section('css')
<link href="{{ url('/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <a href="{{ route('categories.index') }}" class="btn btn-success btn-lg">All Categories</a>
    <h1>New Category</h1>
    <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}">
        {{ csrf_field() }}
        <div class="form-group @error('name') has-error @enderror"><label class="col-lg-2 control-label">Name</label>
            <div class="col-lg-7">
                <input type="text" name="name" placeholder="Category Name" class="form-control">
                @error('name')
                <span class="help-block text-red m-b-none">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Is Active?</label>
            <div class="col-sm-10">
                <div class="i-checks">
                    <label>
                        <input type="checkbox" name="is_active" value="yes">
                        <i></i> 
                    </label>
                </div>
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

<!-- iCheck -->
<script src="{{ url('/js/plugins/iCheck/icheck.min.js') }}"></script>

@endsection

@section('script_code')

<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
@endsection
</body>

</html>