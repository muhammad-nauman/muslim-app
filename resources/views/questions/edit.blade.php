@extends('layouts.app')

@section('title') Add Question @endsection

@section('css')

<link href="{{ url('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <h2>
                    Update Question Details
                </h2>

                <form id="form" class="wizard-big" method="POST" action="{{ route('questions.update', ['question' => $question->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h1>Question</h1>
                    <fieldset>
                        <h2>Question Information</h2>
                        <div class="row">
                            <div class="col-lg-8">
                                @include('misc.categories_select', ['selected' => $question->category_id])
                                <div class="form-group">
                                    <label>Question *</label>
                                    <input id="question" name="question" type="text" class="form-control required" value="{{ $question->question }}">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Is Active?</label>
                                    <div class="col-sm-10">
                                        <div class="i-checks">
                                            <label>
                                                <input type="checkbox" name="is_active" value="1" @if($question->is_active == 1) checked @endif>
                                                <i></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <h1>Answers</h1>
                    <fieldset>
                        <h2>Answers Information</h2>
                        <div class="alert alert-danger alert-dismissable pace-inactive">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Please select correct answer.
                            </div>
                        <small>Please mark the circle with the correct option</small>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="0" name="correct" data-option="0"
                                                    @if($question->answers[0]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        First Option *
                                    </label>
                                    <input type="hidden" name="answers[0][answer_id]" value=@if(isset($question->answers[0])){{ $question->answers[0]->id }} @endif>
                                    <input id="name" name="answers[0][answer]" type="text" class="form-control required"
                                        value="{{ $question->answers[0]->answer }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="2" name="correct" data-option="1"
                                                @if(isset($question->answers[2]) && $question->answers[2]->is_right == 1) checked @endif
                                                >
                                                <i>
                                                </i>
                                            </label>
                                        </div>
                                        Third Option *
                                    </label>
                                    <input type="hidden" name="answers[2][answer_id]" value=@if(isset($question->answers[2])){{ $question->answers[2]->id }} @endif>
                                    <input id="surname" name="answers[2][answer]" type="text" class="form-control"
                                         value=@if(isset($question->answers[2])){{ $question->answers[2]->answer }} @endif
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="1" name="correct" data-option="2"
                                                @if($question->answers[1]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Second Option *
                                    </label>
                                    <input type="hidden" name="answers[1][answer_id]" value=@if(isset($question->answers[1])){{ $question->answers[1]->id }} @endif>
                                    <input id="email" name="answers[1][answer]" type="text" class="form-control required"
                                        value="{{ $question->answers[1]->answer }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="3" name="correct" data-option="3"
                                                @if(isset($question->answers[3]) && $question->answers[3]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Fourth Option *
                                    </label>
                                    <input type="hidden" name="answers[3][answer_id]" value=@if(isset($question->answers[3])){{ $question->answers[3]->id }} @endif>
                                    <input id="address" name="answers[3][answer]" type="text" class="form-control"
                                    value=@if(isset($question->answers[3])){{ $question->answers[3]->answer }} @endif
                                    >
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
<!-- iCheck -->
<script src="{{ url('/js/plugins/iCheck/icheck.min.js') }}"></script>
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
                // return true;
                return form.valid();
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

                if(! $('input[type=radio]').is(':checked')) {
                    $('.alert-dismissable').removeClass('pace-inactive');
                    return;
                }

                console.log(form);

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
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
@endsection