@extends('layouts.app')

@section('title') Add Question @endsection

@section('css')

<link href="{{ url('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <h2>
                    Add a New Question Form
                </h2>

                <form id="form" action="#" class="wizard-big">
                    {{ csrf_field() }}
                    <h1>Question</h1>
                    <fieldset>
                        <h2>Question Information</h2>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Category *</label>
                                    <select class="form-control m-b" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Question *</label>
                                    <input id="userName" name="userName" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Is Active?</label>
                                    <input id="password" name="password" type="text" class="form-control required">
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <h1>Answers</h1>
                    <fieldset>
                        <h2>Answers Information</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>First Option *</label>
                                    <input id="name" name="name" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Second Option *</label>
                                    <input id="surname" name="surname" type="text" class="form-control required">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Third Option *</label>
                                    <input id="email" name="email" type="text" class="form-control required email">
                                </div>
                                <div class="form-group">
                                    <label>Fourth Option *</label>
                                    <input id="address" name="address" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('script_files')

<!-- Mainly scripts -->
<script src="{{ url('js/jquery-2.1.1.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ url('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ url('js/inspinia.js') }}"></script>
<script src="{{ url('js/plugins/pace/pace.min.js') }}"></script>

<!-- Steps -->
<script src="{{ url('js/plugins/staps/jquery.steps.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{ url('js/plugins/validate/jquery.validate.min.js') }}"></script>
@endsection
@section('script_code')


<script>
    $(document).ready(function() {
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function(event, currentIndex, newIndex) {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex) {
                    return true;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex) {
                    // // To remove error styles
                    // $(".body:eq(" + newIndex + ") label.error", form).remove();
                    // $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                // form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return true;
                // return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2) {
                    $(this).steps("previous");
                }
            },
            onFinishing: function(event, currentIndex) {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        })
        // 


        ;
    });
</script>
@endsection