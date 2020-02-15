@extends('layouts.app')

@section('title') Add Question @endsection

@section('css')

<link href="{{ url('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection

@section('content')
<a href="{{ route('quizzes.create') }}" class="btn btn-primary">All Quizzes</a>
@if($questions->count() < $quiz->no_of_questions)
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
        <h2>Add Question # <strong>{{ $questions->count() + 1 }}</strong> For <strong>{{ $quiz->name }}</strong></h2>
            <div class="ibox-content" style="background-color:#dbe0d6;border-radius:5px">

                <form id="form" class="wizard-big" method="POST" action="{{ route('quizzes.questions.store', ['quiz' => $quiz->id]) }}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group @error('question') has-error @enderror">
                                    <label>Question *</label>
                                    <input id="question" name="question" type="text" class="form-control required">
                                    @error('question')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                                                <input type="radio" value="0" name="correct" data-option="0">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        First Option *
                                    </label>
                                    <input id="name" name="answers[0][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="2" name="correct" data-option="1">
                                                <i>
                                                </i>
                                            </label>
                                        </div>
                                        Third Option *
                                    </label>
                                    <input id="surname" name="answers[2][answer]" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="1" name="correct" data-option="2">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Second Option *
                                    </label>
                                    <input id="email" name="answers[1][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="3" name="correct" data-option="3">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Fourth Option *
                                    </label>
                                    <input id="address" name="answers[3][answer]" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-primary">Add Another</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endif
<h2>All Questions <strong>{{ $questions->count() }} / {{ $quiz->no_of_questions }}</strong> </h2>
<small>Questions added / Total number of questions</small>
@include('quizzes.question_block')

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
        $(document).on('mouseenter mouseleave', '.added', function(event) {
            if(event.type == 'mouseenter') $(this).find('a.edit').show(400);
            if(event.type === 'mouseleave') $(this).find('a.edit').hide(400);
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
@endsection